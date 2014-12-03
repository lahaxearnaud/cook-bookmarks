<?php

namespace Repositories\Seekers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class ElasticSearchSeeker implements SeekerInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     *
     * @param  string $query
     * @param  array  $parameters
     *
     * @return Collection
     */
    abstract public function query($query, array $parameters = array());
}
