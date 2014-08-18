<?php

use \Repositories\RepositoryInterface;

/**
 * @ApiRoute(name="/users")
 * @ApiSector(name="users")
 */
class UsersController  extends BaseController
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
     * @ApiDescription(description="Create a new user")
     * @ApiParams(name="email", type="string", nullable=false, description="Email")
     * @ApiParams(name="username", type="string", nullable=false, description="Username")
     * @ApiParams(name="password", type="string", nullable=false, description="Password")
     * @ApiRoute(name="/subscribe}")
     * @ApiMethod(type="post")
     */
    public function subscribe()
    {
        $validator = Validator::make(Input::all(), [
            'email' => 'required|email',
            'username' => 'required|min:5',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            $validator->getMessageBag()->add('success', false);
            $messages = $validator->messages()->toArray();
            array_walk($messages, function (&$item) {
                $item = current($item);
            });

            return Response::json($messages, 400);
        }

        $user = $this->repository->create(Input::all());

        return $this->generateResponse($user, $user->errors(), [], 200);
    }

    /**
     * @ApiDescription(description="Change current user password")
     * @ApiParams(name="oldPassword", type="string", nullable=false, description="Old password")
     * @ApiParams(name="newPassword", type="string", nullable=false, description="The new password")
     * @ApiParams(name="newPassword_confirmation", type="string", nullable=false, description="Confirmation of the new password")
     * @ApiRoute(name="/password}")
     * @ApiMethod(type="post")
     */
    public function changePassword()
    {
        $validator = Validator::make(Input::all(), [
            'oldPassword' => 'required|min:5',
            'newPassword' => 'required|min:5|confirmed'
        ]);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('success', false);
            $messages = $validator->messages()->toArray();
            array_walk($messages, function (&$item) {
                $item = current($item);
            });

            return Response::json($messages, 400);
        }

        $user = Auth::user();
        if (! Hash::check(Input::get('oldPassword'), $user->getAuthPassword())) {
            return Response::json(['Old password not correct'], 400);
        }

        $user = $this->repository->update($user->id, array(
            'password' => Input::get('newPassword')
        ));

        return $this->generateResponse($user, $user->errors());
    }

}
