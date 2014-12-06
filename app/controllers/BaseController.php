<?php

use Illuminate\Database\Eloquent\Model;

abstract class BaseController extends Controller
{

    protected function generateResponse(Model $model, $errors, $headers = array(), $httpCode = 200)
    {
        if (count($errors) === 0) {

            $response = Response::json(array(
                'success' => true,
                'id'      => $model->id,
            ), $httpCode);

            if (!empty($headers)) {
                $response->headers->add($headers);
            }


            return $response;
        }


        return Response::json($errors);
    }

    protected function generateLocation(Model $model)
    {
        $routeName = 'api.v1.' . $model->getTable() . '.show';


        return array(
            "Url" => route($routeName, array(
                'id' => $model->id
            )),
            'Id'  => $model->id
        );
    }
}
