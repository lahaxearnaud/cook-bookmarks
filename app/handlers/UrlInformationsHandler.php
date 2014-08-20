<?php
use Intervention\Image\ImageManagerStatic as Image;

require dirname(__FILE__).'/simple_html_dom.php';

class UrlInformationsHandler
{
    public function fire($job, $data)
    {
        echo 'handler...';
        if ($job->attempts() > 3) {
            Log::error('Fail to handle job '.$job->getJobId().' '.print_r($data, true));
            $job->delete();

            return;
        }

        $article = Article::findOrFail($data['id']);
        $imageUrl = $this->getImage($article->url, Config::get('extractor.stopword'));

        Image::configure(array('driver' => 'imagick'));

        $publicPath = public_path('i/'.$data['id']);
        if(File::isDirectory($publicPath)) {
            File::deleteDirectory($publicPath);
        }

        File::makeDirectory($publicPath, 0777, true);

        $original = Image::make($imageUrl);
        $original->save($publicPath . '/original.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/200x200.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/100x100.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/150x150.png');

        $image = $original;
        $image->resize(32, 32);
        $image->save($publicPath . '/32x32.png');

        $article->image = asset('i/'.$data['id'].'/200x200.png');
        $article->imageMiniature = asset('i/'.$data['id'].'/32x32.png');
        $article->sourceSite = $this->getDomain($article->url);
        $article->sourceFavicon = $this->getFavicon($article->url);
        $article->updateUniques();


        $job->delete();
    }

    protected function getHtmlDom($url) {
        return file_get_html($url, 0, $this->getContext());
    }

    protected function getImage($url, $stopwords) {
        $html = $this->getHtmlDom($url);

        foreach($html->find('meta') as $element) {
            if($element->property == "og:image") {
                return $element->content;
            }
        }

        $ration = 0;
        $srcBiggest = false;

        foreach($html->find('img') as $element) {
            if(!(strpos($element->src, "?")=== false)) {
                continue;
            }


            if(!(strpos($element->src, "timestamp")=== false)) {
                continue;
            }


            if(!pathSeamsGood($element->src, $stopwords)) {
                continue;
            }

            $sizePrecise = false;
            $path = $this->urlRel2abs($element->src, $url);

            if(!isset($element->width) || empty($element->height)) {
            $size = getimagesize($path);
            }else{
            $size = array($element->height, $element->width);
            $sizePrecise = true;
            }

            if(is_array($size)) {
                if($sizePrecise) {
                    $tmpRatio = $size[0] * $size[1];
                } else {
                    $tmpRatio = $size[0] * $size[1] * 0.7;
                }

                if($tmpRatio > $ration && $tmpRatio < 500 * 500) {
                    $ration = $tmpRatio;
                    $srcBiggest = $path;
                }
            }
        }

        return $srcBiggest;
    }

    protected function getFavicon($url) {

        $html = $this->getHtmlDom($url);
        foreach($html->find('link') as $element) {
            if($element->rel == "shortcut icon" || $element->rel == "icon")
                return $this->urlRel2abs($element->href, $url);
        }

        return '';
    }


    protected function getDomain($url) {
        $urlData = parse_url($url);

        return $urlData['host'];
    }


    protected function urlRel2abs($rel, $base)
    {
        if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
        if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
        extract(parse_url($base));
        $path = preg_replace('#/[^/]*$#', '', $path);
        if ($rel[0] == '/') $path = '';
        if (parse_url($base, PHP_URL_PORT) != ''){
            $abs = "$host:".parse_url($base, PHP_URL_PORT)."$path/$rel";
        }else{
            $abs = "$host$path/$rel";
        }
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

        return $scheme.'://'.$abs;
    }

    protected function pathSeamsGood($url, $stopwords) {
        $url = strtolower($url);
        foreach($stopwords as $stopword) {
            if (strpos($url, strtolower($stopword)) !== false) {
                return false;
            }
        }

        return true;
    }

    protected function getContext() {
        $context = stream_context_create();
        $context  = stream_context_create(array(
              'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" .
                  "Cookie: foo=bar\r\n" .
                  "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36\r\n" // i.e. An iPad 
                  )
              ));

        return $context;
    }
}