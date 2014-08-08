<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NotesRepository extends EloquentRepository
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

            $user = NULL;
            if (isset($data['user_id'])) {
                $user = \User::findOrFail($data['user_id']);
            } else {
                $user = $data['user'];
                unset($data['user']);
            }

            $article = NULL;
            if (isset($data['article_id'])) {
                $article = \Article::findOrFail($data['article_id']);
            } else {
                $article = $data['article'];
                unset($data['article']);
            }

            $model = new \Note($data);
            $model->user()->associate($user);
            $model->article()->associate($article);

            $model->save();

            return $model;
        });
    }
}
