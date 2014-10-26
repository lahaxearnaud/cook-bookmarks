<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 25/10/14
 * Time: 18:24
 */

/**
 * Interface UserFilterableInterface
 *
 * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 */
interface UserFilterableInterface {

    /**
     * @param $query
     * @param $userId
     *
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     *
     * @return mixed
     */
    public function scopeOfUser ($query, $userId);

    /**
     * @author LAHAXE Arnaud <arnaud.lahaxe@versusmind.eu>
     * @return string
     */
    public function getUserField();
}