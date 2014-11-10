<?php
namespace Observers;

use \Repositories\CategoriesRepository;

class AuthObserver
{

    protected $categoryRepository;

    function __construct (CategoriesRepository $categoryRepository = null)
    {
        if(is_null($categoryRepository)) {
            $categoryRepository = \App::make('CategoriesRepository');
        }

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     *
     * @return array
     */
    public function subscribe ($events)
    {
        $className = get_class($this);

        $events->listen('user.subscribe', $className . '@created');
        $events->listen('user.lostPassword', $className . '@lostPassword');
        $events->listen('user.changePassword', $className . '@changePassword');
    }


    public function created ($user)
    {

        if(!$user instanceof \User) {
            throw new \LogicException('Event user.subscribe needs an user as parameters ' . get_class($user) . ' given');
        }

        \Log::info('User ' . $user->id . ' created');

        $this->categoryRepository->create([
            'name' => 'Entrée',
            'color' => '#000000',
            'user' => $user
        ]);

        $this->categoryRepository->create([
            'name' => 'Plat',
            'color' => '#000000',
            'user' => $user
        ]);

        $this->categoryRepository->create([
            'name' => 'Dessert',
            'color' => '#000000',
            'user' => $user
        ]);

        $this->categoryRepository->create([
            'name' => 'Boisson',
            'color' => '#000000',
            'user' => $user
        ]);

        \Mail::queue('emails.auth.subscribe', ['username' => $user->username], function($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Welcome!');
        });
    }

    public function lostPassword ($user, $token)
    {
        if(!$user instanceof \User) {
            throw new \LogicException('Event user.lostPassword needs an user as parameters ' . get_class($user) . ' given');
        }

        if(!$token instanceof \Token) {
            throw new \LogicException('Event user.lostPassword needs a token as parameters ' . get_class($token) . ' given');
        }

        \Log::info('User ' . $user->id . ' lost his password');

        \Mail::queue('emails.auth.lostPassword', ['username' => $user->username, 'email' => $user->email, 'token' => $token->token], function($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Lost password');
        });
    }

    public function changePassword ($user, $token)
    {
        if(!$user instanceof \User) {
            throw new \LogicException('Event user.changePassword needs an user as parameters ' . get_class($user) . ' given');
        }

        \Log::info('User ' . $user->id . ' change his password');

        \Mail::queue('emails.auth.changePassword', ['username' => $user->username], function($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Change password');
        });
    }
}