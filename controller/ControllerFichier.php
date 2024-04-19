<?php   
require_once('../model/ModelFichier.php');

class ControllerFichier{

    public static function getFichiersCours($nom_cours,$login){
        //A définir pour l'affichage des fichiers de chaque cours
        $fichiers_cours = ModelFichier::getFichiersCours();
        $res = [];
        foreach($fichiers_cours as $file){
            if($file->getCours() == $nom_cours){
                $res[] = $file;
            }
        }
        return $res;
    }

    public static function getUserPP($login){
        $fichiers = ModelFichier::getFichiersPP();
        foreach($fichiers as $file){
            if($file->getType() == 'pp' && $file->getLoginUser() == $login){
                $path = $file->getPath();
            }
        }
    }

    public static function savePP(){
        if(isset($_POST['login']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
            $file = $_FILES['photo']['name'];
            $login = $_POST['login'];
            $photo = new ModelFichier($file,'pp',null,null,$login);
            $ok = $photo->saveFile();
            if($ok[0]){
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $file = "$ok[1].$extension";
                $dir_dest = "../BD/fichiers/images$file";
                $dir_temp = $_FILES['photo']['tmp_name'];
                move_uploaded_file($dir_temp,$dir_dest);
                header('Location:/DAW-projet/index.php?infos=crea');
                exit();
            }
            else{
                header('Location:/DAW-projet/index.php?infos=ncreaphoto');
                exit();
            }
        }
    }

    public static function saveFichierCours(){
        if(isset($_COOKIE['login']) && $_FILES['fichier_cours']['error'] == UPLOAD_ERR_OK){
            $file = $_FILES['fichier_cours']['name'];
            $login = $_COOKIE['login'];
            $cours = $_POST['cours'];
            $cours = str_replace('/','',$cours); //Obligé d'enlever le / qui set met automatiquement
            $nv_cours = $_POST['nv_fichier'];
            $fichier = new ModelFichier($file,'cours',$cours,$nv_cours,$login);
            $ok = $fichier->saveFile();
            //$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if($ok[0]){
                //$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $file = $ok[1];
                $dir_dest = "../BD/fichiers/cours$file";
                $dir_temp = $_FILES['fichier_cours']['tmp_name'];
                move_uploaded_file($dir_temp,$dir_dest);
                $id_cours = $_POST['id_cours'];
                $id_cours = str_replace('/','',$id_cours);
                header("Location:/DAW-projet/view/cours/pageCours.php?id=$id_cours");
                exit();
            }
            else{
                header("Location:/DAW-projet/pageCours.php?id=$id_cours");
                exit();
            }
        }
    }

    public static function afficherPP(){
        if(isset($_COOKIE['login'])){
            $photo = new ModelFichier(null,'pp',null,null,$_COOKIE['login']);
            $photo->getPP();
            if($photo->getPath() != null){
                setcookie('pp',$photo->getPath(),0,'/');
            }
        }
        //Redirection vers la page d'accueil
        header('Location:/DAW-projet/view/users/accueil.php');
        exit();
    }
}