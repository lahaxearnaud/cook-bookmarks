<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryObserver extends Observer
{
    public function saved(Model $model)
    {
        \Log::info("Category saved " . $model->id);
    }

    public function updated(Model $model)
    {
        \Log::info("Category updated " . $model->id);
    }

    public function deleted(Model $model)
    {
        \Log::info("Category  deleted " . $model->id);
    }

    public function restored(Model $model)
    {
        \Log::info("Category  restored " . $model->id);
    }

}
