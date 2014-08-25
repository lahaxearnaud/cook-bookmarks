<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class Odelices extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
       // echo $html;die;
        $html = str_get_html($html);

        $title = $html->find('h1 a span.fn', 0);
        $ingredientsNbPers = $html->find('div[id=recipe-columns2] h2 .h-second', 0);
        $ingredients = $html->find('div[id=recipe-columns2] .container', 0);
        $preparations = $html->find('div[id=left-content] .instructions', 0);
        if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
            return array(
                'title' => '',
                'body' => '',
                'success' => false
            );
        }

        return array(
                'title' => $this->tidyTile($title->plaintext),
                'body' => '<h2>Ingrédients ('.$ingredientsNbPers->innertext.')</h2> <br/> ' . $ingredients->innertext .' <br/><h2>Préparation</h2><br/> ' . $preparations->innertext,
                'success' => true
            );
    }
};
