<?php

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\CurlException;
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
        ));

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
            ));

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
