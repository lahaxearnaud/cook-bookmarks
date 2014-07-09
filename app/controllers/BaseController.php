<?php

use Repositories\RepositoryInterface;

abstract class BaseController extends Controller
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
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
     */
    public function index()
    {

        return $this->repository->paginate(20);
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
	 * @param  int  $id
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {

        return $this->repository->find($id);
    }

    /**
	 * Update the specified resource in storage.
	 * @author LAHAXE Arnaud
	 * @param  int  $id
	 * @return Response
	 */
    abstract public function update($id);

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
     *
     * @ApiDescription(description="Delete an article")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="delete")
	 */
    public function destroy($id)
    {
        $result = $this->repository->delete($id);


        return Response::json(array('success' => $result));
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

    protected function generateResponse($errors)
    {
        if(count($errors) === 0) {

            return Response::json(array('success' => true));
        }


        return Response::json($errors);
    }
}
