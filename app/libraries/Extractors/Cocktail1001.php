<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class Cocktail1001 extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

        $title = $html->find('h1', 0);
        $ingredients = $html->find('a[itemprop=ingredients]');
        $preparations = $html->find('span[itemprop=recipeInstructions]', 0);

        $ingredientsList = "<br>";
        foreach ($ingredients as $ingredient) {
            $ingredientsList .= ' - ' . strip_tags($ingredient->parent()->innertext)."<br/>";
        }

        if(is_null($ingredients) || is_null($title) || is_null($preparations)) {
            return array(
                'title' => '',
                'body' => '',
                'success' => false
            );
        }

        return array(
                'title' => $this->tidyTile($title->plaintext),
                'body' => '<h2>Ingrédients:</h2><br/> '. $ingredientsList .'<br/><h2>Instructions</h2><br/>' . ($preparations->innertext),
                'success' => true
            );
    }
};
