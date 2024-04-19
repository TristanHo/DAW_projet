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

        if ($idqcm == 'qcmintro') {
            $retour = $this->modelXml->recupqcmintro("../../BD/exemple.xml");
        } else {
            $retour = $this->modelXml->recupqcm($idqcm, "../../BD/exemple.xml");
        }
        //return $this->modelXml;
        return $retour;
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

    public static function recuplvetu($nomcours, $loginetu)
    {// Retourne le niveau maximum validé par l'étudiant dans la matière
        $dbh = ControllerQCM::getPDO();
        // Utilisation de requête préparée
        $query = 'SELECT MAX(lv) AS max_lv FROM cours_valider WHERE nomcours = :nomcours AND login = :loginetu';
        $requ = $dbh->prepare($query);
        $requ->bindParam(':nomcours', $nomcours);
        $requ->bindParam(':loginetu', $loginetu);
        // Exécution de la requête
        $requ->execute();

        // Récupération du résultat
        $result = $requ->fetch(PDO::FETCH_ASSOC);

        
        return $result['max_lv'];
    }
    //
    //fonction de modification dans le fichier xml ou sauvgarde si il n'existe pas encore
    public static function modif_sauv_qcm()
    {
        $xmlFile = "../BD/exemple.xml";
        $xml = simplexml_load_file($xmlFile);
        //var_dump($xml);
        $idqcm = $_GET['idqcm'];
        // Rechercher le QCM à modifier en fonction de son ID
        foreach ($xml->qcm as $qcm) {
            if ($qcm->idqcm == $idqcm) {
                // Mettre à jour les questions et réponses du QCM en fonction des données soumises dans le formulaire
                $idquestion = 0;
                foreach ($qcm->questions->question as $question) {
                    // Mettre à jour la question et les réponses
                    $question->questionposer = $_POST['question'][$idquestion];
                    $question->choix[0] = $_POST['reponse'][$idquestion * 4];
                    $question->choix[1] = $_POST['reponse'][$idquestion * 4 + 1];
                    $question->choix[2] = $_POST['reponse'][$idquestion * 4 + 2];
                    $question->choix[3] = $_POST['reponse'][$idquestion * 4 + 3];
                    $question->reponse = $_POST['bonnerep'][$idquestion];
                    $idquestion++;
                }
                // Enregistrer les modifications dans le fichier XML
                $xml->asXML($xmlFile);
                echo 'Modification du QCM effectuer ';
        echo '<br>';
        echo '<a href="/DAW-projet/view/users/accueil.php"><button>Retour à l\'accueil</button></a>';
                return true; // Modification réussie
            }
        }


        // Si le QCM n'a pas été trouvé, créer un nouveau QCM
        $qcmElement = $xml->addChild('qcm');
        $qcmElement->addChild('idqcm', $idqcm);

        $questionsElement = $qcmElement->addChild('questions');
        // Ajouter des questions à partir des données POST
        // Assurez-vous que $_POST['question'], $_POST['reponse'] et $_POST['bonnerep'] contiennent des données valides
        // et ont la même structure que celle attendue.
        foreach ($_POST['question'] as $index => $question) {
            $questionElement = $questionsElement->addChild('question');
            $questionElement->addChild('idquestion', 'q' . ($index + 1));
            $questionElement->addChild('questionposer', $question);
            for ($i = 0; $i < 4; $i++) {
                $questionElement->addChild('choix', $_POST['reponse'][$index * 4 + $i]);
            }
            $questionElement->addChild('reponse', $_POST['bonnerep'][$index]);
        }

        // Enregistrer les modifications dans le fichier XML
        $xml->asXML($xmlFile);
        echo 'création du QCM validé';
        echo '<br>';
        echo '<a href="/DAW-projet/view/users/accueil.php"><button>Retour à l\'accueil</button></a>';

        return true;
    }
    public function affiche_formulaire_qcm($idqcm)
    {

        //var_dump($this->modelXml);
        echo '<h1>Vous effectuer le QCM ' . $idqcm . '</h1>';
        $this->recupqcm($idqcm);

        $tmp = $this->modelXml->getQCM()->getListeQuestions();
        foreach ($tmp as $q) {
            $q->afficherquestionformulaire();
        }
    }



    public function affiche_modif($idqcm)
    //fonction de modification du qcm this
    {
        //$idqcm = "qcmcours2";
        //var_dump($this->modelXml);
        $tmp = $this->recupqcm($idqcm);
        //var_dump($tmp);
        if ($tmp == null) {
            //formulaire vide pour création 
            echo "création d'un formulaire<br>";
            echo "<form action='../../config/routeur.php?idqcm=" . $idqcm . "' method='post'>";
            //garder l'id du QCM
            // echo '<input type="hidden" name="idqcm" value="'.$tmp->getIdQCM().'">';
            for ($i = 0; $i < 10; $i++) {
                echo "<div>";
                echo "<label>Question : </label>";
                echo "<input type='text' name='question[]' value='question" . $i . "'>";
                echo "<br>";
                $cmp = 0;
                for ($x = 0; $x < 4; $x++) {
                    $cmp++;
                    echo "<label>Réponse " . $cmp . ": </label>";
                    echo "<input type='text' name='reponse[]' value='choix" . $x . "'>";
                }
                //pour l'indice de la reponse juste (entre 1 et 4)
                echo "<br>";
                echo "<label>Bonne réponse (indiquer l'indice entre 1 et 4): </label>";
                echo "<input type='text' name='bonnerep[]' value='Reponse" . $i . "'>";

                echo "</div>";
            }
            echo "<input type='submit' value='Valider les modifications' name='validerChangement'>";


            echo "</form>";
        } else {
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
                echo "<input type='text' name='bonnerep[]' value='" . $question->getReponse() . "'>";

                echo "</div>";
            }
            echo "<input type='submit' value='Valider les modifications' name='validerChangement'>";


            echo "</form>";
        }
    }


    public function calculerScore($idqcm)
    {
        $login = "test22"; //mettre Cookie a la place
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
            $this->valideQCM($idqcm, 1, $login);
            // Bouton pour retourner à la page d'accueil

        } else echo 'dommage vous avez un score de ' . $score . '%';
        echo '<br>';
        echo '<a href="/DAW-projet/view/users/accueil.php"><button>Retour à l\'accueil</button></a>';
        //renvoier sur une autre page boutons acceuil ou autre
    }

    public function calcul_score_intro()
    {

        $login = "test22"; //remplacer par cookie

        $compteur = 0;
        $tempo = 0;
        $tempomatiere = '';
        $this->modelXml->recupqcmintro("../BD/exemple.xml");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
            $qcm = $this->modelXml->getQCM();
            $qcm->calcul_score_intro($_POST['reponse'], $login);
        }
        echo '<br>';
        echo '<a href="/DAW-projet/view/users/accueil.php"><button>Retour à l\'accueil</button></a>';
    }
}
