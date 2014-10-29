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
    }


    public function created ($user)
    {

        if(!$user instanceof \User) {
            throw new \LogicException('Event user.subscribe needs an user as parameters ' . get_class($params[0]) . ' given');
        }

        \Log::info('User ' . $user->id . ' credated');

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
    }
}