<?php

namespace Extractors;

class CuisineAZ extends ArticleExtractor{

    public function extract($html, $url = '') {
		$html = str_get_html($html);

    	$title = $html->find('.recetteH1', 0);
    	$ingredients = $html->find('#ingredients');
    	$preparations = $html->find('#preparation');

	return array(
            'title' => is_null($title)?'':$title->plaintext,
            'body' => (is_null($ingredients)?'':$ingredients->outertext) .'<br/>' . (is_null($preparations)?'':$preparations->outertext),
            'success' => true
        );
    }

};