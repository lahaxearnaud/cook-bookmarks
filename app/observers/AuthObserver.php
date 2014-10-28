<?php
namespace Observers;

use \Repositories\CategoriesRepository;

class AuthObserver
{

    protected $categoryRepository;

    function __construct (CategoriesRepository $categoryRepository)
    {
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
        $events->listen('user.subscribe', 'AuthObserver@credated');
    }


    public function credated (\User $user)
    {
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