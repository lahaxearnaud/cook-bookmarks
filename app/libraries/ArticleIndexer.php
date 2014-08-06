<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 05/08/14
 * Time: 11:57
 */
use \Illuminate\Database\Eloquent\Model;

class ArticleIndexer
{
    protected function getTypeByObject (Model $model)
    {
        return strtolower(get_class($model));
    }

    protected function getDataToIndex (Article $article)
    {
        $data              = array();
        $data['title']     = $article->title;
        $data['indexable'] = $article->indexable;
        $data['author']    = $article->author->username;
        $data['category']  = $article->category->name;

        $notes = array();
        foreach ($article->notes as $note) {
            $notes[] = $note->body;
        }

        $data['notes'] = $notes;

        return $data;
    }

    public function add (Article $article)
    {
        // add in elastic search
        $params          = array();
        $params['index'] = \Config::get('app.index');
        $params['type']  = $this->getTypeByObject($article);
        $params['id']    = $article->id;
        $params['body']  = $this->getDataToIndex($article);
        \Es::index($params);
    }

    public function update (Article $article)
    {
        $params['index']       = \Config::get('app.index');
        $params['type']        = $this->getTypeByObject($article);
        $params['id']          = $article->id;
        $params['body']['doc'] = $this->getDataToIndex($article);

        \Es::update($params);
    }

    public function delete (Article $article)
    {
        $params['index'] = \Config::get('app.index');
        $params['type']  = $this->getTypeByObject($article);
        $params['id']    = $article->id;

        \Es::delete($params);
    }
}
