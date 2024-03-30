<?php

class ModelReplies
{
    private $content;
    private $author;
    private $date;

    public function __construct($content, $author, $date)
    {
        $this->content = $content;
        $this->author = $author;
        $this->date = $date;
    }
}