<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class CuisineAZ extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('.recetteH1', 0);
    $ingredients = $html->find('div[id=ingredients]', 0);
    $preparations = $html->find('div[id=preparation]', 0);

    if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    return array(
            'title' => is_null($title)?'':trim($title->plaintext),
            'body' => (is_null($ingredients)?'':$ingredients->outertext) .'<br/>' . (is_null($preparations)?'':$preparations->outertext),
            'success' => true
        );
    }

};
