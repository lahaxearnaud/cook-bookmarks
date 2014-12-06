<?php

namespace Extractors;

class FoodNetwork extends AbstractExtractor
{

    public function getTitleCssSelector()
    {

        return 'h1';
    }

    public function getYieldCssSelector()
    {

        return 'dd[itemprop=recipeYield]';
    }

    public function getIngredientsCssSelector()
    {

        return '.ingredients ul li';
    }

    public function getPreparationsCssSelector()
    {

        return 'div[itemprop=recipeInstructions] p';
    }
}
