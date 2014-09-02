<?php

namespace Extractors;

class Marmiton extends AbstractExtractor
{

    public function getTitleCssSelector()
    {
        return '.m_title  .item  .fn';
    }

    public function getYieldCssSelector()
    {
        return '';
    }

    public function getIngredientsCssSelector()
    {
        return '';
    }

    public function getPreparationsCssSelector()
    {
        return '.m_content_recette_main';
    }

    public function getIngredients($domHtml)
    {
        return '';
    }

    public function getYield($domHtml)
    {
        return '';
    }

    public function getPreparations($domHtml)
    {
        $body = $domHtml->find($this->getPreparationsCssSelector(), 0)->innertext;
        $body = preg_replace( '/Ingrédients(\s)?(\(pour\s[0-9]+\spersonne(s)?\))\s:/', '<h2>${0}</h2><br/>', $body );
        $body = str_replace(['<h4>', '</h4>'], ['<h2>', '</h2>'], $body);

        return $body;
    }
}