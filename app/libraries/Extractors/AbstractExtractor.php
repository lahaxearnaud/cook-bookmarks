<?php
namespace Extractors;

\File::requireOnce(public_path() . '/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php');

abstract class AbstractExtractor implements ExtractorInterface {
	abstract public function getTitleCssSelector();
	abstract public function getYieldCssSelector();
	abstract public function getIngredientsCssSelector();
	abstract public function getPreparationsCssSelector();

	public function getDomElement($html) {
		return str_get_html($html);
	}

	public function extract($html) {
		$dom = $this->getDomElement($html);

		return array(
			'title' => $this->tidy($this->getTitle($dom)),
			'body'  => '<h2>Ingrédients (' . $this->tidy($this->getYield($dom)) . ')</h2> <br/> ' .
			$this->tidy($this->getIngredients($dom)) . '<br/>
            <h2>Preparations:</h2>' . $this->tidy($this->getPreparations($dom)),
			'success' => true
		);
	}

	public function getTitle($domHtml) {
		$title = $domHtml->find($this->getTitleCssSelector(), 0);
		if (is_null($title)) {
			return '';
		}

		return $title->outertext;
	}

	public function getIngredients($domHtml) {
		$ingredients = $domHtml->find($this->getIngredientsCssSelector());

		$ingredientsList = "<br/>";
		foreach ($ingredients as $ingredient) {
			$ingredientsList .= ' - ' . strip_tags($ingredient->innertext) . "<br/>";
		}

		return $ingredientsList;
	}

	public function getYield($domHtml) {
		$yield = $domHtml->find($this->getYieldCssSelector(), 0);

		if (is_null($yield)) {
			return '';
		}

		$yield->innertext = preg_replace("/[^0-9]/", "", $yield->innertext);

		return $yield->innertext . ' personnes';
	}

	public function getPreparations($domHtml) {
		$preparations    = $domHtml->find($this->getPreparationsCssSelector());
		$preparationList = '<br/>';
		foreach ($preparations as $preparation) {
			$preparationList .= ' - ' . $preparation->innertext . '<br/>';
		}

		return $preparationList;
	}

	public function tidy($title) {
		return strip_tags(preg_replace('/[\s]+/mu', ' ', trim($title)));
	}
}
