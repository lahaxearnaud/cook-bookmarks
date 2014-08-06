<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryObserver extends Observer
{
    public function created(Model $model)
    {
        \Log::info("Category saved " . $model->id);
    }

    public function updated(Model $model)
    {
        \Log::info("Category updated " . $model->id);
        foreach($model->articles as $article) {
            $this->indexer->update($article);
        }
    }

    public function deleted(Model $model)
    {
        \Log::info("Category  deleted " . $model->id);
        foreach($model->articles as $article) {
            $this->indexer->update($article);
        }
    }

    public function restored(Model $model)
    {
        \Log::info("Category  restored " . $model->id);
    }

}
