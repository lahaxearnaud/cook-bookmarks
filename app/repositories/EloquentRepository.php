<?php

namespace Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface {

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * with eager loadings
	 *
	 * @var array
	 */
	protected $with = array();


	public function __construct(Model $model, $with = array())
	{
		$this->model = $model;
		$this->with = $with;
	}


	/**
	 * returns a collection of all models
	 *
	 * @return Collection
	 */
	public function all()
	{
		return $this->model->all();
	}

	/**
	 * returns a collection of all models
	 *
	 * @return Collection
	 */
	public function in($ids)
	{
		return $this->model->whereIn('id', $ids)->get();
	}

	/**
	 * returns the model found
	 *
	 * @param int $id
	 * @return Model
	 */
	public function find($id)
	{
		$query = $this->make();

		return $query->find($id);
	}

	/**
	 * returns the repository itself, for fluent interface
	 *
	 * @param array $with
	 * @return self
	 */
	public function with(array $with)
	{
		$this->with = array_merge($this->with, $with);

		return $this;
	}

	/**
	 * returns the first model found by conditions
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string $operator
	 * @return Model
	 */
	public function findFirstBy($key, $value, $operator = '=')
	{
		$query = $this->make();

		return $query->where($key, $operator, $value)->first();
	}

	/**
	 * returns all models found by conditions
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string $operator
	 * @return Collection
	 */
	public function findAllBy($key, $value, $operator = '=')
	{
		$query = $this->make();

		return $query->where($key, $operator, $value)->get();
	}

	/**
	 * returns all models that have a required relation
	 *
	 * @param string $relation
	 * @return Collection
	 */
	public function has($relation)
	{
		$query = $this->make();

		return $query->has($relation)->get();
	}

	/**
	 * returns paginated result
	 *
	 * @param int $limit
	 * @return Collection
	 */
	public function paginate($nbByPage = 10)
	{
		$query = $this->make();

		return $query->paginate($nbByPage);
	}


	/**
	 * @param array $where
	 * @param int $page
	 * @param int $limit
	 * @return PaginatedInterface
	 */
	public function paginateWhere(array $where, $nbByPage = 1)
	{
		$query = $this->make();

		return $query->where($where)->paginate($nbByPage);
	}

	/**
	 * @param  integer $id
	 * @param  array  $data
	 * @return Model
	 */
	public function update($id, array $data)
	{
		$model = $this->find($id);
		foreach ($data as $key => $value) {
			$model->{$key} =  $value;
		}

		$model->save();
	}

	/**
	 * @param  integer $id
	 * @return bool
	 */
	public function delete($id)
	{
		$model = $this->find($id);

		return $model->delete();
	}

	/**
	 * @param  array  $data
	 * @return Model
	 */
	public function create(array $data)
	{
		$class = get_class($this->model);
		$model = new $class($data);

		return $model->save();
	}

	/**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
	abstract function search($query, array $where = array());

	/**
	 * returns the query builder with eager loading, or the model itself
	 *
	 * @return Builder|Model
	 */
	public function make()
	{
		return $this->model->with($this->with);
	}
}