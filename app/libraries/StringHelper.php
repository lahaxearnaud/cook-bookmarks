<?php

class StringHelper
{

    /**
     * Capatilize first letter of each word of a string.
     *
     * @param string $value
     *
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }

    /**
     * @param $value
     * @param $option
     * @param $encoding
     *
     * @internal param $html
     * @return string
     */
    public static function tidy($value, $options = array(), $encoding = 'utf8')
    {
        // Check to see if Tidy is available.
        if (class_exists('tidy')) {
            $tidy = new tidy();
            $tidy->parseString($value, $options, $encoding);
            $tidy->cleanRepair();
            $value = $tidy."";
        }

        return $value;
    }

    public static function extract($text, $nbWords = 100, $end = '...', $allowedTags = '')
    {

        if ($nbWords <= 0) {
            return '';
        }

        // strip not allowed html tags
        $text = strip_tags($text, $allowedTags);

        return Str::words($text, $nbWords, $end);
    }

}
