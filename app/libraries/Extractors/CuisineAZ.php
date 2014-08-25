<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class CuisineAZ extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('.recetteH1', 0);
    $ingredients = $html->find('div[id=ingredients] ul', 0);
    $preparations = $html->find('div[id=preparation] p');
    $ingredientsNbPers = $html->find('span[id=ctl00_ContentPlaceHolder_LblRecetteNombre]', 0);

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
