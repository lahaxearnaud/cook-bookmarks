
[![Build Status](https://travis-ci.org/lahaxearnaud/cook-bookmarks.svg)](https://travis-ci.org/lahaxearnaud/cook-bookmarks)
[![License](https://poser.pugx.org/leaphly/cart-bundle/license.svg)](https://github.com/lahaxearnaud/cook-bookmarks)
[![Stories in Ready](https://badge.waffle.io/lahaxearnaud/cook-bookmarks.png?label=ready&title=Ready)](http://waffle.io/lahaxearnaud/cook-bookmarks)
[![Code Climate](https://codeclimate.com/github/lahaxearnaud/cook-bookmarks/badges/gpa.svg)](https://codeclimate.com/github/lahaxearnaud/cook-bookmarks)
[![Test Coverage](https://codeclimate.com/github/lahaxearnaud/cook-bookmarks/badges/coverage.svg)](https://codeclimate.com/github/lahaxearnaud/cook-bookmarks)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b43e1cb9-d1a5-422d-8dd3-cff6bb99b58b/mini.png)](https://insight.sensiolabs.com/projects/b43e1cb9-d1a5-422d-8dd3-cff6bb99b58b)

# CookBookmark api

## Install

    - install composer
    - git clone this repo
    - composer install
    - change database configuration (app/config/databases.php)
    - php artisan migrate
    - php artisan db:seed

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
- Drink a beer

## License

All this repository is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
