<?php
namespace Observers\Repositories;

abstract class Observer implements ObserverInterface
{

    protected abstract function getCacheTag();

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     * @return array
     */
    public function subscribe($events)
    {
        $className = get_class($this);

        $events->listen($this->getCacheTag().'.all.before', $className . '@beforeAll');
        $events->listen($this->getCacheTag().'.find.before', $className . '@beforeFind');
        $events->listen($this->getCacheTag().'.findFirstBy.before', $className . '@beforeFindFirstBy');
        $events->listen($this->getCacheTag().'.findAllBy.before', $className . '@beforeFindAllBy');
        $events->listen($this->getCacheTag().'.has.before', $className . '@beforeHas');
        $events->listen($this->getCacheTag().'.paginate.before', $className . '@beforePaginate');
        $events->listen($this->getCacheTag().'.paginateWhere.before', $className . '@beforePaginateWhere');
        $events->listen($this->getCacheTag().'.update.before', $className . '@beforeUpdate');
        $events->listen($this->getCacheTag().'.delete.before', $className . '@beforeDelete');
        $events->listen($this->getCacheTag().'.create.before', $className . '@beforeCreate');

        $events->listen($this->getCacheTag().'.all.after', $className . '@afterAll');
        $events->listen($this->getCacheTag().'.find.after', $className . '@afterFind');
        $events->listen($this->getCacheTag().'.findFirstBy.after', $className . '@afterFindFirstBy');
        $events->listen($this->getCacheTag().'.findAllBy.after', $className . '@afterFindAllBy');
        $events->listen($this->getCacheTag().'.has.after', $className . '@afterHas');
        $events->listen($this->getCacheTag().'.paginate.after', $className . '@afterPaginate');
        $events->listen($this->getCacheTag().'.paginateWhere.after', $className . '@afterPaginateWhere');
        $events->listen($this->getCacheTag().'.update.after', $className . '@afterUpdate');
        $events->listen($this->getCacheTag().'.delete.after', $className . '@afterDelete');
        $events->listen($this->getCacheTag().'.create.after', $className . '@afterCreate');

    }
}
