<?php
namespace Extractors;

\File::requireOnce(public_path() . '/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php');

abstract class AbstractExtractor implements ExtractorInterface
{
    abstract public function getTitleCssSelector();

    abstract public function getYieldCssSelector();

    abstract public function getIngredientsCssSelector();

    abstract public function getPreparationsCssSelector();

    public function getDomElement($html)
    {

        return str_get_html($html);
    }

    public function extract($html)
    {
        $dom = $this->getDomElement($html);


        return array(
            'title'   => $this->tidy($this->getTitle($dom)),
            'body'    => '<h2>Ingrédients (' . $this->tidy($this->getYield($dom)) . ')</h2>' .
                $this->tidy($this->getIngredients($dom)) . '<br/>
            <h2>Preparations:</h2>' . $this->tidy($this->getPreparations($dom)),
            'success' => true
        );
    }

    public function getTitle($domHtml)
    {
        $title = $domHtml->find($this->getTitleCssSelector(), 0);
        if (is_null($title)) {

            return '';
        }


        return strip_tags($title->outertext);
    }

    public function getIngredients($domHtml)
    {
        $ingredients = $domHtml->find($this->getIngredientsCssSelector());

        $ingredientsList = "<br/>";
        foreach ($ingredients as $ingredient) {
            $ingredientsList .= 'ITEM-'.'- ' . $this->addMarker(strip_tags($ingredient->innertext)) . "<br/>" . '-ITEM';
        }


        return 'getIngredients' . $ingredientsList. 'getIngredients';
    }

    public function getYield($domHtml)
    {
        $yield = $domHtml->find($this->getYieldCssSelector(), 0);

        if (is_null($yield)) {

            return '';
        }

        $yield->innertext = preg_replace("/[^0-9]/", "", $yield->innertext);


        return '<b>' . $yield->innertext . '</b>' . ' personnes';
    }

    public function getPreparations($domHtml)
    {
        $preparations    = $domHtml->find($this->getPreparationsCssSelector());
        $preparationList = '<br/>';
        foreach ($preparations as $preparation) {
            $preparationList .= '- ' . $preparation->innertext . '<br/>';
        }

        return 'getPreparations-' . $preparationList . '-getPreparations';
    }

    public function tidy($title)
    {

        return preg_replace('/[\s]+/mu', ' ', trim($title));
    }

    public function addMarker($content)
    {
        $content = trim($content);
        /**
         * ([0-9,.]+)/([0-9,.]+) => detect divison 1/3, 34/27 1.82/193.287
         * ([0-9.,]+) => detect simple integer or float
         */
        $content = preg_replace("#([0-9,.]+)/([0-9,.]+)|([0-9.,]+)#", "_$0_", $content);

        /**
         * replace comma by point 1,4 => 1.4
         */


        $content = preg_replace("/_([0-9]+),([0-9]+)_/", "<em>$1.$2</em>", $content);

        return 'addMarker-' . $content . '-addMarker';
    }
}
