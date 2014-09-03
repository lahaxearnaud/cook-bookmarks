<?php

use \Repositories\RepositoryInterface;

/**
 * @ApiRoute(name="/categories")
 * @ApiSector(name="Categories")
 */
class CategoriesController extends \RessourceController
{

    public function __construct(RepositoryInterface $repository, RepositoryInterface $articleRepository)
    {
        $this->repository = $repository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     *
     *
     * @ApiDescription(description="Get all (paginated)")
     * @ApiParams(name="page", type="integer", nullable=true, description="Page num")
     * @ApiRoute(name="/?page={page}")
     * @ApiMethod(type="get")
     * @ApiReturn(type="object", sample="{
     *  'per_page':'integer',
     *  'from':'integer',
     *  'data':'array',
     *  'total':'integer',
     *  'current_page':'integer',
     *  'last_page':'integer',
     *  'to':'integer',
     * }")
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * @ApiDescription(description="Create a new category")
     * @ApiRoute(name="/create")
     * @ApiMethod(type="post")
     */
    public function store()
    {
        $model = $this->repository->create(Input::all());

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 201);
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

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 200);
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
        ), 20, Input::get('page'));
    }

        /**
     * Display a listing of the resource.
     * @return Response
     *
     *
     * @ApiDescription(description="Get article from an article  (paginated)")
     * @ApiParams(name="category_id", type="integer", nullable=true, description="Category id")
     * @ApiRoute(name="/?page={page}")
     * @ApiMethod(type="get")
     * @ApiReturn(type="object", sample="{
     *  'per_page':'integer',
     *  'from':'integer',
     *  'data':'array',
     *  'total':'integer',
     *  'current_page':'integer',
     *  'last_page':'integer',
     *  'to':'integer',
     * }")
     */
    public function articles($category)
    {
        return $this->articleRepository->paginateWhere([
            'category_id' => $category->id
        ], 20, Input::get('page'));
    }
}
