<?php

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\CurlException;
/**
 * @author Arnaud LAHAXE <lahaxe.arnaud@gmail.com>
 */
class ArticleExtractor
{
    public function extractFromRemote($url)
    {
        try {
            $client = new Client($url);
            $request = $client->get();
            $response = $request->send();
            $html = $response->getBody();
            $html = String::tidy($html, array(
                'indent'=>true,
                'show-body-only' => true
            ));
/** FETCH EXTRACTOR */
            return $this->extract($html ,$url);
        } catch(ClientErrorResponseException $e) {
            return array(
                'title' => '',
                'body' => $e->getMessage(),
                'success' => false
            );
        } catch(CurlException $e) {
            return array(
                'title' => '',
                'body' => $e->getMessage(),
                'success' => false
            );
        }

    }
}
