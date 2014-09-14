<?php
use Illuminate\Queue\Jobs\Job;
use Intervention\Image\ImageManagerStatic as Image;

require public_path() . '/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class UrlInformationsHandler {
	public function fire(Job $job, $data) {
		echo 'handler... ' . $data['id'] . "\n";

		$article = Article::findOrFail($data['id']);

		$imageUrl = '';

		if (filter_var($article->url, FILTER_VALIDATE_URL) !== false) {
			$imageUrl = $this->getImage($article->url, Config::get('extractor.stopword'));
		} else {
			$imageUrl = $article->image;
		}

		Image::configure(array('driver' => 'imagick'));

		$publicPath = public_path('i/' . $data['id']);

		if (filter_var($imageUrl, FILTER_VALIDATE_URL) !== false) {

			if (File::isDirectory($publicPath)) {
				File::deleteDirectory($publicPath);
			}

			File::makeDirectory($publicPath, 0777, true);

			if ($this->downloadImg($imageUrl, $publicPath . '/original.png')) {
				$article->image = asset('i/' . $data['id'] . '/original.png');
			}
		}

		if (!empty($article->url)) {
			$article->sourceSite    = $this->getDomain($article->url);
			$article->sourceFavicon = $this->getFavicon($article->url, $publicPath, $data['id']);
		}

		$article->updateUniques();

		if (filter_var($article->image, FILTER_VALIDATE_URL) !== false) {
			Queue::push('ImagesHandler', array('id' => $data['id']));
		}

		$job->delete();
	}

	protected function getHtmlDom($url) {
		return file_get_html($url, 0, $this->getContext());
	}

	protected function getImage($url, $stopwords) {
		$html = $this->getHtmlDom($url);

		foreach ($html->find('meta') as $element) {
			if ($element->property == "og:image") {
				return $element->content;
			}
		}

		$ration     = 0;
		$srcBiggest = false;

		foreach ($html->find('img') as $element) {
			if (!(strpos($element->src, "?") === false)) {
				continue;
			}

			if (!(strpos($element->src, "timestamp") === false)) {
				continue;
			}

			if (!$this->pathSeamsGood($element->src, $stopwords)) {
				continue;
			}

			$sizePrecise = false;
			$path        = $this->urlRel2abs($element->src, $url);

			if (!isset($element->width) || empty($element->height)) {
				$size = getimagesize($path);
			} else {
				$size        = array($element->height, $element->width);
				$sizePrecise = true;
			}

			if (is_array($size)) {
				if ($sizePrecise) {
					$tmpRatio = $size[0] * $size[1];
				} else {
					$tmpRatio = $size[0] * $size[1] * 0.7;
				}

				if ($tmpRatio > $ration && $tmpRatio < 500 * 500) {
					$ration     = $tmpRatio;
					$srcBiggest = $path;
				}
			}
		}

		return $srcBiggest;
	}

	protected function getFavicon($url, $outputFolder, $id) {
		$html = $this->getHtmlDom($url);
		foreach ($html->find('link') as $element) {
			if ($element->rel == "shortcut icon" || $element->rel == "icon") {
				if ($this->downloadImg($this->urlRel2abs($element->href, $url), $outputFolder . '/favicon.png')) {
					return asset('i/' . $id . '/favicon.png');
				}
			}
		}

		return '';
	}

	protected function downloadImg($url, $output) {
		try {
			$original = Image::make($url);
			$original->save($output);

			return true;
		} catch (Exception $e) {
			Log::info('Impossible to download ' . $url);

			return false;
		}
	}

	protected function getDomain($url) {
		$urlData = parse_url($url);

		return $urlData['host'];
	}

	protected function urlRel2abs($rel, $base) {
		if (parse_url($rel, PHP_URL_SCHEME) != '') {
			return $rel;
		}

		if (substr($rel, 0, 2) == '//') {
			return 'http:' . $rel;
		}

		if ($rel[0] == '#' || $rel[0] == '?') {
			return $base . $rel;
		}

		extract(parse_url($base));
		$path = preg_replace('#/[^/]*$#', '', $path);
		if ($rel[0] == '/') {
			$path = '';
		}

		if (parse_url($base, PHP_URL_PORT) != '') {
			$abs = "$host:" . parse_url($base, PHP_URL_PORT) . "$path/$rel";
		} else {
			$abs = "$host$path/$rel";
		}

		$re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
		for ($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {}

		return $scheme . '://' . $abs;
	}

	protected function pathSeamsGood($url, $stopwords) {
		$url = strtolower($url);
		foreach ($stopwords as $stopword) {
			if (strpos($url, strtolower($stopword)) !== false) {
				return false;
			}
		}

		return true;
	}

	protected function getContext() {
		$context = stream_context_create();
		$context = stream_context_create(array(
				'http' => array(
					'method' => "GET",
					'header' => "Accept-language: en\r\n" .
					"Cookie: foo=bar\r\n" .
					"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36\r\n"// i.e. An iPad
				)
			));

		return $context;
	}
}
