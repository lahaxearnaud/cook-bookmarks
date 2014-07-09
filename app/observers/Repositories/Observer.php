<?php
namespace Observers\Repositories;

abstract class Observer implements ObserverInterface
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     * @return array
     */
    public function subscribe($events)
    {
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
