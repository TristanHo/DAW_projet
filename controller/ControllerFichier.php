<?php   

require_once(__DIR__.'/../model/ModelFichier.php');
class ControllerFichier{

    //Récupérer l'affichage d'un cours
    public static function getFichiersCours($nom_cours){
        $fichiers_cours = ModelFichier::getFichiersCours($nom_cours,null);
        $res = [];
        foreach($fichiers_cours as $file){
            if($file->getCours() == $nom_cours){
                $res[] = $file;
            }
        }
        return $res;
    }


    //Récupérer la photo de profil d'un utilisateur
    public static function getUserPP($login){
        $fichiers = ModelFichier::getFichiersPP();
        foreach($fichiers as $file){
            if($file->getType() == 'pp' && $file->getLoginUser() == $login){
                $path = $file->getPath();
            }
        }
    }


    //Sauvegarder la photo de profil d'un utilisateur
    public static function savePP(){
        if(isset($_POST['login']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
            $file = $_FILES['photo']['name'];
            $login = $_POST['login'];
            $photo = new ModelFichier($file,'pp',null,null,$login);
            
            //On essaye tout d'abord de sauvegarder les informations dans la base de données
            $ok = $photo->saveFile('');

            //Si la sauvegarde dans la BD a réussi, on télécharge l'image sur le serveur
            if($ok[0]){
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $file = "$ok[1].$extension";
                $dir_dest = "../BD/fichiers/images$file";
                $dir_temp = $_FILES['photo']['tmp_name'];
                move_uploaded_file($dir_temp,$dir_dest);

                //Retour vers la page de connexion
                header('Location:/DAW-projet/index.php?infos=crea');
                exit();
            }
            else{

                //Retour vers la page de connexion en indiquant erreur
                header('Location:/DAW-projet/index.php?infos=ncreaphoto');
                exit();
            }
        }
    }


    //Permet de sauvegarder un fichier pour un cours
    public static function saveFichierCours(){
        
        if(isset($_COOKIE['login']) && $_FILES['fichier_cours']['error'] == UPLOAD_ERR_OK){
            $file = $_FILES['fichier_cours']['name'];
            $login = $_COOKIE['login'];
            $cours = $_POST['cours'];
            $cours = str_replace('/','',$cours); //Obligé d'enlever le / qui set met automatiquement
            $nv_cours = $_POST['nv_fichier'];
            
            //On sauvegarde les informations du fichier dans la base de données
            $fichier = new ModelFichier($file,'cours',$cours,$nv_cours,$login);
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $ok = $fichier->saveFile($file);

            //Si la sauvegarde dans la BD a réussi, on sauvegarde le fichier sur le serveur
            if($ok[0]){
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $file = $ok[1];
                $dir_dest = "../BD/fichiers/cours$file";
                $dir_temp = $_FILES['fichier_cours']['tmp_name'];
                move_uploaded_file($dir_temp,$dir_dest);
                $id_cours = $_POST['id_cours'];
                $id_cours = str_replace('/','',$id_cours);

                //Retour vers la page de cours
                header("Location:/DAW-projet/view/cours/pageCours.php?id=$id_cours");
                exit();
            }
            else{

                //Retour vers la page de cours
                header("Location:/DAW-projet/pageCours.php?id=$id_cours");
                exit();
            }
        }
    }


    //Permet d'afficher la photo de profil d'un utilisateur
    public static function afficherPP(){
        if(isset($_COOKIE['login'])){
            $photo = new ModelFichier(null,'pp',null,null,$_COOKIE['login']);
            $photo->getPP();
            if($photo->getPath() != null){
                setcookie('pp',$photo->getPath(),0,'/');
            }
        }
        if($_SESSION['qcm'] == 0 && $_COOKIE['role'] == 'etudiant'){
            //Si l'étudiant n'a pas fait le QCM d'introduction (première connexion au compte)
            header('Location:/DAW-projet/view/qcm/formulaireintroQcm.php');
            exit();
        }
        else{
            //Redirection vers la page d'accueil
            header('Location:/DAW-projet/view/users/accueil.php');
            exit();
        }
    }
}