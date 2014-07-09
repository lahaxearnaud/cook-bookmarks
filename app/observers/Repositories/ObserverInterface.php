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

	public function afterAll($event);
	public function afterFind($event);
	public function afterFindFirstBy($event);
	public function afterFindAllBy($event);
	public function afterHas($event);
	public function afterPaginate($event);
	public function afterPaginateWhere($event);
	public function afterUpdate($event);
	public function afterDelete($event);
	public function afterCreate($event);

	/**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events);
}
