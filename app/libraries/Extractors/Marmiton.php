<?php

namespace Extractors;

require public_path().'/../vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';

class Marmiton extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $html = str_get_html($html);

        $title = $html->find('.m_title  .item  .fn', 0);
        $body = $html->find('.m_content_recette_main', 0);

        if(is_null($title) || is_null($body)) {
            return array(
                'title' => '',
                'body' => '',
                'success' => false
            );
        }

    return array(
            'title' => is_null($title)?'':$title->plaintext,
            'body' => is_null($body)?'':$body->innertext,
            'success' => true
        );
    }

};
