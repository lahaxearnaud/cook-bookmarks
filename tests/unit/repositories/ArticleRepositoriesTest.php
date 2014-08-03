<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 21:35
 */

/**
 * Class ArticleRepositoriesTest
 *
 */
class ArticleRepositoriesTest extends RepositoryCase
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
        return 'ArticlesRepository';
    }

    /**
     * ============================================
     *  Has
     * ============================================
     */
    public function testHasOk()
    {
        $models = $this->repository->has('author');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);

        $models = $this->repository->has('category');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $models);
    }

    public function testHasKo()
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
            'title' => 'Lorem Ipsum'
        ));
        $this->assertInstanceOf(get_class($this->model), $result);

        $result = $this->repository->update(1, array(
            'author_id' => 2
        ));
        $this->assertInstanceOf(get_class($this->model), $result);

        $result = $this->repository->update(1, array(
            'body' => 'Lorem Ipsum...'
        ));
        $this->assertInstanceOf(get_class($this->model), $result);
    }

    public function testUpdateKo()
    {
        $result = $this->repository->update(1, array(
            'title' => 'Lo'
        ));
        $this->assertEquals(1, count($result));
    }

    public function testUpdateKoArticleNotFound()
    {
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');

        $result = $this->repository->update(-1, array(
            'title' => 'Lorem Ipsum'
        ));
    }

    public function testUpdateKoAuthorNotFound()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');

        $result = $this->repository->update(1, array(
            'author_id' => -1
        ));
        $this->assertFalse($result);
    }

    /**
     * ============================================
     *  Create
     * ============================================
     */
    public function testCreateOk()
    {
        $model = $this->repository->create(array(
            'title'       => 'Lorem Ipsum',
            'body'        => 'Lorem Ipsum dolore...',
            'indexable'   => 'Lorem Ipsum dolore...',
            'url'         => 'http://google.com',
            'author_id'   => 1,
            'category_id' => 1

        ));
        $this->assertInstanceOf(get_class($this->model), $model);

        $model = $this->repository->create(array(
            'title'     => 'Lorem Ipsum',
            'body'      => 'Lorem Ipsum dolore...',
            'indexable' => 'Lorem Ipsum dolore...',
            'url'       => 'http://google.com',
            'author'    => User::find(1),
            'category'  => Category::find(1)

        ));
        $this->assertInstanceOf(get_class($this->model), $model);
    }

    public function testCreateKo()
    {
        $model = $this->repository->create(array(
            'title'       => 'L',
            'body'        => 'Lorem Ipsum dolore...',
            'indexable'   => 'Lorem Ipsum dolore...',
            'url'         => 'http://google.com',
            'author_id'   => 1,
            'category_id' => 1

        ));
        $this->assertNotEmpty($model->errors());

        $model = $this->repository->create(array(
            'title'       => 'Lorem Ipsum',
            'body'        => 'L',
            'indexable'   => 'Lorem Ipsum dolore...',
            'url'         => 'http://google.com',
            'author_id'   => 1,
            'category_id' => 1

        ));
        $this->assertNotEmpty($model->errors());

        $model = $this->repository->create(array(
            'title'       => 'Lorem Ipsum',
            'body'        => 'Lorem Ipsum dolore...',
            'indexable'   => 'Lorem Ipsum dolore...',
            'url'         => 'dummy',
            'author_id'   => 1,
            'category_id' => 1

        ));
        $this->assertNotEmpty($model->errors());
    }

    /**
     * ============================================
     *  Search
     * ============================================
     */
    public function testSearchOk()
    {
        $results = $this->repository->search('test');
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $results);
    }

    public function testSearchKo()
    {
        // TODO: Implement testSearchKo() method.
    }
}
