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
            $author = \User::findOrFail($data['author_id']);
        }else {
            $author = $data['author'];
            unset($data['author']);
        }

        $category = null;
        if(isset($data['category_id'])) {
            $category = \User::findOrFail($data['category_id']);
        }else {
            $category = $data['category'];
            unset($data['category']);
        }

        $model = new \Article($data);
        $model->author()->associate($author);
        $model->category()->associate($category);

        $model->save();

        return $model;
    }
}
