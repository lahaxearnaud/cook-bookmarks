<?php

namespace Extractors;

class CuisineAZ extends ArticleExtractor{

    public function extract($html, $url = '') {
		$html = str_get_html($html);

	$title = $html->find('.recetteH1', 0);
	$ingredients = $html->find('#ingredients');
	$preparations = $html->find('#preparation');

        if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
            return array(
                'title' => '',
                'body' => '',
                'success' => false
            );
        }
	return array(
            'title' => is_null($title)?'':$title->plaintext,
            'body' => (is_null($ingredients)?'':$ingredients->outertext) .'<br/>' . (is_null($preparations)?'':$preparations->outertext),
            'success' => true
        );
    }

};