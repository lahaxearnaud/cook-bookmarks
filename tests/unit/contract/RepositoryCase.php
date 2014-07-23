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

    /**
     * ============================================
     *  FIND
     * ============================================
     */

    abstract function testFindOk();
    abstract function testFindKo();

    /**
     * ============================================
     *  ALL
     * ============================================
     */

    abstract function testAll();

    /**
     * ============================================
     *  FindFirstBy
     * ============================================
     */

    abstract function testFindFirstByOk();
    abstract function testFindFirstByKoBadKey();
    abstract function testFindFirstByKoBadValue();
    abstract function testFindFirstByKoBadOperator();

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */

    abstract function testFindAllByOk();
    abstract function testFindAllByKoBadKey();
    abstract function testFindAllByKoBadValue();
    abstract function testFindAllByKoBadOperator();

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */

    abstract function testHasOk();
    abstract function testHasKo();

    /**
     * ============================================
     *  Paginate
     * ============================================
     */

    abstract function testPaginateOk();
    abstract function testPaginateKoBadNbPage();

    /**
     * ============================================
     *  PaginateWhere
     * ============================================
     */

    abstract function testPaginateWhereOk();
    abstract function testPaginateWhereKoBadKey();
    abstract function testPaginateWhereKoBadValue();
    abstract function testPaginateWhereKoBadOperator();
    abstract function testPagnateWhereKoBadNbPage();

    /**
     * ============================================
     *  Delete
     * ============================================
     */

    abstract function testDeleteOk();
    abstract function testDeleteKo();

    /**
     * ============================================
     *  Update
     * ============================================
     */

    abstract function testUpdateOk();
    abstract function testUpdateKo();

    /**
     * ============================================
     *  Create
     * ============================================
     */

    abstract function testCreateOk();
    abstract function testCreateKo();

    /**
     * ============================================
     *  Search
     * ============================================
     */

    abstract function testSearchOk();
    abstract function testSearchKo();
}