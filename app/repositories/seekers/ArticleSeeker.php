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
        // query ElasticSearch
        $params['index']                                  = \Config::get('app.index');
        $params['type']                                   = strtolower(get_class($this->model));

        $params['body']['query']['bool']['must'][]['query_string']['query'] = $query;
        if(isset($parameters['user_id']) && !empty($parameters['user_id'])) {
            $params['body']['query']['bool']['must'][]['term'][$params['type'].'.user']  = $parameters['user'];
        }

        if(isset($parameters['category_id']) && !empty($parameters['category_id'])) {
            $params['body']['query']['bool']['must'][]['term'][$params['type'].'.category_id']  = $parameters['category_id'];
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


    /**
     *
     * @param string $query
     * @param array  $parameters
     *
     * @return array
     */
    public function autocomplete ($query, array $parameters = array())
    {
        $parameters = array_merge(array(
            'max'    => 10,
            'offset' => 0
        ), $parameters);

        $params['index'] = \Config::get('app.index');

        // query ElasticSearch
        $params['body'][strtolower(get_class($this->model))] = array(
            "text" => $query,
            "completion" => array(
                "field" => "autocomplete"
            )
        );

        $result = \Es::suggest($params);
        $result = current($result[strtolower(get_class($this->model))]);
        $result  = $result['options'];

        // handle no result
        if (count($result) == 0) {
            return array();
        }

        foreach ($result as $element) {
            $searchResults[] = [
                'id' => $element['payload']['id'],
                'title' => $element['text']
            ];
        }

        return array_slice($searchResults, $parameters['offset'], $parameters['max']);
    }

}
