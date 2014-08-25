<?php

namespace Extractors;

class CuisineAZ extends ArticleExtractor{

    public function extract($html, $url = '') {
		$html = str_get_html($html);

		$title = $html->find('.recetteH1', 0);
		$ingredients = $html->find('.recette_ingredients columns', 0);
		$preparations = $html->find('.recette_preparation', 0);

		return array(
	            'title' => is_null($title)?'':$title->plaintext,
	            'body' => (is_null($ingredients)?'':$ingredients->innertext) .'<br/>' . (is_null($preparations)?'':$preparations->innertext),
	            'success' => true
	        );
	}
};