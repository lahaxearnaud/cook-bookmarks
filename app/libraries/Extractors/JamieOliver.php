<?php

namespace Extractors;

class JamieOliver extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'h1.fn';
    }

    public function getYieldCssSelector()
    {
        return '.recipe_meta p';
    }

    public function getIngredientsCssSelector()
    {
        return 'div[id=ingredients] .cntr ul li';
    }

    public function getPreparationsCssSelector()
    {
        return 'p.instructions';
    }

    public function getPreparations($domHtml)
    {
        return $domHtml->find($this->getPreparationsCssSelector(), 0)->innertext;
    }
}