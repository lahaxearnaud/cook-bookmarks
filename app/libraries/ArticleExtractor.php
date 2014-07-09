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

        if (function_exists('tidy_parse_string')) {

            $tidy = tidy_parse_string($content, array(
                    'indent'=>true,
                    'show-body-only' => true
                ), 'UTF8');

            $tidy->cleanRepair();
            $content = $tidy->value;
        }


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

            if (function_exists('tidy_parse_string')) {
                $tidy = tidy_parse_string($html, array(), 'UTF8');
                $tidy->cleanRepair();
                $html = $tidy->value;
            }


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