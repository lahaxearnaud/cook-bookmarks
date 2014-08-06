<?php
namespace Observers\Models;

use Illuminate\Database\Eloquent\Model;

class NoteObserver extends Observer
{
    public function created(Model $model)
    {
        \Log::info("Note saved " . $model->id);
        $this->indexer->add($model->article);
    }

    public function updated(Model $model)
    {
        \Log::info("Note updated " . $model->id);
        $this->indexer->update($model->article);
    }

    public function deleted(Model $model)
    {
        \Log::info("Note deleted " . $model->id);
        $this->indexer->delete($model->article);
    }

    public function restored(Model $model)
    {
        \Log::info("Note restored " . $model->id);
    }

}
