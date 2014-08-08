<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoriesRepository extends EloquentRepository
{
    /**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
    public function search($query, array $where = array())
    {
        return new Collection();
    }

    /**
	 * @param  array  $data
	 * @return Model
	 */
    public function create(array $data)
    {
        return $this->cacheWrapper('create', function () use ($data) {

            $author = NULL;
            if (isset($data['user_id'])) {
                $author = \User::findOrFail($data['user_id']);
            } else {
                $author = $data['user'];
                unset($data['user']);
            }

            $model = new \Category($data);
            $model->user()->associate($author);
            $model->save();

            return $model;
        });
    }
}
