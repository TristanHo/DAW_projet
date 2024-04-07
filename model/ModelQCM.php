<?php
require_once("ModelQuestion.php");

class ModelQCM {
    private $idQCM;
    private $listeQuestions;

    function __construct($idQCM = null, $listeQuestions=array()) {
        if($idQCM != null) {$this->idQCM = $idQCM;}
        $this->listeQuestions = $listeQuestions;
    }

    public function getIdQCM() {return $this->idQCM;}

    public function getListeQuestions() {return $this->listeQuestions;}

    public function setIdQCM($idQCM) {$this->idQCM = $idQCM;}

    public function ajoutQuestion($question) {
        if(!array_key_exists($question->getIDQuestion(), $this->listeQuestions)) {
            $this->listeQuestions[$question->getIDQuestion()] = $question;
        }
    }

    public function delQuestion($question) {
        if(array_key_exists($question->getIDQuestion(), $this->listeQuestions)) {
            unset($this->listeQuestions[$question->getIDQuestion()]);
        }
    }

    // Fonction statique pour récupérer toutes les voitures de la base de données
    public static function getQCM() {
        // Connexion à la base de données (supposons que cela est géré dans votre classe Model)
        $model = new Model();
        $pdo = $model->getPdo();
        
        // Requête pour récupérer toutes les voitures
        $stmt = $pdo->query('SELECT * FROM voiture');
        
        // Tableau pour stocker les voitures
        $voitures = array();
        
        // Récupération des données et remplissage du tableau de voitures
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Création d'une nouvelle instance de Voiture à partir des données récupérées
            $voiture = new Voiture($row['marque'], $row['coul'], $row['immatriculation']);
            // Ajout de la voiture au tableau
            $voitures[] = $voiture;
        }
        
        // Retourne le tableau des voitures
        return $voitures;
    }

    //fonction pour afficher les questions
    public  function afficheQuestions() {
        foreach( $this->listeQuestions as $quest)
        $quest->afficher();
    }
}

?>