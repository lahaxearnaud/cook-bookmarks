<?php
namespace Observers\Repositories;


abstract class Observer implements ObserverInterface
{


    public function beforeAll($event)
    {
    }

    public function beforeFind($event)
    {
    }

    public function beforeFindFirstBy($event)
    {
    }

    public function beforeFindAllBy($event)
    {
    }

    public function beforeHas($event)
    {
    }

    public function beforePaginate($event)
    {
    }

    public function beforePaginateWhere($event)
    {
    }

    public function beforeUpdate($event)
    {
    }

    public function beforeDelete($event)
    {
    }

    public function beforeCreate($event)
    {
    }


    public function afterAll($event)
    {
    }

    public function afterFind($event)
    {
    }

    public function afterFindFirstBy($event)
    {
    }

    public function afterFindAllBy($event)
    {
    }

    public function afterHas($event)
    {
    }

    public function afterPaginate($event)
    {
    }

    public function afterPaginateWhere($event)
    {
    }

    public function afterUpdate($event)
    {
    }

    public function afterDelete($event)
    {
    }

    public function afterCreate($event)
    {
    }


	/**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events) {
		$className = get_class($this);

		$events->listen('all.before', $className . '@beforeAll');
		$events->listen('find.before', $className . '@beforeFind');
		$events->listen('findFirstBy.before', $className . '@beforeFindFirstBy');
		$events->listen('findAllBy.before', $className . '@beforeFindAllBy');
		$events->listen('has.before', $className . '@beforeHas');
		$events->listen('paginate.before', $className . '@beforePaginate');
		$events->listen('paginateWhere.before', $className . '@beforePaginateWhere');
		$events->listen('update.before', $className . '@beforeUpdate');
		$events->listen('delete.before', $className . '@beforeDelete');
		$events->listen('create.before', $className . '@beforeCreate');


		$events->listen('all.after', $className . '@afterAll');
		$events->listen('find.after', $className . '@afterFind');
		$events->listen('findFirstBy.after', $className . '@afterFindFirstBy');
		$events->listen('findAllBy.after', $className . '@afterFindAllBy');
		$events->listen('has.after', $className . '@afterHas');
		$events->listen('paginate.after', $className . '@afterPaginate');
		$events->listen('paginateWhere.after', $className . '@afterPaginateWhere');
		$events->listen('update.after', $className . '@afterUpdate');
		$events->listen('delete.after', $className . '@afterDelete');
		$events->listen('create.after', $className . '@afterCreate');

    }
}
