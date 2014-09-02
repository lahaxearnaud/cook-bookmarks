<?php

namespace Extractors;

class Femina extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'span[itemprop=name]';
    }

    public function getYieldCssSelector()
    {
        return 'span[itemprop=yield]';
    }

    public function getIngredientsCssSelector()
    {
        return '.cnt ul[itemprop=ingredients] li';
    }

    public function getPreparationsCssSelector()
    {
        return '.preparation > .cnt';
    }

    public function getPreparations($domHtml) {
        return $domHtml->find($this->getPreparationsCssSelector(), 0)->__toString();
    }
}