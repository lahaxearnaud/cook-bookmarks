<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;

class LogsRepository extends EloquentRepository
{
    /**
     * @param string $query
     * @param array  $where
     *
     * @return Collection
     */
    public function search($query, array $where = array())
    {
        return new Collection();
    }

}
