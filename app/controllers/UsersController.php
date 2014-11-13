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
    protected $userRepository;

    /**
     * @var TokenManagerInterface
     */
    protected $tokenManager;

    public function __construct(RepositoryInterface $userRepository, TokenManagerInterface $tokenManager)
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
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

        $user = $this->userRepository->create(Input::all());

        if(count($user->errors()) === 0) {
            Event::fire('user.subscribe', ['user' => $user]);
        }

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

        $user = $this->userRepository->update($user->id, array(
            'password' => Input::get('newPassword')
        ));

        if(count($user->errors()) > 0) {
            Event::fire('user.changePassword', ['user' => $user]);
        }

        return $this->generateResponse($user, $user->errors());
    }

    /**
     * @ApiDescription(description="Send email with token an url to change the password")
     * @ApiParams(name="email", type="string", nullable=false, description="Email")
     * @ApiRoute(name="/password/lost}")
     * @ApiMethod(type="post")
     */
    public function askNewPasswordToken()
    {
        $user = $this->userRepository->findByEmail(Input::get('email'));
        $token = $this->tokenManager->generate($user);

        Event::fire('user.lostPassword', ['user' => $user, 'token' => $this->tokenManager->getCryptTokenValue($token)]);

        return Response::json(['success' => true], 200);
    }

    /**
     * @ApiDescription(description="Change the password with a validation of token get via /users/password/lost")
     * @ApiParams(name="token", type="string", nullable=false, description="Token")
     * @ApiParams(name="email", type="string", nullable=false, description="Email of the user")
     * @ApiParams(name="newPassword", type="string", nullable=false, description="The new password")
     * @ApiParams(name="newPassword_confirmation", type="string", nullable=false, description="Confirmation of the new password")
     * @ApiRoute(name="/password/change}")
     * @ApiMethod(type="post")
     */
    public function changeLostPassword()
    {
        $user = $this->userRepository->findByEmail(Input::get('email'));
        $token = $this->tokenManager->get($user, $this->tokenManager->decryptTokenValue(Input::get('token')));

        if(!$this->tokenManager->isValid($token)) {
            return Response::json(['success' => false], 400);
        }

        $validator = Validator::make(Input::all(), [
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

        $user = $this->userRepository->update($user->id, array(
            'password' => Input::get('newPassword')
        ));

        if(count($user->errors()) == 0) {
            $this->tokenManager->burn($token);
            Event::fire('user.changePassword', ['user' => $user]);
        }

        return $this->generateResponse($user, $user->errors());
    }
}
