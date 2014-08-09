<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Collection;


class UsersRepository extends EloquentRepository
{

    /**
     * @param  string $query
     * @param  array $where
     *
     * @return Collection
     */
    public function search ($query, array $where = array())
    {
        return new Collection();
    }

    public function create (array $data)
    {
        $data['password'] = \Hash::make($data['password']);
        $user             = new \User($data);
        $user->save();

        return $user;
    }

    public function update ($id, array $data)
    {
        $user           = $this->find($id);
        $user->password = \Hash::make($data['password']);
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        $user->save();

        return $user;
    }
}
