<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 06/08/14
 * Time: 22:28
 */

namespace Observers\Repositories;

class ArticlesRepositoryObserver extends Observer
{
    protected function getCacheTag()
    {

        return 'article';
    }
}
