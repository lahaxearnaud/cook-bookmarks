<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;
use \User as User;

class TokensRepository extends EloquentRepository
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
     * @param $token
     *
     * @return Collection|static[]
     */
    public function getByToken($token, User $user)
    {
        $query = $this->make();

        return $query->where('token', $token)
                     ->where('user_id', $user->id)
                     ->firstOrFail();
    }
}
