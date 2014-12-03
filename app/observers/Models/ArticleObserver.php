<?php
namespace Observers\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ArticleObserver extends Observer
{
    public function created(Model $model)
    {
        \Log::info("Article created " . $model->id);
        $this->indexer->add($model);
        if (!\App::environment('testing')) {
            \Queue::push('UrlInformationsHandler', array('id' => $model->id));
            \Log::info("Add article " . $model->id . ' to queue for UrlInformationsHandler');
        }
    }

    public function updated(Model $model)
    {
        \Log::info("Article updated " . $model->id);
        $this->indexer->update($model);
    }

    public function deleted(Model $model)
    {
        \Log::info("Article deleted " . $model->id);
        $this->indexer->delete($model);
    }

    public function restored(Model $model)
    {
        \Log::info("Article restored " . $model->id);
    }

    /**
     * @param Model $model
     */
    public function saving(Model $model)
    {
        $date = Carbon::now()->addMinutes(1);
        if ($model->getOriginal('url') !== $model->url && !\App::environment('testing')) {
            \Queue::later($date, 'UrlInformationsHandler', array('id' => $model->id));
        }
    }
}
