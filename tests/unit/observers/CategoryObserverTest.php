<?php

class CategoryObserverTest extends ModelObserverCase
{

    public function testSavingOk ()
    {
        $this->observer->saving($this->getNonSavedModel());
    }

    public function testSavedOk ()
    {
        $this->observer->saved($this->getDatabaseModel());
    }

    public function testUpdatingOk ()
    {
        $this->observer->updating($this->getDatabaseModel());
    }

    public function testUpdatedOk ()
    {
        $this->observer->updated($this->getDatabaseModel());
    }

    public function testCreatingOk ()
    {
        $this->observer->saving($this->getNonSavedModel());
    }

    public function testCreatedOk ()
    {
        $this->observer->created($this->getDatabaseModel());
    }

    public function testDeletingOk ()
    {
        $this->observer->deleting($this->getDatabaseModel());
    }

    public function testDeletedOk ()
    {
        $this->observer->deleted($this->getDatabaseModel());
    }

    public function testRestoringOk ()
    {
        $this->observer->restoring($this->getDatabaseModel());
    }

    public function testRestoredOk ()
    {
        $this->observer->restored($this->getDatabaseModel());
    }

    protected function buildObserver ()
    {
        return new Observers\Models\CategoryObserver();
    }

    function getDatabaseModel ()
    {
        return Category::find(1);
    }

    function getNonSavedModel ()
    {
        return new Category(array(
            'user_id' => 1,
            'name' => 'Lorem Ipsum Dolore'
        ));
    }
}