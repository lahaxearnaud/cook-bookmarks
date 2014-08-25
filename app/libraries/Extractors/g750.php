<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class g750 extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

        $title = $html->find('h1', 0);
        $ingredients = $html->find('div.main > div.row > div.hrecipe > div.row > ul', 0);
        $nbPersonne = $html->find('div.main > div.row > div.hrecipe > div p .yield', 0);
        $preparations = $html->find('.instructions', 0);

        if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
            return array(
                'title' => '',
                'body' => '',
                'success' => false
            );
        }

        return array(
                'title' => $this->tidyTile($title->plaintext),
                'body' => '<h2>Ingrédients (Pour '.$nbPersonne->innertext.' personnes):</h2><br/> '.($ingredients->outertext) .'<br/><h2>Instructions</h2><br/>' . ($preparations->innertext),
                'success' => true
            );
    }
};
