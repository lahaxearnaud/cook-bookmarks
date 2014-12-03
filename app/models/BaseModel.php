<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 20/07/14
 * Time: 17:56
 */

use LaravelBook\Ardent\Ardent;

abstract class BaseModel extends Ardent implements UrlApiInterface, HyperMediaInterface
{

    protected $appends = array('_links');

    public function getLinksAttribute()
    {
        return array(
            'show'   => $this->findUrl(),
            'update' => $this->updateUrl(),
            'delete' => $this->deleteUrl()
        );
    }

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function findUrl()
    {
        return array(
            'url'    => $this->generateRoute('show'),
            'method' => 'GET'
        );
    }

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function deleteUrl()
    {
        return array(
            'url'    => $this->generateRoute('destroy'),
            'method' => 'DELETE'
        );
    }

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     * @return string
     */
    public function updateUrl()
    {
        return array(
            'url'    => $this->generateRoute('update'),
            'method' => 'PUT'
        );
    }

    protected function getBaseUrlName()
    {
        return 'api.' . $this->getApiVersion() . '.' . $this->getTable() . '.';
    }

    protected function getRouteName($action)
    {
        return $this->getBaseUrlName() . $action;
    }

    protected function generateRoute($action)
    {
        return route($this->getRouteName($action), array(
            'id' => $this->id
        ));
    }

    protected function getApiVersion()
    {
        return 'v1';
    }
}
