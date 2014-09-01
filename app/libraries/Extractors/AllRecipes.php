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

    public function getPreparations($domHtml) {
        $preparations = $domHtml->find($this->getPreparationsCssSelector(), 0);
        $preparationList = '<br/>';
        foreach ($preparations as $preparation) {
            $preparationList .= ' - ' . $ingredient->find('.ingredient-amount', 0)->innertext . ' ' . $ingredient->find('.ingredient-name', 0)->innertext . '<br/>';
        }

        return $preparationList;
    }
}