<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Repositories\Seekers\ElasticSearchSeeker;

class ArticlesRepository extends EloquentRepository
{
    /**
     * @var ElasticSearchSeeker
     */
    protected $seeker;

    public function __construct(Model $model, $with = array(), \User $user, ElasticSearchSeeker $elasticSearchSeeker)
    {
        $this->model = $model;
        $this->with = $with;
        $this->seeker = $elasticSearchSeeker;
        $this->user = $user;
    }

    /**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
    public function search($query, array $where = array())
    {
        $where['user'] = $this->user->id;
        $arrayIds = $this->seeker->query($query, $where);

        if(count($arrayIds) === 0) {
            return new Collection();
        }

        $articles =  $this->in($arrayIds);
        // sort post in the ES order
        $sorted = array_flip($arrayIds);
        foreach ($articles as $article) {
            $sorted[$article->id] = $article;
        }

        // rebuild a collection for the pagination
        return Collection::make(array_values($sorted));
    }

    /**
	 * @param  array  $data
	 * @return Model
	 */
    public function create(array $data)
    {
        return $this->cacheWrapper('create', function () use ($data) {
            $author = NULL;
            if (isset($data['author_id'])) {
                $author = \User::findOrFail($data['author_id']);
            } else {
                $author = $data['author'];
                unset($data['author']);
            }

            $category = NULL;
            if (isset($data['category_id'])) {
                $category = \Category::findOrFail($data['category_id']);
            } else {
                $category = $data['category'];
                unset($data['category']);
            }

            if(!isset($data['slug'])) {
                $data['slug'] = \Str::slug($data['title']).'-'.uniqid();
            }

            if(!isset($data['indexable'])) {
                $data['indexable'] = $data['body'];
            }

            $model = new \Article($data);
            $model->author()->associate($author);
            $model->category()->associate($category);

            $model->save();

            return $model;
        });
    }
}
