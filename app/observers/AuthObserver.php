<?php
namespace Observers;

use Repositories\CategoriesRepository;
use \Illuminate\Events\Dispatcher;

class AuthObserver
{

    protected $categoryRepository;

    function __construct(CategoriesRepository $categoryRepository = null)
    {
        if (is_null($categoryRepository)) {
            $categoryRepository = \App::make('CategoriesRepository');
        }

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     *
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {
        $className = get_class($this);

        $events->listen('user.subscribe', $className . '@created');
        $events->listen('user.lostPassword', $className . '@lostPassword');
        $events->listen('user.changePassword', $className . '@changePassword');
    }


    public function created(\User $user)
    {

        \Log::info('User ' . $user->id . ' created');

        $this->categoryRepository->create([
            'name'  => 'Entrée',
            'color' => '#000000',
            'user'  => $user
        ]);

        $this->categoryRepository->create([
            'name'  => 'Plat',
            'color' => '#000000',
            'user'  => $user
        ]);

        $this->categoryRepository->create([
            'name'  => 'Dessert',
            'color' => '#000000',
            'user'  => $user
        ]);

        $this->categoryRepository->create([
            'name'  => 'Boisson',
            'color' => '#000000',
            'user'  => $user
        ]);

        \Mail::queue('emails.auth.subscribe', ['username' => $user->username], function ($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Welcome!');
        });
    }

    public function lostPassword(\User $user, $token)
    {
        if (!is_string($token)) {
            throw new \LogicException('Event user.lostPassword needs a string as parameters ' . $token . ' given');
        }

        \Log::info('User ' . $user->id . ' lost his password');

        \Mail::queue('emails.auth.lostPassword', ['username' => $user->username, 'email' => $user->email, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Lost password');
        });
    }

    public function changePassword(\User $user)
    {

        \Log::info('User ' . $user->id . ' change his password');

        \Mail::queue('emails.auth.changePassword', ['username' => $user->username], function ($message) use ($user) {
            $message->to($user->email, $user->username)->subject('Change password');
        });
    }
}