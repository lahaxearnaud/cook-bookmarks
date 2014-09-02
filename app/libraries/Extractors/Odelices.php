<?php

namespace Extractors;


class Odelices extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'h1 a span.fn';
    }

    public function getYieldCssSelector()
    {
        return 'div[id=recipe-columns2] h2 .h-second';
    }

    public function getIngredientsCssSelector()
    {
        return 'div[id=recipe-columns2] .container';
    }

    public function getPreparationsCssSelector()
    {
        return 'div[id=left-content] .instructions';
    }

    public function getIngredients($domHtml)
    {
        return $domHtml->find($this->getIngredientsCssSelector(), 0)->innertext;
    }

    public function getPreparations($domHtml)
    {
        return $domHtml->find($this->getPreparationsCssSelector(), 0)->innertext;
    }
}