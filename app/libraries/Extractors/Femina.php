<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class Femina extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('span[itemprop=name]', 0);
    $ingredients = $html->find('.cnt ul[itemprop=ingredients] li');
    $preparation = $html->find('.preparation > .cnt', 0);
    $ingredientsNbPers = $html->find('span[itemprop=yield]', 0);


    if(is_null($ingredients) || is_null($title) || is_null($preparation)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    $body = $preparation->__toString();

    $ingredientsBody = '<br/>';
    foreach ($ingredients as $ingredient) {
        $ingredientsBody .= ' - ' . $ingredient->innertext . '<br/>';
    }


    return array(
            'title' => $this->tidyTile($title->plaintext),
            'body' => '<h2>Ingrédients (' . $ingredientsNbPers->innertext . ')</h2> <br/> ' . $ingredientsBody . '<br/><h2>Preparations:</h2>' . $body,
            'success' => true
        );
    }

};
