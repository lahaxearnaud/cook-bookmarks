<?php

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
/**
 * @author Arnaud LAHAXE <lahaxe.arnaud@gmail.com>
 */
class ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $readability = new Readability($html, $url);
        $readability->debug = false;
        $readability->convertLinksToFootnotes = true;
        $result = $readability->init();

        if(!$result) {
            return array(
                'title' => '',
                'body' => 'Unable to fetch content',
                'success' => false
            );
        }

        $content = $readability->getContent()->innerHTML;
        $content = String::tidy($content, array(
            'indent'=>true,
            'show-body-only' => true
        ), 'UTF8');

        return array(
            'title' => $readability->getTitle()->textContent,
            'body' => $content,
            'success' => true
        );
    }

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
            ), 'UTF8');

            return $this->extract($html ,$url);
        } catch(ClientErrorResponseException $e) {
            return array(
                'title' => '',
                'body' => $e->getMessage(),
                'success' => false
            );
        }

    }
}
