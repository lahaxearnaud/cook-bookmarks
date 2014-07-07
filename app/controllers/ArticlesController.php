<?php

class ArticlesController extends \BaseController
{
    public function create()
    {
        $model = $this->repository->create(Input::all());

        return $this->generateResponse($model->errors());
    }

    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());

        return $this->generateResponse($model->errors());
    }

}
