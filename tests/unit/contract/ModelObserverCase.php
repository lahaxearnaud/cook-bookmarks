<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 25/07/14
 * Time: 07:15
 */

abstract class ModelObserverCase extends TestCase
{
    /**
     * @var \Observers\Models\ObserverInterface
     */
    protected $observer;

    /**
     * @return mixed
     */
    public function getObserver()
    {

        return $this->observer;
    }

    public function setUp()
    {
        parent::setUp();

        $this->observer = $this->buildObserver();
    }

    public function testSavingOk()
    {
        $this->observer->saving($this->getNonSavedModel());
    }

    public function testSavedOk()
    {
        $this->observer->saved($this->getDatabaseModel());
    }

    public function testUpdatingOk()
    {
        $this->observer->updating($this->getDatabaseModel());
    }

    public function testUpdatedOk()
    {
        $this->observer->updated($this->getDatabaseModel());
    }

    public function testCreatingOk()
    {
        $this->observer->saving($this->getNonSavedModel());
    }

    public function testCreatedOk()
    {
        $this->observer->created($this->getDatabaseModel());
    }

    public function testDeletingOk()
    {
        $this->observer->deleting($this->getDatabaseModel());
    }

    public function testDeletedOk()
    {
        $this->observer->deleted($this->getDatabaseModel());
    }

    public function testRestoringOk()
    {
        $this->observer->restoring($this->getDatabaseModel());
    }

    public function testRestoredOk()
    {
        $this->observer->restored($this->getDatabaseModel());
    }
}
