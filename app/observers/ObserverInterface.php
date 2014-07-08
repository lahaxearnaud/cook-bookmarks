<?php
namespace Observers;

use Illuminate\Database\Eloquent\Model;

interface ObserverInterface
{
    /**
	 * @param  Model  $model
	 */
    public function saving(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function saved(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function updating(Model $model);

        /**
	 * @param  Model  $model
	 */
    public function updated(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function creating(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function created(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function deleting(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function deleted(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function restoring(Model $model);

    /**
	 * @param  Model  $model
	 */
    public function restored(Model $model);
}
