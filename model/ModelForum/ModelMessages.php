<?php

class ModelMessage
{
    private $content;
    private $author;
    private $repliesArray;

    public function __construct($content, $author, $repliesArray)
    {
        $this->content = $content;
        $this->author = $author;
        $this->repliesArray = $repliesArray;
    }

    public function getContent(){ return $this->content; }
    public function getAuthor(){ return $this->author; }
    public function getReplies(){ return $this->repliesArray; }
}