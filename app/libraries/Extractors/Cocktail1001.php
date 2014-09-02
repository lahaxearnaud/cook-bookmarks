<?php

namespace Extractors;


class Cocktail1001 extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'h1';
    }

    public function getYieldCssSelector()
    {
        return '';
    }

    public function getIngredientsCssSelector()
    {
        return 'a[itemprop=ingredients]';
    }

    public function getPreparationsCssSelector()
    {
        return 'span[itemprop=recipeInstructions]';
    }

    public function extract($html)
    {
        $dom = $this->getDomElement($html);

        return  array(
            'title' => $this->tidy($this->getTitle($dom)),
            'body' => '<h2>Ingrédients</h2> <br/> ' .
            $this->tidy($this->getIngredients($dom)) . '<br/>
            <h2>Preparations:</h2>' . $this->tidy($this->getPreparations($dom)),
            'success' => true
        );
    }

    public function getIngredients($domHtml)
    {
        $ingredients = $domHtml->find($this->getIngredientsCssSelector());

        $ingredientsList = "<br/>";
        foreach ($ingredients as $ingredient) {
            $ingredientsList .= ' - ' . strip_tags($ingredient->parent()->innertext)."<br/>";
        }

        return $ingredientsList;
    }
}
