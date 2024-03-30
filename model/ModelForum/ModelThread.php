<?php

class ModelThread
{
    private $id;
    private $topic;
    private $author;
    private $date;
    private ModelMessage $messages;

    public function __construct($id, $topic, $author)
    {
        $this->id = $id;
        $this->topic = $topic;
        $this->author = $author;
        $this->date = date("Y-m-d H:i:s");
    }

    public function getId(){ return $this->id; }
    public function getTopic(){ return $this->topic; }
    public function getAuthor(){ return $this->author; }
    public function getDate(){ return $this->date; }
    public function getMessages(){ return $this->messages; }
}