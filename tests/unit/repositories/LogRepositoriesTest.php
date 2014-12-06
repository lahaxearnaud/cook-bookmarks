<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 21:35
 */

/**
 * Class NoteRepositoriesTest
 *
 */
class LogRepositoriesTest extends RepositoryCase
{
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
    public function getRepositoryName()
    {

        return 'LogsRepository';
    }

    /**
     * ============================================
     *  Update
     * ============================================
     */
    public function testUpdateOk()
    {
        $result = $this->repository->update(1, array(
            'method' => 'POST'
        ));
        $this->assertInstanceOf(get_class($this->model), $result);

        $result = $this->repository->update(1, array(
            'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255)
        ));
        $this->assertInstanceOf(get_class($this->model), $result);
    }

    public function testUpdateKo()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->repository->update(-1, array(
            'method' => 'POST'
        ));
        $this->assertInstanceOf(get_class($this->model), $result);
    }

    /**
     * ============================================
     *  Create
     * ============================================
     */
    public function testCreateOk()
    {
        $model = $this->repository->create(array(
            'user_id'    => 1,
            'url'        => route('api.v1.notes.index'),
            'route'      => 'api.v1.notes.index',
            'params'     => json_encode(array()),
            'method'     => 'GET',
            'httpCode'   => 200,
            'ip'         => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
        ));
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testCreateKo()
    {
    }

    /**
     * ============================================
     *  Search
     * ============================================
     */
    public function testSearchOk()
    {
        $results  = $this->repository->search('test');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $results);
    }

    public function testSearchKo()
    {
        // TODO: Implement testSearchKo() method.
    }

    /**
     * ============================================
     *  Has
     * ============================================
     */
    public function testHasOk()
    {
    }

    public function testHasKo()
    {
    }
}
