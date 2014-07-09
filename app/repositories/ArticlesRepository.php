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
        $author = null;
        if(isset($data['author_id'])) {
            $author = \User::find($data['author_id']);
        }else {
            $author = $data['author'];
            unset($data['author']);
        }

        $model = new \Article($data);
        $model->author()->associate($author);
        $model->save();


        return $model;
    }
}
