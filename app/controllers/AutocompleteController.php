<?php

use Repositories\Seekers\ArticleSeeker;

class AutocompleteController  extends BaseController
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
        $query = Input::get('query');
        $category_id = Input::get('category_id');
        $user_id = Input::get('user_id');

        return $this->seeker->autocomplete($query, [
            'category_id' => $category_id,
            'user_id' => $user_id
        ]);
    }

}
