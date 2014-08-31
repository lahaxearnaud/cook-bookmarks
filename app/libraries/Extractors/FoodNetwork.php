<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class FoodNetwork extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);
    $title = $html->find('h1', 0);
    $ingredients = $html->find('.ingredients ul li');
    $preparations = $html->find('div[itemprop=recipeInstructions] p');
    $ingredientsNbPers = $html->find('dd[itemprop=recipeYield]', 0);

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
