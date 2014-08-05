<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleObserver extends Observer
{
    public function saved(Model $model)
    {
        \Log::info("Article saved " . $model->id);
        $this->indexer->add($model);
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

}
