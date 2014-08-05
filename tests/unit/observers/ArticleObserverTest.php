<?php

class ArticleObserverTest extends ModelObserverCase
{


    protected function buildObserver()
    {
        return new Observers\Models\ArticleObserver(new ArticleIndexerMock);
    }

    public function getDatabaseModel()
    {
        return Article::find(1);
    }

    public function getNonSavedModel()
    {
        return new Article(array(
            'title'       => 'Lorem Ipsum',
            'body'        => 'Lorem Ipsum dolore...',
            'indexable'   => 'Lorem Ipsum dolore...',
            'url'         => 'http://google.com',
            'author_id'   => 1,
            'category_id' => 1

        ));
    }
}
