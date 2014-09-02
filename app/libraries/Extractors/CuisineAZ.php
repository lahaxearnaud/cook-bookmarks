<?php

namespace Extractors;

class CuisineAZ extends AbstractExtractor
{
    public function getTitleCssSelector()
    {
        return '.recetteH1';
    }

    public function getYieldCssSelector()
    {
        return 'span[id=ctl00_ContentPlaceHolder_LblRecetteNombre]';
    }

    public function getIngredientsCssSelector()
    {
        return 'div[id=ingredients] ul';
    }

    public function getPreparationsCssSelector()
    {
        return 'div[id=preparation] p';
    }

    public function getIngredients($domHtml)
    {
        return $domHtml->find($this->getIngredientsCssSelector(), 0)->outertext;
    }
}
