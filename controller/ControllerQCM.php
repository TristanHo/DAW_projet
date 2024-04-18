<?php
require_once(__DIR__ . '/../model/ModelQCM.php');
require_once(__DIR__ . '/../model/ModelXml.php');
require_once(__DIR__ . '/../model/ModelQuestion.php');
error_reporting(E_ALL);

class ControllerQCM
{
    private $modelXml;
    public function __construct()
    {
        $this->modelXml = new ModelXml();
        
    }
    public function recupqcm($idqcm)
    //fait pour appel depuis les view
    {
        
        if($idqcm=='qcmintro'){
            $this->modelXml->recupqcmintro("../../BD/exemple.xml");
        }
        else{
            $this->modelXml->recupqcm($idqcm,"../../BD/exemple.xml");
        }
        return $this->modelXml;
    }
    public static function getPDO()
    {
        //recupere les element depuis confic pour conection a la bd

        try {
            $dbh =  new PDO('mysql:host=localhost;dbname=DAW_Project', 'root', '');
            return $dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function valideQCM($nomcours, $lvcours, $loginetu)
    {
        $dbh = ControllerQCM::getPDO();
        // Utilisation de requête préparée pour éviter les injections SQL
        $query = 'INSERT INTO cours_valider (id, nomcours, lv, login) VALUES (null, :nomcours, :lvcours, :loginetu)';
        $requ = $dbh->prepare($query);
        $requ->bindParam(':nomcours', $nomcours);
        $requ->bindParam(':lvcours', $lvcours);
        $requ->bindParam(':loginetu', $loginetu);
        // evoie de la requete a la BD
        $requ->execute();
    }
    //
    //fonction de modification dans le fichier xml ou sauvgarde si il n'existe pas encore
    public static function modif_sauv_qcm()
    {
        $xmlFile = "../../BD/exemple.xml";
        $xml = simplexml_load_file($xmlFile);
        $idqcm = $_POST['idqcm'];
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
            echo'cela na pas fonctionner';
            return false;
        }

        // Si le QCM n'a pas été trouvé
        return false;
    }
    public function affiche_formulaire_qcm($idqcm)
    {
        
        //var_dump($this->modelXml);
        $this->recupqcm($idqcm);
        
        $tmp = $this->modelXml->getQCM()->getListeQuestions();
        foreach ($tmp as $q) {
            $q->afficherquestionformulaire();
        }
    }



    public function affiche_modif()
    //fonction de modification du qcm this
    {
        $idqcm = "qcmcours2";
        //var_dump($this->modelXml);
        $this->recupqcm($idqcm);
        $tmp = $this->modelXml->getQCM();
        //var_dump($tmp);
        echo "<form action='../../config/routeur.php?idqcm=" . $idqcm . "' method='post'>";
        //garder l'id du QCM
        // echo '<input type="hidden" name="idqcm" value="'.$tmp->getIdQCM().'">';
        foreach ($tmp->getListeQuestions() as $question) {
            echo "<div>";
            echo "<label>Question : </label>";
            echo "<input type='text' name='question[]' value='" . $question->getQuestion() . "'>";
            echo "<br>";
            $cmp = 0;
            foreach ($question->getChoix() as $choix => $reponse) {
                $cmp++;
                echo "<label>Réponse " . $cmp . ": </label>";
                echo "<input type='text' name='reponse[]' value='" . $choix . "'>";
            }
            //pour l'indice de la reponse juste (entre 1 et 4)
            echo "<br>";
            echo "<label>Bonne réponse (indiquer l'indice entre 1 et 4): </label>";
            echo "<input type='text' name='question[]' value='" . $question->getReponse() . "'>";

            echo "</div>";
        }
        echo "<input type='submit' value='Valider les modifications' name='validerChangement'>";


        echo "</form>";
    }


    public function calculerScore($idqcm)
    {
        $login="test22"; //mettre Cookie a la place
        // recup possible via le hiden sinon
        $score = 0;
        $this->modelXml->recupqcm($idqcm, "../BD/exemple.xml");
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
            $qcm = $this->modelXml->getQCM();
            //$qcm->calculerScore($_POST['reponse']);

            $score = $qcm->calculerScore($_POST['reponse']);


            // vue qui affiche les résultats
            //include('../test/resultat_qcm.php');
        }
        if ($score > 50) {
            echo 'vous avez réussi le qcm';
            //atributiont du lv valider 
            $this->valideQCM($idqcm,1,$login);
        }
        else echo'dommage vous avez un score de '.$score.'%';

    //renvoier sur une autre page boutons acceuil ou autre
    }

    public function calcul_score_intro() {

        echo "test";
         $compteur= 0;
        $tempo=0;
        $tempomatiere='';
        $this->modelXml->recupqcmintro("../BD/exemple.xml");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
            $qcm = $this->modelXml->getQCM();
            $qcm->calcul_score_intro($_POST['reponse']);
       
        } 
    }

}
