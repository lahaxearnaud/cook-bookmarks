
[![Build Status](https://travis-ci.org/lahaxearnaud/cook-bookmarks.svg)](https://travis-ci.org/lahaxearnaud/cook-bookmarks)
[![License](https://poser.pugx.org/leaphly/cart-bundle/license.svg)](https://github.com/lahaxearnaud/cook-bookmarks)
[![Issues](http://img.shields.io/github/issues/lahaxearnaud/cook-bookmarks.svg)](https://github.com/lahaxearnaud/cook-bookmarks)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b43e1cb9-d1a5-422d-8dd3-cff6bb99b58b/mini.png)](https://insight.sensiolabs.com/projects/b43e1cb9-d1a5-422d-8dd3-cff6bb99b58b)

# CookBookmark api

## Install

    - install composer
    - git clone this repo
    - composer install
    - change database configuration (app/config/databases.php)
    - php artisan migrate
    - php artisan db:seed
    - php artisan optimize

## Update
	- composer update
	- php artisan migrate

## Generate doc
    - php artisan doc:gen

## Contribution Guidelines

- Fork the project
- Create a branch from develop or work in develop
- Follow all points of [insight/sensiolabs](https://insight.sensiolabs.com/what-we-analyse)
- If it's a breaking change (write | update) some tests
- If you (createa new | update a) websevice you must document it (see [lahaxearnaud/php-apidoc](https://github.com/lahaxearnaud/php-apidoc) )
- Make a pull request from your branch to the develop

## License

All this repository is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)