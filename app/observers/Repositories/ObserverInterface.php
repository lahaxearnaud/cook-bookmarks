<?php
namespace Observers\Repositories;

interface ObserverInterface
{

    public function beforeAll($event);
    public function beforeFind($event);
    public function beforeFindFirstBy($event);
    public function beforeFindAllBy($event);
    public function beforeHas($event);
    public function beforePaginate($event);
    public function beforePaginateWhere($event);
    public function beforeUpdate($event);
    public function beforeDelete($event);
    public function beforeCreate($event);

    public function afterAll($params, $data);
    public function afterFind($params, $data);
    public function afterFindFirstBy($params, $data);
    public function afterFindAllBy($params, $data);
    public function afterHas($params, $data);
    public function afterPaginate($params, $data);
    public function afterPaginateWhere($params, $data);
    public function afterUpdate($params, $data);
    public function afterDelete($params, $data);
    public function afterCreate($params, $data);

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     * @return array
     */
    public function subscribe($events);
}
