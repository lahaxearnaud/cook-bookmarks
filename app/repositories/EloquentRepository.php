<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

abstract class EloquentRepository implements RepositoryInterface
{
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

        return $this->cacheWrapper('all', function() {

            return $this->model->all();
        });
    }

    /**
	 * returns a collection of all models
	 *
	 * @return Collection
	 */
    public function in($ids)
    {

        return $this->cacheWrapper('in', function() use ($ids) {

            return $this->model->whereIn('id', $ids)->get();
        }, [$ids]);
    }

    /**
	 * returns the model found
	 *
	 * @param int $id
	 * @return Model
	 */
    public function find($id)
    {

        return $this->cacheWrapper('find', function() use ($id) {
            $query = $this->make();

            return $query->findOrFail($id);
        }, [$id]);
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

        return $this->cacheWrapper('findFirstBy', function() use ($key, $value, $operator){
            $query = $this->make();

            return $query->where($key, $operator, $value)->firstOrFail();
        }, [$key, $value, $operator]);
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

        return $this->cacheWrapper('findAllBy', function() use ($key, $value, $operator){
            $query = $this->make();

            return $query->where($key, $operator, $value)->get();
        }, [$key, $value, $operator]);
    }

    /**
	 * returns all models that have a required relation
	 *
	 * @param string $relation
	 * @return Collection
	 */
    public function has($relation)
    {

        return $this->cacheWrapper('has', function() use ($relation){
            $query = $this->make();

            return $query->has($relation)->get();
        }, [$relation]);
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
        return $this->cacheWrapper('has', function() use ($id, $data){
            $model = $this->find($id);
            foreach ($data as $key => $value) {
                $model->{$key} =  $value;
            }
            $model->updateUniques();

            return $model;
        }, [$id, $data]);
    }

    /**
	 * @param  integer $id
	 * @return bool
	 */
    public function delete($id)
    {

        return $this->cacheWrapper('has', function() use ($id){
            $model = $this->find($id);

            return $model->delete();
        }, [$id]);
    }

    /**
	 * @param  array  $data
	 * @return Model
	 */
    public function create(array $data)
    {
        return $this->cacheWrapper('has', function() use ($data){
            $class = get_class($this->model);
            $model = new $class($data);

            $model->save();

            return $model;
        }, [$data]);
    }

    /**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
    abstract public function search($query, array $where = array());

    /**
	 * returns the query builder with eager loading, or the model itself
	 *
	 * @return Builder|Model
	 */
    public function make()
    {
        return $this->model->with($this->with);
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }


    protected function cacheWrapper($eventName, \Closure $action, array $parametersToObserver = array())
    {
        $results = \Event::fire('article.'.$eventName . '.before', [$parametersToObserver]);
        if($results) {

            return current($results);
        }

        $results =  $action();

        \Event::fire($eventName . '.after', [$parametersToObserver, $results]);
        return $results;
    }
}
