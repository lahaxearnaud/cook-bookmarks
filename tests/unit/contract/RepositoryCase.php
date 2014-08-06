<?php

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
    abstract public function getRepositoryName();

    /**
     * ============================================
     *  FIND
     * ============================================
     */

    public function testFindOk()
    {
        $model = $this->repository->find(3);
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testFindKo()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->find(-1);
    }

    /**
     * ============================================
     *  ALL
     * ============================================
     */

    public function testAll()
    {
        $models = $this->repository->all();
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    /**
     * ============================================
     *  FindFirstBy
     * ============================================
     */

    public function testFindFirstByOk()
    {
        $model = $this->repository->findFirstBy('id', 3, '=');
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testFindFirstByKoBadKey()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->findFirstBy('dummy', 3, '=');
    }

    public function testFindFirstByKoBadValue()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->findFirstBy('id', -1, '=');
    }

    public function testFindFirstByKoBadOperator()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->findFirstBy('id', 3, 'dummy');
    }

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */

    public function testFindAllByOk()
    {
        $models = $this->repository->findAllBy('id', 5, '>');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    public function testFindAllByKoBadKey()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->findAllBy('dummy', 5, '>');
    }

    public function testFindAllByKoBadValue()
    {
        $models = $this->repository->findAllBy('id', 'dummy');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
        $this->assertEquals(0, $models->count());

    }

    public function testFindAllByKoBadOperator()
    {
        $models = $this->repository->findAllBy('id', 5, 'dummy');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
        $this->assertEquals(0, $models->count());
    }

    /**
     * ============================================
     *  Paginate
     * ============================================
     */

    public function testPaginateOk()
    {
        $paginate = $this->repository->paginate();
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    public function testPaginateKoBadNbPage()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->paginate(-10);
    }

    /**
     * ============================================
     *  PaginateWhere
     * ============================================
     */

    public function testPaginateWhereOk()
    {
        $paginate = $this->repository->paginateWhere(array(
            'id' => 1
        ));
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    public function testPaginateWhereKoBadKey()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $this->repository->paginateWhere(array(
            'dummy' => '3'
        ));
    }

    public function testPaginateWhereKoBadValue()
    {
        $paginate = $this->repository->paginateWhere(array(
            'id' => 'dummy'
        ));
        $this->assertInstanceOf('\Illuminate\Pagination\Paginator', $paginate);
    }

    public function testPaginateWhereKoBadNbPage()
    {
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

    public function testDeleteOk()
    {
        $result = $this->repository->delete(1);
        $this->assertTrue($result);
    }

    public function testDeleteKo()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->delete(-1);
    }

    /**
     * ============================================
     *  Has
     * ============================================
     */

    abstract public function testHasOk();
    abstract public function testHasKo();

    /**
     * ============================================
     *  Update
     * ============================================
     */

    abstract public function testUpdateOk();
    abstract public function testUpdateKo();

    /**
     * ============================================
     *  Create
     * ============================================
     */

    abstract public function testCreateOk();
    abstract public function testCreateKo();

    /**
     * ============================================
     *  Search
     * ============================================
     */

    abstract public function testSearchOk();
    abstract public function testSearchKo();
}
