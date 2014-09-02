<?php

namespace Extractors;

class AllRecipes extends AbstractExtractor
{
    public function getTitleCssSelector()
    {
        return 'h1[id=itemTitle]';
    }

    public function getYieldCssSelector()
    {
        return 'span[id=lblYield]';
    }

    public function getIngredientsCssSelector()
    {
        return 'ul.ingredient-wrap li .fl-ing';
    }

    public function getPreparationsCssSelector()
    {
        return 'div[itemprop=recipeInstructions] ol li';
    }

    public function getIngredients($domHtml)
    {
        $ingredients = $domHtml->find($this->getIngredientsCssSelector());
        $ingredientsList = '<br/>';
        foreach ($ingredients as $ingredient) {
            $amount = $ingredient->find('.ingredient-amount', 0);
            $name = $ingredient->find('.ingredient-name', 0);

            $ingredientsList .= ' - ' . (is_null($amount)?'':$amount->innertext) . ' ' . (is_null($name)?'':$name->innertext) . '<br/>';
        }

        return $ingredientsList;
    }
}
