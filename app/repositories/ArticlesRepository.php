<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ArticlesRepository extends EloquentRepository
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

        $author = $data['author'];
        unset($data['author']);

        $model = parent::create($data);
        $model->account()->associate($author);
        $model->save();

        return $model;
    }
}
