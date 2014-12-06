<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 21:35
 */

/**
 * Class CategoryRepositoriesTest
 *
 */
class CategoryRepositoriesTest extends RepositoryCase
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
		return 'CategoriesRepository';
	}

	/**
	 * ============================================
	 *  FindAllBy
	 * ============================================
	 */
	public function testHasOk()
	{
		$models = $this->repository->has('user');
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
				'name' => 'Lorem Ipsum',
			));
		$this->assertInstanceOf(get_class($this->model), $result);

		$result = $this->repository->update(1, array(
				'user_id' => 1,
			));
		$this->assertInstanceOf(get_class($this->model), $result);
	}

	public function testUpdateKo()
	{
		$this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
		$result = $this->repository->update(-1, array(
				'user_id' => 1,
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
				'user_id' => 1,
				'name'    => 'Lorem Ipsum Dolore',
				'color'   => '#000',
			));
		$this->assertInstanceOf(get_class($this->model), $model);

		$model = $this->repository->create(array(
				'user'  => User::find(1),
				'name'  => 'Lorem Ipsum Dolore',
				'color' => '#000',

			));
		$this->assertInstanceOf(get_class($this->model), $model);
	}

	public function testCreateKo()
	{
		$model = $this->repository->create(array(
				'user_id' => 1,
				'body'    => 'L',
			));
		$this->assertInstanceOf(get_class($this->model), $model);
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
