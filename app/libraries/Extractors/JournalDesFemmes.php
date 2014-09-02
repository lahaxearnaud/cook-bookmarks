<?php

namespace Extractors;

class JournalDesFemmes extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return 'h1 span.fn';
    }

    public function getYieldCssSelector()
    {
        return 'span.yield';
    }

    public function getIngredientsCssSelector()
    {
        return 'ul.bu_cuisine_ingredients li';
    }

    public function getPreparationsCssSelector()
    {
        return '.instructions .bu_cuisine_recette_prepa';
    }
}
