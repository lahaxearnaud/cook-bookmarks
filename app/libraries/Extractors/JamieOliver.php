<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class JamieOliver extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {

        $html = str_get_html($html);

    $title = $html->find('h1.fn', 0);
    $ingredients = $html->find('div[id=ingredients] .cntr ul li');
    $preparation = $html->find('p.instructions', 0);
    $ingredientsNbPers = $html->find('.recipe_meta p', 0);

    if(is_null($ingredients) || is_null($title) || is_null($preparation)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    $body = $preparation->innertext;

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
