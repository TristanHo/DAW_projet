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
    public function calculerScore($reponsesSoumises) {
        $score = 0;
        $compteur=0;
        //echo 'Vérification en cours<br>';
        foreach ($this->listeQuestions as $question) {
            $compteur++;
            $idQuestion = $question->getIDQuestion(); // Suppose que chaque question a un identifiant unique
            //echo 'ID de la question traitée: ' . $idQuestion . '<br>';
            if (isset($reponsesSoumises[$idQuestion])) {
                // Vérifier si la réponse soumise correspond à la réponse attendue pour cette question
                $reponseSoumise = $reponsesSoumises[$idQuestion];
                //echo 'ID de la question: ' . $idQuestion . '<br> Réponse soumise: ' . $reponseSoumise;
                //$question->afficher();
                $res = $question->verifok($reponseSoumise);
                // La réponse est correcte, incrémenter le score
                $score = $score + $res;
            }
        }
        //return le pourcentage si >50% il passe au niveau du dessus valable pour les qcm cour pas qcmintro
        // Calculer le pourcentage de bonnes réponses
    $pourcentage = ($score / $compteur) * 100;

    return $pourcentage;
    }

    public function calcul_score_intro($reponsesSoumises) {

       
        $compteur= 0;
        $tempo=0;
        $tempomatiere='';
        foreach ($this->listeQuestions as $question) {
            $compteur++;
            $idQuestion = $question->getIDQuestion();
            $matiere= $question->getMatiere();
            $lv= $question->getLv();
           //echo'id: '.$idQuestion.' matiere: '.$matiere.' lv: '.$lv."<br>";
            if (isset($reponsesSoumises[$idQuestion])) {
                
                $reponseSoumise = $reponsesSoumises[$idQuestion];
                //echo'choix reponse '.$reponseSoumise .' <br>';
                $res = $question->verifok($reponseSoumise);
                if ($res > 0) {
                   // echo'juste <br>';
                    if($lv==2){
                        echo 'attribution du lv 2 dans le domaine '.$matiere.'<br>';
                    }
                    else {
                        //lv =1 car que 2 lv possible ici 
                        if(($tempo==1)&& ($tempomatiere==$matiere)){
                            echo 'attribution du lv1 a la matire '.$matiere.'<br>';
                        }else {
                            $tempo=1;
                            $tempomatiere=$matiere;
                            
                            }
                        
                    }
                }
                
            }
        }
        echo 'fin traitement';

    }

    public function affiche_modif()
    //fonction de modification du qcm this
    {
        
        echo "<form action='modifier_qcm.php' method='post'>";
        foreach ($this->listeQuestions as $question) {
            echo "<div>";
            echo "<label>Question : </label>";
            echo "<input type='text' name='question[]' value='" . $question->getQuestion() . "'>";
            echo "<br>";
            $cmp=0;
            foreach($question->getChoix() as $choix=> $reponse){
                $cmp++;
                echo "<label>Réponse ".$cmp.": </label>";
                echo "<input type='text' name='reponse[]' value='" . $choix . "'>";
               
            }
            //pour l'indice de la reponse juste (entre 1 et 4)
            echo "<br>";
            echo "<label>Bonne réponse : </label>";
            echo "<input type='text' name='question[]' value='" . $question->getReponse() . "'>";

             echo "</div>";
            
        }
        echo "<input type='submit' value='Valider les modifications'>";
        echo "</form>";
    }
    //fonction de modification dans le fichier xml ou sauvgarde si il n'existe pas encore
    public function modif_sauv_qcm($idqcm) {
        $xmlFile = "../../BD/exemple.xml";
        $xml = simplexml_load_file($xmlFile);    
        // Rechercher le QCM à modifier en fonction de son ID
        foreach ($xml->qcm as $qcm) {
            if ($qcm->idqcm == $idqcm) {
                // Mettre à jour les questions et réponses du QCM en fonction des données soumises dans le formulaire
                foreach ($qcm->questions->question as $question) {
                    // Récupérer l'index de la question dans le formulaire
                    $index = (int)$_POST['index'];
    
                    // Mettre à jour la question et les réponses
                    $question->questionposer = $_POST['question'][$index];
                    $question->reponse = $_POST['reponse'][$index];
                }
                // Enregistrer les modifications dans le fichier XML
                $xml->asXML($xmlFile);
                return true; // Modification réussie
            }
        }
    
        // Si le QCM n'a pas été trouvé
        return false;
    }
    
    
}

?>