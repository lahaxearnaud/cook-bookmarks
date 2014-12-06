<?php

namespace Extractors;

class LaCuisineDAnnie extends AbstractExtractor
{

    public function getTitleCssSelector()
    {

        return 'h1 > fn';
    }

    public function getYieldCssSelector()
    {

        return '.yield';
    }

    public function getIngredientsCssSelector()
    {

        return 'div[id=basgauche] > ul > li';
    }

    public function getPreparationsCssSelector()
    {

        return 'li.instruction';
    }
}
