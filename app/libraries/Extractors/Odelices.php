<?php

namespace Extractors;

class Odelices extends ArticleExtractor{

    public function extract($html, $url = '') {
		$html = str_get_html($html);

		$title = $html->find('#recipe-title a .fn', 0);
		$ingredients = $html->find('#recipe-ingredients');
		$preparations = $html->find('#recipe-instructions');

		if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
			return array(
	            'title' => '',
	            'body' => '',
	            'success' => false
	        );
		}

		return array(
	            'title' => is_null($title)?'':$title->plaintext,
	            'body' => (is_null($ingredients)?'':$ingredients->innertext) .'<br/>' . (is_null($preparations)?'':$preparations->innertext),
	            'success' => true
	        );
	}
};