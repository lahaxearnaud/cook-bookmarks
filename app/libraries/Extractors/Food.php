<?php

namespace Extractors;

class Food extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'div[id=rz-lead] > div > h1 > span';
    }

    public function getYieldCssSelector()
    {
        return 'select[id=servingssize] > option[selected=selected]';
    }

    public function getIngredientsCssSelector()
    {
        return 'div[id=rz-w] > div.recipe-detail-wrap > .ingredients > ul > li';
    }

    public function getPreparationsCssSelector()
    {
        return 'div[id=rz-w] > div.recipe-detail-wrap > .directions > ol > li';
    }
}