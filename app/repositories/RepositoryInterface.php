<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

	/**
	 * returns a collection of all models
	 *
	 * @return Collection
	 */
	public function all();

	/**
	 * returns the model found
	 *
	 * @param int $id
	 * @return Model
	 */
	public function find($id);

	/**
	 * returns the repository itself, for fluent interface
	 *
	 * @param array $with
	 * @return self
	 */
	public function with(array $with);

	/**
	 * returns the first model found by conditions
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string $operator
	 * @return Model
	 */
	public function findFirstBy($key, $value, $operator = '=');

	/**
	 * returns all models found by conditions
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string $operator
	 * @return Collection
	 */
	public function findAllBy($key, $value, $operator = '=');

	/**
	 * returns all models that have a required relation
	 *
	 * @param string $relation
	 * @return Collection
	 */
	public function has($relation);

	/**
	 * @param  integer $nbByPage
	 * @return Collection
	 */
	public function paginate($nbByPage = 10);

	/**
	 * @param  array   $where
	 * @param  integer $nbByPage
	 * @return Collection
	 */
	public function paginateWhere(array $where, $nbByPage = 1);

	/**
	 * @param  integer $id
	 * @param  array  $data
	 * @return Model
	 */
	public function update($id, array $data);

	/**
	 * @param  integer $id
	 * @return bool
	 */
	public function delete($id);

	/**
	 * @param  array  $data
	 * @return Model
	 */
	public function create(array $data);

	/**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
	public function search($query, array $where = array());
}