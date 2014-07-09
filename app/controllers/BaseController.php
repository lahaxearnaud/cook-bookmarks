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
	 *
	 * @param  int  $id
	 * @return Response
	 */
    abstract public function update($id);

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {
        $result = $this->repository->delete($id);


        return Response::json(array('success' => $result));
    }

    public function search()
    {
        $query = Input::get('query');


        return $this->repository->dearch($query);
    }

    protected function generateResponse($errors)
    {
        if(count($errors) === 0) {

            return Response::json(array('success' => true));
        }


        return Response::json($errors);
    }
}
