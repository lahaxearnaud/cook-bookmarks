<?php

use Repositories\Seekers\ArticleSeeker;

class AutocompleteController extends BaseController
{
    /**
     * @var ArticleSeeker
     */
    protected $seeker;

    public function __construct(ArticleSeeker $seeker)
    {
        $this->seeker = $seeker;
    }

    public function query()
    {
        $query       = Input::get('query');
        $query       = str_replace('+', ' ', $query);
        $category_id = Input::get('category_id');
        $user_id     = Input::get('user_id', Auth::User()->id);

        return $this->seeker->autocomplete($query, [
            'category_id' => $category_id,
            'user'        => $user_id
        ]);
    }

}
