<?php

return array(

    'stopword' => array('blank', 'header', 'social', 'facebook', 'twitter', 'logo', '1px', 'star', 'rating', 'email', 'footer', 'ytimg', 'outil', 'tool', 'ad.', 'adserv', 'pinterest', 'google', 'encart', 'reddit'),

    'extractors' => array(
        '.*marmiton.*' => '\Extractors\Marmiton',
        '.*cuisineaz.*' => '\Extractors\CuisineAZ',
        '.*750g.*' => '\Extractors\g750',
        '.*odelices.*' => '\Extractors\Odelices',
    ),

    'defaultExtractor' => '\Extractors\ReadabilityExtractor'
);
