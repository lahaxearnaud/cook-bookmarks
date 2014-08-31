<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class AllRecipes extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('h1[id=itemTitle]', 0);
    $ingredients = $html->find('ul.ingredient-wrap li .fl-ing');
    $preparations = $html->find('div[itemprop=recipeInstructions] ol li');
    $ingredientsNbPers = $html->find('span[id=lblYield]', 0);

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
