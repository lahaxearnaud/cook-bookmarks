<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class Food extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
    $html = str_get_html($html);

    $title = $html->find('div[id=rz-lead] > div > h1 > span', 0);
    $ingredients = $html->find('div[id=rz-w] > div.recipe-detail-wrap > .ingredients > ul', 0);
    $preparations = $html->find('div[id=rz-w] > div.recipe-detail-wrap > .directions > ol', 0);
    $ingredientsNbPers = $html->find('select[id=servingssize] > option[selected=selected]', 0);

    if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    $body = $preparations->innertext . '<br/>';

    return array(
            'title' => $this->tidyTile($title->plaintext),
            'body' => '<h2>Ingrédients (pour'.$ingredientsNbPers->innertext.' personnes)</h2> <br/> ' . $ingredients->outertext .'<br/><h2>Preparations:</h2>' . $body,
            'success' => true
        );
    }

};
