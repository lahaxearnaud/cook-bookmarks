<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleObserver extends Observer
{
    public function saved(Model $model)
    {
        \Log::info("saved " . $model->id);
    }

    public function updated(Model $model)
    {
        \Log::info("updated " . $model->id);
    }

    public function deleted(Model $model)
    {
        \Log::info("deleted " . $model->id);
    }

    public function restored(Model $model)
    {
        \Log::info("restored " . $model->id);
    }

}
