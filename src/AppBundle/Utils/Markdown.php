<?php

namespace AppBundle\Utils;

class Markdown
{
    private $parser;

    public function _construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHtml($text)
    {
        return $this->parser->text($text);
    }
}