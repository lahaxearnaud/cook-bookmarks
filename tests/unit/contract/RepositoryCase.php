<?php
use Codeception\Util\Stub;
use AspectMock\Test as test;

abstract class RepositoryCase extends TestCase
{

    /**
     * @var Repositories\RepositoryInterface
     */
    protected $repository;


    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->repository = App::make($this->getRepositoryName());
        $this->model = $this->repository->getModel();
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

    public function testFindOk() {
        $model = $this->repository->find(1);
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testFindKo() {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->find(-1);
    }

    /**
     * ============================================
     *  ALL
     * ============================================
     */

    public function testAll() {
        $models = $this->repository->all();
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    /**
     * ============================================
     *  FindFirstBy
     * ============================================
     */

    function testFindFirstByOk() {
        $model = $this->repository->findFirstBy('id', 1, '=');
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    function testFindFirstByKoBadKey() {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->findFirstBy('dummy', 1, '=');
    }

    function testFindFirstByKoBadValue() {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->findFirstBy('id', -1, '=');
    }

    function testFindFirstByKoBadOperator() {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->findFirstBy('id', 1, 'dummy');
    }

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */

    function testFindAllByOk() {
        $models = $this->repository->findAllBy('id', 5, '>');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    function testFindAllByKoBadKey() {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->findAllBy('dummy', 5, '>');
    }

    function testFindAllByKoBadValue() {
        $models = $this->repository->findAllBy('id', 'dummy');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
        $this->assertEquals(0, $models->count());

    }

    function testFindAllByKoBadOperator() {
        $models = $this->repository->findAllBy('id', 5, 'dummy');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
        $this->assertEquals(0, $models->count());
    }

    /**
     * ============================================
     *  Paginate
     * ============================================
     */

    function testPaginateOk() {
        $paginate = $this->repository->paginate();
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    function testPaginateKoBadNbPage() {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->paginate(-10);
    }

    /**
     * ============================================
     *  PaginateWhere
     * ============================================
     */

    function testPaginateWhereOk() {
        $paginate = $this->repository->paginateWhere(array(
            'id' => 1
        ));
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    function testPaginateWhereKoBadKey() {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->paginateWhere(array(
            'dummy' => '3'
        ));
    }

    function testPaginateWhereKoBadValue() {
        $paginate = $this->repository->paginateWhere(array(
            'id' => 'dummy'
        ));
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    function testPaginateWhereKoBadNbPage() {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->paginateWhere(array(
            'id' => 1
        ), -10);
    }

    /**
     * ============================================
     *  Delete
     * ============================================
     */

    function testDeleteOk() {
        $result = $this->repository->delete(1);
        $this->assertTrue($result);
    }

    function testDeleteKo() {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->delete(-1);
    }

    /**
     * ============================================
     *  Has
     * ============================================
     */

    abstract function testHasOk();
    abstract function testHasKo();

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