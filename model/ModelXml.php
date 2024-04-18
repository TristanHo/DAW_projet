<?php
//ajouter la bonne réponse dans le fichier xml
//include de modelQCM
require_once("ModelQCM.php");
class ModelXml
{
    //attributs pour stocker un qcm
    private $qcm;


    //sauvgarde dans le fichier xml de qcm pour cree des question
    public function __construct($qcm = null)
    {
        if ($qcm != null) {
            $this->qcm = $qcm;
        }
    }
    function createXMLFileIfNotExists($filePath, $xmlContent)
    {
        // Vérifier si le fichier existe déjà
        if (!file_exists($filePath)) {
            // Créer le fichier s'il n'existe pas
            $file = fopen($filePath, 'w');
            if ($file === false) {
                // Gérer les erreurs d'ouverture de fichier
                echo "Erreur lors de la création du fichier XML.";
                return false;
            }

            // Écrire le contenu XML dans le fichier
            fwrite($file, $xmlContent);

            // Fermer le fichier après écriture
            fclose($file);
            return true;
        } else {
            // Si le fichier existe déjà, ne rien faire
            return true;
        }
    }

    //fonction pour récuperer le qcmintro
    //fonction particuliere car elle a un attribut en plus (matierelv)

    public function recupqcmintro($xmlfile){
        if (file_exists($xmlfile)) {
            //echo"test ici";
            $this->qcm = new ModelQCM();
            $this->qcm->setIdQCM("qcmintro");
            $fichier = simplexml_load_file($xmlfile);
            $qcmFound = false; // Variable pour indiquer si le QCM a été trouvé
            // Rechercher le QCM avec l'ID spécifié
            foreach ($fichier->qcm as $qcm) {
                $qcm_id = trim((string)$qcm->idqcm); // Nettoyer l'IDQCM
                //echo "verif corepondanceS" . $qcm_id . "<br>";
                if ($qcm_id == "qcmintro") {
                    $qcmFound = true; // Marquer que le QCM a été trouvé
                    
                    $this->qcm = new ModelQCM();
                    $this->qcm->setIdQCM($qcm_id);
                    $idc = 0;
                    foreach ($qcm->questions->question as $quest) {
                        
                        // Récupérer la question
                        $question = new ModelQuestion($idc);
                        $idc++;

                        $question->setQuestion((string)$quest->questionposer);
                        $question->setMatiere((string)$quest->matiere);
                        $question->setLv((string)$quest->lv);
                        // Récupérer la réponse correcte
                        $reponseCorrecte = (string)$quest->reponse;
                        //echo ("<br>");
                        //echo ($reponseCorrecte);

                        // Récupérer les choix possibles
                        $tmp = 0;
                        foreach ($quest->choix as $rep) {
                            $tmp++;
                            if ($reponseCorrecte != $tmp) {
                                //echo "<br> le choix et: ";
                                $question->ajoutChoix((string)$rep, false);
                            } else {
                                $question->ajoutChoix((string)$rep, true);
                               // echo "<br> la reponse et: " . $tmp;
                            }
                        }

                        // Ajouter la question au QCM
                        $this->qcm->ajoutQuestion($question);
                    }

                    // Retourner le QCM trouvé et terminer la fonction
                    //echo"retour du qcm";
                    return $this->qcm;

                }
            }

            // Vérifier si le QCM a été trouvé
            if (!$qcmFound) {
                echo "Le fichier XML n'existe pas. creation";
                //$txt = "test";
                //$this->createXMLFileIfNotExists($xmlFile, $txt);
                return null; // Ou une autre action appropriée
            }
        }
    }

        


