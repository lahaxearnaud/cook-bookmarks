<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class JournalDesFemmes extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

    $title = $html->find('h1 span.fn', 0);
    $ingredients = $html->find('ul.bu_cuisine_ingredients li');
    $preparations = $html->find('.instructions .bu_cuisine_recette_prepa ');
    $ingredientsNbPers = $html->find('span.yield', 0);

    if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
        return array(
            'title' => '',
            'body' => '',
            'success' => false
        );
    }

    $body = '';
    foreach ($preparations as $preparation) {
        $body .= ' - ' . strip_tags($preparation->innertext) . '<br/>';
    }

    $ingredientsBody = '<br/>';
    foreach ($ingredients as $ingredient) {
        $ingredientsBody .= ' - ' . strip_tags($ingredient->innertext)  . '<br/>';
    }


    return array(
            'title' => $this->tidyTile($title->plaintext),
            'body' => '<h2>Ingrédients ( Pour ' . $ingredientsNbPers->innertext . ' personne(s))</h2> <br/> ' . $ingredientsBody . '<br/><h2>Preparations:</h2>' . $body,
            'success' => true
        );
    }

};
