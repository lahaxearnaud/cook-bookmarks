<?php
use Codeception\Util\Stub;
use AspectMock\Test as test;

class ArticleRepositoryTest extends RepositoryCase
{

    protected function _after()
    {
        test::clean();
    }

    // tests
    public function testMe()
    {
        $this->repository->all();
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
    function getRepositoryName ()
    {
        return "ArticlesRepository";
    }
}