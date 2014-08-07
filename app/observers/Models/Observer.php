<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Observer implements ObserverInterface
{

    /**
     * @var \ArticleIndexer
     */
    protected $indexer;

    public function __construct(\ArticleIndexer $articleIndexer)
    {
        $this->indexer = $articleIndexer;
    }

    /**
	 * @param  Model  $model
	 */
    public function saving(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    public function saved(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    public function updating(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    abstract public function updated(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function creating(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    abstract public function created(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function deleting(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    abstract public function deleted(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function restoring(Model $model)
    {
    }

    /**
	 * @param  Model  $model
	 */
    abstract public function restored(Model $model);

}
