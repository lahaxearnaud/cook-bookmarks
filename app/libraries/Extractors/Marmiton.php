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

        return 'div.m_content_recette_main > p.m_content_recette_ingredients > span';
    }

    public function getIngredientsCssSelector()
    {

        return '.m_content_recette_main .m_content_recette_ingredients';
    }

    public function getPreparationsCssSelector()
    {

        return '.m_content_recette_todo';
    }

    public function getIngredients($domHtml)
    {

        $ingredients                             = $domHtml->find($this->getIngredientsCssSelector(), 0);
        $ingredients->find('span', 0)->innertext = '';


        return $this->addMarker(trim($ingredients->innertext));
    }

    public function getPreparations($domHtml)
    {
        $preparation                                              = $domHtml->find($this->getPreparationsCssSelector(), 0);
        $preparation->find('h4', 0)->innertext                    = '';
        $preparation->find('.m_content_recette_ps', 0)->innertext = '';

        $body         = $preparation->innertext;
        $body         = preg_replace('/[\s]+/mu', ' ', $body);
        $preparations = preg_split("/(<br>\s){2}/", $body);

        $preparationList = '<br/>';
        foreach ($preparations as $preparation) {
            $preparationList .= $preparation . '<br/>';
        }


        return $preparationList;
    }
}
