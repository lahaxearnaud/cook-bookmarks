<?php

/**
 * @author Arnaud LAHAXE <lahaxe.arnaud@gmail.com>
 */
class Html2Markdown extends HTML_To_Markdown
{
    public function convert($html)
    {
        $this->set_option('strip_tags', true);


        return parent::convert($html);
    }

}
