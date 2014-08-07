<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 06/08/14
 * Time: 22:28
 */

namespace Observers\Repositories;

use \Cache as Cache;
use \Carbon\Carbon as Carbon;

class ArticlesRepositoryObserver extends Observer {

    protected function getCacheTag()
    {
        return 'article';
    }

    protected function paramToString($params)
    {
        return md5(serialize($params));
    }

    public function beforeAll ($event)
    {

        return Cache::tags($this->getCacheTag())->get('all', false);
    }

    public function beforeFind ($event)
    {
        return Cache::tags($this->getCacheTag())->get('find.'.$this->paramToString($event), false);
    }

    public function beforeFindFirstBy ($event)
    {
        return Cache::tags($this->getCacheTag())->get('findFirstBy.'.$this->paramToString($event), false);
    }

    public function beforeFindAllBy ($event)
    {
        return Cache::tags($this->getCacheTag())->get('findAllBy.'.$this->paramToString($event), false);
    }

    public function beforeHas ($event)
    {
        return Cache::tags($this->getCacheTag())->get('has.'.$this->paramToString($event), false);
    }

    public function beforePaginate ($event)
    {
        // TODO: Implement beforePaginate() method.
    }

    public function beforePaginateWhere ($event)
    {
        // TODO: Implement beforePaginateWhere() method.
    }

    public function beforeUpdate ($event)
    {
        // TODO: Implement beforeUpdate() method.
    }

    public function beforeDelete ($event)
    {
        // TODO: Implement beforeDelete() method.
    }

    public function beforeCreate ($event)
    {
        // TODO: Implement beforeCreate() method.
    }





    public function afterAll ($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('all', $data, $expiresAt = Carbon::now()->addMinutes(10));
    }

    public function afterFind ($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('find.'.$this->paramToString($params), $data, $expiresAt = Carbon::now()->addMinutes(10));
    }

    public function afterFindFirstBy ($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('findFirstBy.'.$this->paramToString($params), $data, $expiresAt = Carbon::now()->addMinutes(10));
    }

    public function afterFindAllBy ($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('findAllBy.'.$this->paramToString($params), $data, $expiresAt = Carbon::now()->addMinutes(10));
    }

    public function afterHas ($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('has.'.$this->paramToString($params), $data, $expiresAt = Carbon::now()->addMinutes(10));
    }

    public function afterPaginate ($params, $data)
    {
        // TODO: Implement afterPaginate() method.
    }

    public function afterPaginateWhere ($params, $data)
    {
        // TODO: Implement afterPaginateWhere() method.
    }

    public function afterUpdate ($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }

    public function afterDelete ($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }

    public function afterCreate ($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }
}