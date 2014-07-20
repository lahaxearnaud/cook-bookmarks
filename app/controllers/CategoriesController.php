<?php

/**
 * @ApiRoute(name="/categories")
 * @ApiSector(name="Categories")
 */
class CategoriesController extends \BaseController
{
    /**
     * @ApiDescription(description="Create a new category")
     * @ApiRoute(name="/create")
     * @ApiMethod(type="post")
     */
    public function store()
    {
        $model = $this->repository->create(Input::all());

        return $this->generateResponse($model->errors(), $this->generateLocation($model), 201);
    }

    /**
     * @ApiDescription(description="Update an category")
     * @ApiParams(name="id", type="integer", nullable=false, description="Category id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="put")
     */
    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());

        return $this->generateResponse($model->errors(), $this->generateLocation($model), 200);
    }

    /**
     * @ApiDescription(description="Get user categories (paginated)")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiRoute(name="/user/{id}")
     * @ApiMethod(type="get")
     */
    public function user($user)
    {
        return $this->repository->paginateWhere(array(
            'user_id' => $user->id
        ), 20);
    }
}
