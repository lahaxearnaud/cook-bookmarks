<?php
namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class AbstractExtractor implements ExtractorInterface {

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

		return  array(
            'title' => $this->tidyTile($title->getTitle($dom)),
            'body' => '<h2>Ingrédients (' . $this->getYield($dom) . ')</h2> <br/> ' .
            $this->getIngredients($dom) . '<br/>
            <h2>Preparations:</h2>' . $this->getPreparations($dom),
            'success' => true
        );
    }

    public function getTitle($domHtml)
    {
        $title = $domHtml->find($this->getTitleCssSelector(), 0);
        if(is_null($title)) {
        	return '';
        }

        return $title->innerText;
    }

	public function getIngredients($domHtml)
	{
		$ingredients = $domHtml->find($this->getIngredientsCssSelector());

		$ingredientsList = "<br/>";
        foreach ($ingredients as $ingredient) {
            $ingredientsList .= ' - ' . strip_tags($ingredient->parent()->innertext)."<br/>";
        }

        return $ingredientsList;
	}

	public function getYield($domHtml)
	{
		$title = $domHtml->find($this->getYieldCssSelector(), 0);
        if(is_null($title)) {
        	return '';
        }

        return $title->innerText;
	}

	public function getPreparations($domHtml)
	{
		$preparations = $domHtml->find($this->getPreparationsCssSelector(), 0);
		$preparationList = '<br/>';
	    foreach ($preparations as $preparation) {
	        $preparationList .= ' - ' . $preparation->innertext . '<br/>';
	    }

	    return $preparationList;
	}

	public function tidyTile($title) {
        return preg_replace('/[\s]+/mu', ' ', trim($title));
    }
}