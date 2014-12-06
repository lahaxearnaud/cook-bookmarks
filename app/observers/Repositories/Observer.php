<?php
namespace Observers\Repositories;

use Cache as Cache;
use Carbon\Carbon as Carbon;

abstract class Observer implements ObserverInterface
{

    abstract protected function getCacheTag();

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     *
     * @return array
     */
    public function subscribe($events)
    {
        $className = get_class($this);

        $events->listen($this->getCacheTag() . '.all.before', $className . '@beforeAll');
        $events->listen($this->getCacheTag() . '.find.before', $className . '@beforeFind');
        $events->listen($this->getCacheTag() . '.findFirstBy.before', $className . '@beforeFindFirstBy');
        $events->listen($this->getCacheTag() . '.findAllBy.before', $className . '@beforeFindAllBy');
        $events->listen($this->getCacheTag() . '.has.before', $className . '@beforeHas');
        $events->listen($this->getCacheTag() . '.paginate.before', $className . '@beforePaginate');
        $events->listen($this->getCacheTag() . '.paginateWhere.before', $className . '@beforePaginateWhere');
        $events->listen($this->getCacheTag() . '.update.before', $className . '@beforeUpdate');
        $events->listen($this->getCacheTag() . '.delete.before', $className . '@beforeDelete');
        $events->listen($this->getCacheTag() . '.create.before', $className . '@beforeCreate');

        $events->listen($this->getCacheTag() . '.all.after', $className . '@afterAll');
        $events->listen($this->getCacheTag() . '.find.after', $className . '@afterFind');
        $events->listen($this->getCacheTag() . '.findFirstBy.after', $className . '@afterFindFirstBy');
        $events->listen($this->getCacheTag() . '.findAllBy.after', $className . '@afterFindAllBy');
        $events->listen($this->getCacheTag() . '.has.after', $className . '@afterHas');
        $events->listen($this->getCacheTag() . '.paginate.after', $className . '@afterPaginate');
        $events->listen($this->getCacheTag() . '.paginateWhere.after', $className . '@afterPaginateWhere');
        $events->listen($this->getCacheTag() . '.update.after', $className . '@afterUpdate');
        $events->listen($this->getCacheTag() . '.delete.after', $className . '@afterDelete');
        $events->listen($this->getCacheTag() . '.create.after', $className . '@afterCreate');

    }

    protected function paramToString($params)
    {

        return md5(serialize($params));
    }

    public function beforeAll($event)
    {

        return Cache::tags($this->getCacheTag())->get('all', false);
    }

    public function beforeFind($event)
    {

        return Cache::tags($this->getCacheTag())->get('find.' . $this->paramToString($event), false);
    }

    public function beforeFindFirstBy($event)
    {

        return Cache::tags($this->getCacheTag())->get('findFirstBy.' . $this->paramToString($event), false);
    }

    public function beforeFindAllBy($event)
    {

        return Cache::tags($this->getCacheTag())->get('findAllBy.' . $this->paramToString($event), false);
    }

    public function beforeHas($event)
    {

        return Cache::tags($this->getCacheTag())->get('has.' . $this->paramToString($event), false);
    }

    public function beforePaginate($event)
    {

        return Cache::tags($this->getCacheTag())->get('paginate.' . $this->paramToString($event), false);
    }

    public function beforePaginateWhere($event)
    {

        return Cache::tags($this->getCacheTag())->get('paginateWhere.' . $this->paramToString($event), false);
    }

    public function beforeUpdate($event)
    {

        return false;
    }

    public function beforeDelete($event)
    {

        return false;
    }

    public function beforeCreate($event)
    {

        return false;
    }

    public function afterAll($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('all', $data, Carbon::now()->addMinutes(10));
    }

    public function afterFind($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('find.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterFindFirstBy($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('findFirstBy.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterFindAllBy($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('findAllBy.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterHas($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('has.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterPaginate($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('paginate.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterPaginateWhere($params, $data)
    {
        Cache::tags($this->getCacheTag())->put('paginateWhere.' . $this->paramToString($params), $data, Carbon::now()->addMinutes(10));
    }

    public function afterUpdate($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }

    public function afterDelete($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }

    public function afterCreate($params, $data)
    {
        Cache::tags($this->getCacheTag())->flush();
    }
}
