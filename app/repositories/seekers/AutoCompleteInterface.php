<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 27/10/14
 * Time: 22:42
 */

namespace Repositories\Seekers;

/**
 * Interface AutoCompleteInterface
 *
 * @package Repositories\Seekers
 */
interface AutoCompleteInterface {

    function autocomplete ($query, array $parameters = array());
} 