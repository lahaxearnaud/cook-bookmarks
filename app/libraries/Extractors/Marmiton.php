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

    $body = $body->innertext;
    $body = preg_replace( '/Ingrédients(\s)?(\(pour\s[0-9]+\spersonne(s)?\))\s:/', '<h2>${0}</h2><br/>', $body );
    $body = str_replace(['<h4>', '</h4>'], ['<h2>', '</h2>'], $body);

    return array(
            'title' => $this->tidyTile($title->plaintext),
            'body' => $body,
            'success' => true
        );
    }

};
