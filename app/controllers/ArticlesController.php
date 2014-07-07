<?php

class ArticlesController extends \BaseController {

	public function create()
	{
		$model = $this->repository->create(Input::all());

		$errors = $model->errors();

		if(count($errors) === 0) {
			return Response::json(array('success' => true));
		}

		return Response::json($errors);
	}

	public function update($id)
	{
		$model = $this->repository->update($id, Input::all());

		$errors = $model->errors();

		if(count($errors) === 0) {
			return Response::json(array('success' => true));
		}

		return Response::json($errors);
	}

}