    public function recupqcm($id_qcm, $xmlFile)
    //cette fonction ne fonctione pas pour le qcmintro
    {
       // echo ("je fais la récupération du qcm: " . $id_qcm . " depuis le fichier: " . $xmlFile . "<br>");
        $this->qcm = new ModelQCM();
        $this->qcm->setIdQCM($id_qcm);

        // Charger le fichier XML s'il existe
        if ($xmlFile == null) {
            $xmlFile = "../../BD/exemple.xml";
        }

        if (file_exists($xmlFile)) {
            $fichier = simplexml_load_file($xmlFile);
            //echo ("je suis la <br>");
            $qcmFound = false; // Variable pour indiquer si le QCM a été trouvé
            // Rechercher le QCM avec l'ID spécifié
            foreach ($fichier->qcm as $qcm) {
                $qcm_id = trim((string)$qcm->idqcm); // Nettoyer l'IDQCM
                //echo "verif corepondanceS" . $qcm_id . "<br>";
                if ($qcm_id == $id_qcm) {
                    $qcmFound = true; // Marquer que le QCM a été trouvé
                    
                    $this->qcm = new ModelQCM();
                    $this->qcm->setIdQCM($qcm_id);
                    $idc = 0;
                    foreach ($qcm->questions->question as $quest) {
                        
                        // Récupérer la question
                        $question = new ModelQuestion($idc);
                        $idc++;

                        $question->setQuestion((string)$quest->questionposer);
                        // Récupérer la réponse correcte
                        $reponseCorrecte = (string)$quest->reponse;
                        //echo ("<br>");
                        //echo ($reponseCorrecte);

                        // Récupérer les choix possibles
                        $tmp = 0;
                        foreach ($quest->choix as $rep) {
                            $tmp++;
                            if ($reponseCorrecte != $tmp) {
                                //echo "<br> le choix et: ";
                                $question->ajoutChoix((string)$rep, false);
                            } else {
                                $question->ajoutChoix((string)$rep, true);
                               // echo "<br> la reponse et: " . $tmp;
                            }
                        }

                        // Ajouter la question au QCM
                        $this->qcm->ajoutQuestion($question);
                    }

                    // Retourner le QCM trouvé et terminer la fonction
                    return $this->qcm;
                }
            }

            // Vérifier si le QCM a été trouvé
            if (!$qcmFound) {
                echo "Le fichier XML n'existe pas. creation";
                //$txt = "test";
                //$this->createXMLFileIfNotExists($xmlFile, $txt);
                return null; // Ou une autre action appropriée
            }
        }
    }


    public function saveQCM($questionPoser, $reponse, $choix)
    {
        // Charger le fichier XML
        $xml = simplexml_load_file("../../BD/test.xml");

        // Créer un nouvel élément <question>
        $question = $xml->addChild('question');

        // Ajouter les éléments <idquestion>, <questionposer> et <reponse> à <question>
        $question->addChild('idquestion', 'q' . (count($xml->question) + 1));
        $question->addChild('questionposer', $questionPoser);
        $question->addChild('reponse', $reponse);

        // Ajouter les éléments <choix> à <question>
        foreach ($choix as $choixText) {
            $question->addChild('choix', $choixText);
        }

        // Sauvegarder les modifications dans le fichier XML
        $xml->asXML("../../BD/test.xml");
    }
    // Getter pour la propriété $qcm
    public function getQCM()
    {
        return $this->qcm;
    }
    /* public function saveXML(){
        //fonction pour l'ecriture du fichier xml
        $xml = new SimpleXMLElement('<qcm></qcm>');
        //
        foreach ($this->qcm as $) {
            foreach ($groupe->GetListeEtudiant() as $etudiant) {
                $etudiantXml = $xml->addChild('etudiant');
                $etudiantXml->addChild('idetudiant', $etudiant->id_etudiant);
                $etudiantXml->addChild('nom', $etudiant->nom);
                $etudiantXml->addChild('prenom', $etudiant->prenom);
                $etudiantXml->addChild('idgroupe', $groupe->idgroupe);
                $etudiantXml->addChild('role', $etudiant->role);
            }
        }
    
        $xml->asXML($nomfich);
    } */
}
