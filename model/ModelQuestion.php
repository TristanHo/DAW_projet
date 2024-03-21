<?php

class ModelQuestion{

    private $idQuestion;
    private $question;
    private $choix;

    public function __construct($idQuestion=null, $question=null, $choix=array()){
        if($idQuestion != null){$this->idQuestion = $idQuestion;}
        if($question != null) {$this->question = $question;}
        $this->choix = $choix;
    }

    public function getIDQuestion(){
        return $this->idQuestion;
    }
    public function setIDQuestion($idQuestion){
        $this->idQuestion = $idQuestion;
        
    }

    public function getQuestion(){
        return $this->question;
    }
    public function setQuestion($question){
        $this->question = $question;
        
    }

    public function getChoix() {
        return $this->choix;
    }

    public function ajoutChoix($choix, $reponse) {
        if(!array_key_exists($choix, $this->choix)){
            $this->choix[$choix] = $reponse;
        } else {
            $this->choix[$choix] = $reponse;
        }
    }

    public function delChoix($choix) {
        if(array_key_exists($choix, $this->choix)){
            unset($this->choix[$choix]);
        }
    }

    public function afficher(){
        echo("Question ".$this->idQuestion.": ".$this->question."<br>");
        foreach($this->choix as $choix => $reponse) {
            echo($choix." ".$reponse."<br>");
        }
    }
}

?>