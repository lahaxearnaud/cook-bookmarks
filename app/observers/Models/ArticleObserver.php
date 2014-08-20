<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleObserver extends Observer
{
    public function created(Model $model)
    {
        \Log::info("Article created " . $model->id);
        $this->indexer->add($model);
        \Queue::push('UrlInformationsHandler', array('id' => $model->id));
    }

    public function updated(Model $model)
    {
        \Log::info("Article updated " . $model->id);
        $this->indexer->update($model);
        \Queue::push('UrlInformationsHandler', array('id' => $model->id));
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

}
