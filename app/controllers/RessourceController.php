<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/08/14
 * Time: 12:28
 */

use Repositories\RepositoryInterface;

abstract class RessourceController extends BaseController
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
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
        return $this->repository->paginate(20, Input::get('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    abstract public function store();

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     *
     * @ApiDescription(description="Find an article")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="get")
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author LAHAXE Arnaud
     *
     * @param  int $id
     *
     * @return Response
     */
    abstract public function update($id);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     *
     * @ApiDescription(description="Delete an article")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="delete")
     * @ApiReturn(type="object", sample="{
     *  'success':'bool',
     * }")
     */
    public function destroy($id)
    {
        $model  = $this->repository->find($id);
        $result = $this->repository->delete($id);

        $errors = [];

        if (!$result) {
            $errors[] = 'Error during delete';
        }

        return $this->generateResponse($model, $errors, array(), 200);
    }

    /**
     * @author LAHAXE Arnaud
     * @return mixed
     *
     * @ApiDescription(description="Search an article")
     * @ApiParams(name="query", type="string", nullable=false, description="Query for the search")
     * @ApiRoute(name="/search/{query}")
     * @ApiMethod(type="get")
     */
    public function search()
    {
        $query = Input::get('query');

        return $this->repository->search($query);
    }
}
