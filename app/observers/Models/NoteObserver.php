<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class NoteObserver extends Observer
{
    public function saved(Model $model)
    {
        \Log::info("Note saved " . $model->id);
    }

    public function updated(Model $model)
    {
        \Log::info("Note updated " . $model->id);
    }

    public function deleted(Model $model)
    {
        \Log::info("Note deleted " . $model->id);
    }

    public function restored(Model $model)
    {
        \Log::info("Note restored " . $model->id);
    }

}
