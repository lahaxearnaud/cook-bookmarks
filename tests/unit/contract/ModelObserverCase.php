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

    abstract public function getDatabaseModel();

    abstract public function getNonSavedModel();

    abstract protected function buildObserver();

    abstract public function testSavingOk();

    abstract public function testSavedOk();

    abstract public function testUpdatingOk();

    abstract public function testUpdatedOk();

    abstract public function testCreatingOk();

    abstract public function testCreatedOk();

    abstract public function testDeletingOk();

    abstract public function testDeletedOk();

    abstract public function testRestoringOk();

    abstract public function testRestoredOk();
}
