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

    public function __construct(Model $model, $with = array(), ElasticSearchSeeker $elasticSearchSeeker)
    {
        $this->model = $model;
        $this->with = $with;
        $this->seeker = $elasticSearchSeeker;
    }

    /**
	 * @param  string $query
	 * @param  array  $where
	 * @return Collection
	 */
    public function search($query, array $where = array())
    {
        $arrayIds = $this->seeker->query($query, $where);

        if(count($arrayIds) === 0) {
            return new Collection();
        }

        $articles =  $this->in($arrayIds);
\Log::info($articles);
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
        $author = null;
        if(isset($data['author_id'])) {
            $author = \User::findOrFail($data['author_id']);
        }else {
            $author = $data['author'];
            unset($data['author']);
        }

        $category = null;
        if(isset($data['category_id'])) {
            $category = \Category::findOrFail($data['category_id']);
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
