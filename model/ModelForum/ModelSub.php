<?php

class ModelSub
{
    private $discipline;
    private $threadsArray;

    public function __construct($discipline, $threadArray)
    {
        $this->discipline = $discipline;
        $this->threadsArray = $threadArray;
    }

    public function getDiscipline(){ return $this->discipline; }
    public function getThreads(){ return $this->threadsArray; }
}