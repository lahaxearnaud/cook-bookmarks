<?php

namespace Extractors;

class g750 extends AbstractExtractor
{

    public function getTitleCssSelector()
    {

        return 'h1';
    }

    public function getYieldCssSelector()
    {

        return 'div.main > div.row > div.hrecipe > div p .yield';
    }

    public function getIngredientsCssSelector()
    {

        return 'div.main > div.row > div.hrecipe > div.row > ul > li';
    }

    public function getPreparationsCssSelector()
    {

        return '.instructions .recette_etape_texte';
    }
}
