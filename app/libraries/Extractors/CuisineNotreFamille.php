<?php

namespace Extractors;

class CuisineNotreFamille extends AbstractExtractor
{

    public function getTitleCssSelector()
    {

        return 'span[id=ctl00_Main_LabelRecetteNom]';
    }

    public function getYieldCssSelector()
    {

        return 'span[id=ctl00_Main_Lab_nb_convives] > .yield';
    }

    public function getIngredientsCssSelector()
    {

        return 'div[id=structure-page-recette] > div.item > ul > li';
    }

    public function getPreparationsCssSelector()
    {

        return '.txt-preparation';
    }
}
