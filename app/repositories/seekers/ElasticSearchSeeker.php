<?php

namespace Repositories\Seekers;


use Illuminate\Database\Eloquent\Collection;
use Repositories\RepositoryInterface;

abstract class ElasticSearchSeeker implements SeekerInterface {

	protected $repository;

	public function __construct(RepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	/**
	 *
	 * @param  string $query
	 * @param  array  $parameters
	 * @return Collection
	 */
	abstract function query($query, array $parameters = array());

	/**
	 * @param  array  $ids
	 * @return Collection
	 */
	public function getModelsFromId(array $ids)
	{
		if(empty($ids)) {
			return new Collection();
		}

		return $this->repository->in($ids);
	}
}