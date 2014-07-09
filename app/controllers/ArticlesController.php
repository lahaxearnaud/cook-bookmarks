<?php

class ArticlesController extends \BaseController
{
    public function store()
    {
        $model = $this->repository->create(Input::all());


        return $this->generateResponse($model->errors());
    }

    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());


        return $this->generateResponse($model->errors());
    }

    public function url()
    {

        return array();
    }

    public function user($user)
    {

        return $this->repository->paginateWhere(array(
            'author_id' => $user->id
        ), 20);
    }
}
