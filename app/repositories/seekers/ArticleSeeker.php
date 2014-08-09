<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 05/08/14
 * Time: 15:00
 */

namespace Repositories\Seekers;

class ArticleSeeker extends ElasticSearchSeeker
{

    /**
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return array
     */
    public function query ($query, array $parameters = array())
    {
        $parameters = array_merge(array(
            'max'    => 10,
            'offset' => 0
        ), $parameters);

        // query ElasticSearch
        $params['index']                                  = \Config::get('app.index');
        $params['type']                                   = strtolower(get_class($this->model));
        if(isset($parameters['user'])) {
            $params['body']['query']['bool']['must'][]['term'][$params['type'].'.user']  = $parameters['user'];
            $params['body']['query']['bool']['must'][]['query_string']['query'] = $query;
        }else{
            $params['body']['query']['query_string']['query'] = $query;
        }
        $result = \Es::search($params);

        // handle no result
        if ($result['hits']['total'] == 0 || $result['timed_out']) {
            return array();
        }

        // fetch articles in DB
        $arrayIds = array();
        foreach ($result['hits']['hits'] as $element) {
            $arrayIds[] = $element['_id'];
        }

        return array_slice($arrayIds, $parameters['offset'], $parameters['max']);
    }
}
