<?php

return array(

	'stopword' => array('blank', 'header', 'social', 'facebook', 'twitter', 'logo', '1px', 'star', 'rating', 'email', 'footer', 'ytimg', 'outil', 'tool', 'ad.', 'adserv', 'pinterest', 'google', 'encart', 'reddit'),

	'extractors' => array(
		'.*marmiton.*'             => '\Extractors\Marmiton',
		'.*cuisineaz.*'            => '\Extractors\CuisineAZ',
		'.*750g.*'                 => '\Extractors\g750',
		'.*odelices.*'             => '\Extractors\Odelices',
		'.*foodnetwork.*'          => '\Extractors\FoodNetwork',
		'.*food.*'                 => '\Extractors\Food',
		'.*1001cocktails.*'        => '\Extractors\Cocktail1001',
		'.*lacuisinedannie.*'      => '\Extractors\LaCuisineDAnnie',
		'.*lefigaro.*'             => '\Extractors\MadameLeFigaro',
		'.*allrecipes.*'           => '\Extractors\AllRecipes',
		'.*femina.*'               => '\Extractors\Femina',
		'.*jamieoliver.*'          => '\Extractors\JamieOliver',
		'.*journaldesfemmes.*'     => '\Extractors\JournalDesFemmes',
		'.*cuisine.notrefamille.*' => '\Extractors\CuisineNotreFamille',
	),

	'defaultExtractor' => '\Extractors\ReadabilityExtractor'
);
