<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class MadameLeFigaro extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('h1.fn', 0);
    $ingredients = $html->find('.recipe-ingredients > .item-list', 0);
    $preparations = $html->find('.recipe-instruction-content p');
    $ingredientsNbPers = $html->find('.yield', 0);

    if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    $body = '';
    foreach ($preparations as $preparation) {
        $body .= ' - ' . $preparation->innertext . '<br/>';
    }

    return array(
            'title' => $this->tidyTile($title->plaintext),
            'body' => '<h2>Ingrédients ('.$ingredientsNbPers->innertext.')</h2> <br/> ' . $ingredients->outertext .'<br/><h2>Preparations:</h2>' . $body,
            'success' => true
        );
    }

};
