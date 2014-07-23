<?php
use Codeception\Util\Stub;
use AspectMock\Test as test;

abstract class RepositoryCase extends TestCase
{

    /**
     * @var Repositories\RepositoryInterface
     */
    protected $repository;


    public function setUp()
    {
        parent::setUp();

        $this->repository = App::make($this->getRepositoryName());
    }

    /**
     *
     * must match with the bind
     * ex:
     *      For :
     *          App::bind('NotesRepository', function ($app) {...});
     *      This function return 'NotesRepository'
     *
     * @return string
     */
    abstract function getRepositoryName();
}