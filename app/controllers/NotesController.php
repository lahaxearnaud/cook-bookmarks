<?php

/**
 * @ApiRoute(name="/notes")
 * @ApiSector(name="Notes")
 */
class NotesController extends \RessourceController
{
    /**
     * @ApiDescription(description="Create a new note")
     * @ApiRoute(name="/create")
     * @ApiMethod(type="post")
     */
    public function store()
    {
        $model = $this->repository->create(Input::all());

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 201);
    }

    /**
     * @ApiDescription(description="Update an note")
     * @ApiParams(name="id", type="integer", nullable=false, description="Note id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="put")
     */
    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 200);
    }

}
