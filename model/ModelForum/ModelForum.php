<?php

error_reporting(E_ALL); ini_set('display_errors', 1);


class ModelForum
{
    private $subsArray;

    public function __construct(){ $this->subsArray = array(); }


    public function getSubs(){ return $this->subsArray; }
}