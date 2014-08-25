<?php

namespace Extractors;

class CuisineAZ extends ArticleExtractor{

    public function extract($html, $url = '') {
		$html = str_get_html($html);

		$title = $html->find('.recetteH1', 0);
		$ingredients = $html->find('.recette_ingredients columns', 0);
		$preparations = $html->find('.recette_preparation', 0);

		if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
			return array(
	            'title' => '',
	            'body' => '',
	            'success' => false
	        );
		}

		return array(
	            'title' => is_null($title)?'':$title->plaintext,
	            'body' => $ingredients->innertext .'<br/>' . $preparations->innertext),
	            'success' => true
	        );
	}
};