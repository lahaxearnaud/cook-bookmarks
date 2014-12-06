<?php

namespace Extractors;

class ReadabilityExtractor extends \ArticleExtractor
{
    public function extract($html, $url = '')
    {
        $readability                          = new \Readability($html, $url);
        $readability->debug                   = false;
        $readability->convertLinksToFootnotes = false;
        $result                               = $readability->init();

        if (!$result) {
            return array(
                'title'   => '',
                'body'    => 'Unable to fetch content',
                'success' => false
            );
        }

        $content = $readability->getContent()->innerHTML;
        $content = \String::tidy($content, array(
            'indent'         => true,
            'show-body-only' => true
        ));

        return array(
            'title'   => $readability->getTitle()->textContent,
            'body'    => $content,
            'success' => true
        );
    }
}

;
