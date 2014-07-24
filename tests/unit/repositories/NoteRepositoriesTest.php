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
class NoteRepositoriesTest extends RepositoryCase
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
        return 'NotesRepository';
    }

    /**
     * ============================================
     *  Hass
     * ============================================
     */
    public function testHasOk ()
    {
        $models = $this->repository->has('user');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);

        $models = $this->repository->has('article');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    public function testHasKo ()
    {
        $this->setExpectedException('BadMethodCallException');
        $this->repository->has('dummy');
    }
    /**
     * ============================================
     *  Update
     * ============================================
     */
    public function testUpdateOk()
    {
        $result = $this->repository->update(1, array(
            'body' => 'Lorem Ipsum dolore'
        ));
        $this->assertInstanceOf(get_class($this->model), $result);

        $result = $this->repository->update(1, array(
            'user_id' => 1
        ));
        $this->assertInstanceOf(get_class($this->model), $result);
    }

    public function testUpdateKo()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->repository->update(-1, array(
            'user_id' => 1
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
            'article_id' => 1,
            'user_id' => 1,
            'body' => 'Lorem Ipsum Dolore...'
        ));
        $this->assertInstanceOf(get_class($this->model), $model);

        $model = $this->repository->create(array(
            'article' => Article::find(1),
            'user' => User::find(1),
            'body' => 'Lorem Ipsum Dolore...'
        ));
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testCreateKo()
    {
        $model = $this->repository->create(array(
            'article_id' => 1,
            'user_id' => 1,
            'body' => 'L'
        ));
        $this->assertInstanceOf(get_class($this->model), $model);
        $this->assertNotEmpty($model->errors());

        $model = $this->repository->create(array(
            'article' => Article::find(1),
            'user' => User::find(1),
            'body' => 'L'
        ));
        $this->assertInstanceOf(get_class($this->model), $model);
        $this->assertNotEmpty($model->errors());
    }

    public function testCreateKoArticleNotFound()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->create(array(
            'article_id' => -1,
            'user_id' => 1,
            'body' => 'Lorem Ipsum Dolore'
        ));
    }

    public function testCreateKoUserNotFound()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->repository->create(array(
            'article_id' => 1,
            'user_id' => -1,
            'body' => 'Lorem Ipsum Dolore'
        ));
    }

    /**
     * ============================================
     *  Search
     * ============================================
     */
    public function testSearchOk ()
    {
        $results  = $this->repository->search('test');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $results);
    }

    public function testSearchKo()
    {
        // TODO: Implement testSearchKo() method.
    }
}
