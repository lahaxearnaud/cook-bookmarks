<?php

class CategoryObserverTest extends ModelObserverCase
{

    protected function buildObserver()
    {

        return new Observers\Models\CategoryObserver(new ArticleIndexerMock);
    }

    public function getDatabaseModel()
    {

        return Category::find(1);
    }

    public function getNonSavedModel()
    {

        return new Category(array(
            'user_id' => 1,
            'name' => 'Lorem Ipsum Dolore'
        ));
    }
}
