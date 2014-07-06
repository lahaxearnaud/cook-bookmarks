<?php

namespace Seekers;

use Illuminate\Database\Eloquent\Collection;

interface SeekerInterface {

	/**
	 *
	 * @param  string $query
	 * @param  array  $parameters
	 * @return Collection
	 */
	public function query($query, array $parameters = array());
}