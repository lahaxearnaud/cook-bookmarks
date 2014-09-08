<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 06/08/14
 * Time: 22:28
 */

namespace Observers\Repositories;

use \Cache as Cache;

class CategoriesRepositoryObserver extends Observer
{
    protected function getCacheTag()
    {
        return 'category';
    }

    public function afterDelete($params, $data)
    {
    	parent::afterDelete($params, $data);
        Cache::tags('article')->flush();
    }

    public function afterUpdate($params, $data)
    {
    	parent::afterUpdate($params, $data);
        Cache::tags('article')->flush();
    }
}
