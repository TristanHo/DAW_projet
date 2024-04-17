<?php

class ModelQuestion{

    private $idQuestion;
    private $question;
    private $choix;
    private $matiere;
    private $lv;

    public function __construct($idQuestion = null, $question = null, $choix = array(), $matiere = null, $lv = null){
        // Vérifier si $idQuestion n'est pas null et attribuer sa valeur
        if($idQuestion !== null) {
            $this->idQuestion = $idQuestion;
        }
        // Vérifier si $question n'est pas null et attribuer sa valeur
        if($question !== null) {
            $this->question = $question;
        }
        // Attribuer les choix
        $this->choix = $choix;

        // Attribuer la matière
        $this->matiere = $matiere;

        // Attribuer le niveau
        $this->lv = $lv;
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
    public function getMatiere(){
        return $this->matiere;
    }

    public function setMatiere($matiere){
        $this->matiere = $matiere;
    }

    // Getter et setter pour le niveau
    public function getLv(){
        return $this->lv;
    }

    public function setLv($lv){
        $this->lv = $lv;
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

    public function afficherquestionformulaire(){
        echo "<div>";
        echo "<p>".$this->question."</p>";
        echo "<input type='hidden' name='id_question[]' value='".$this->idQuestion."'>";
        foreach($this->choix as $choix => $reponse) {
            echo "<input type='radio' name='reponse[".$this->idQuestion."]' value='".$choix."'>".$choix."<br>";
        }
        echo "</div>";
    }
    public function verifok($reponse){
        // Vérifier si la réponse soumise existe parmi les choix possibles de la question
        if(array_key_exists($reponse, $this->choix)) {
            // Vérifier si la réponse soumise correspond à la réponse correcte
            if ($this->choix[$reponse] == true) {
                return 1; // La réponse soumise est correcte
            } else {
                return 0; // La réponse soumise est incorrecte
            }
        } else {
            return 0; // La réponse soumise n'existe pas parmi les choix possibles de la question
        }
    }
    
}

?>