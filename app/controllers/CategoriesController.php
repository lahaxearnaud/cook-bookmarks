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

        return $this->generateResponse($model->errors());
    }

    /**
     * @ApiDescription(description="Update an category")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="put")
     */
    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());

        return $this->generateResponse($model->errors());
    }

    /**
     * @ApiDescription(description="Update an category")
     * @ApiParams(name="url", type="string", nullable=false, description="Url of the article")
     * @ApiRoute(name="/url/{url}")
     * @ApiMethod(type="post")
     */
    public function url()
    {
        return array();
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
            'author_id' => $user->id
        ), 20);
    }
}
