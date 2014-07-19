<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleObserver extends Observer
{
    public function saved(Model $model)
    {
        \Log::info("Article saved " . $model->id);
    }

    public function updated(Model $model)
    {
        \Log::info("Article updated " . $model->id);
    }

    public function deleted(Model $model)
    {
        \Log::info("Article deleted " . $model->id);
    }

    public function restored(Model $model)
    {
        \Log::info("Article restored " . $model->id);
    }

}
