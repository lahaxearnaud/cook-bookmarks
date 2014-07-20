<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 20/07/14
 * Time: 16:05
 */


/**
 * Interface UrlPresenter
 *
 * @author  LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 *
 * @package Model
 */
interface UrlApiInterface
{
    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function findUrl();

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function createUrl();

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function deleteUrl();

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function updateUrl();

}
