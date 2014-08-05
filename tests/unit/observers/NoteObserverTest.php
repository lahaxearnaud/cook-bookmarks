<?php

class NoteObserverTest extends ModelObserverCase
{
    protected function buildObserver()
    {
        return new Observers\Models\NoteObserver(new ArticleIndexerMock);
    }

    public function getDatabaseModel()
    {
        return Note::find(1);
    }

    public function getNonSavedModel()
    {
        return new Note(array(
            'article_id' => 1,
            'user_id' => 1,
            'body' => 'Lorem Ipsum Dolore...'
        ));
    }
}
