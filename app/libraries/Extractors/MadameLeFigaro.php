<?php

namespace Extractors;

class MadameLeFigaro extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'h1.fn';
    }

    public function getYieldCssSelector()
    {
        return '.yield';
    }

    public function getIngredientsCssSelector()
    {
        return '.recipe-ingredients > .item-list';
    }

    public function getPreparationsCssSelector()
    {
        return '.recipe-instruction-content p';
    }

    public function getIngredients($domHtml)
    {
        return $this->addMarker($domHtml->find($this->getIngredientsCssSelector(), 0)->innertext);
    }
}
