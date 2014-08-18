<?php

use \Repositories\RepositoryInterface;

/**
 * @ApiRoute(name="/articles")
 * @ApiSector(name="Articles")
 */
class ArticlesController extends \RessourceController
{

    /**
     * @var ArticleExtractor
     */
    protected $articleExtractor;

    /**
     * @var Html2Markdown
     */
    protected $html2markdown;

    public function __construct(RepositoryInterface $repository, ArticleExtractor $articleExtractor, Html2Markdown $html2Markdown)
    {
        $this->repository = $repository;
        $this->articleExtractor = $articleExtractor;
        $this->html2markdown = $html2Markdown;
    }

    /**
     * @ApiDescription(description="Create a new article")
     * @ApiRoute(name="/create")
     * @ApiMethod(type="post")
     */
    public function store()
    {
        $model = $this->repository->create(Input::all());

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 201);
    }

    /**
     * @ApiDescription(description="Update an article")
     * @ApiParams(name="id", type="integer", nullable=false, description="Article id")
     * @ApiRoute(name="/{id}")
     * @ApiMethod(type="put")
     */
    public function update($id)
    {
        $model = $this->repository->update($id, Input::all());

        return $this->generateResponse($model, $model->errors(), $this->generateLocation($model), 200);
    }

    /**
     * @ApiDescription(description="Get content of an article from a website")
     * @ApiParams(name="url", type="string", nullable=false, description="Url of the article")
     * @ApiRoute(name="/extractFromUrl")
     * @ApiMethod(type="post")
     */
    public function extractFromUrl()
    {

        $validator = Validator::make(Input::all(), [
            'url' => 'required|url',
        ]);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('success', false);
            $messages = $validator->messages()->toArray();
            array_walk($messages, function (&$item) {
                $item = current($item);
            });

            return Response::json($messages, 400);
        }

        $result = $this->articleExtractor->extractFromRemote(Input::get('url'));

        if(!$result['success']) {
            return Response::json($result, 400);
        }

        if(Input::get('markdown')) {
            $result['body'] = $this->html2markdown->convert($result['body']);
        }

        return Response::json($result);
    }

    /**
     * @ApiDescription(description="Get user article (paginated)")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiRoute(name="/user/{id}")
     * @ApiMethod(type="get")
     */
    public function user($user)
    {
        return $this->repository->paginateWhere(array(
            'author_id' => $user->id
        ), 20);
    }
}
