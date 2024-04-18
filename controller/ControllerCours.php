<?php

    require_once(__DIR__.'/../model/ModelCours.php');

    class ControllerCours {
        //Fonction du controller pour récuperer la liste de tous les cours
        public static function listeCours() {
            $model = new Model();
            $pdo = $model->getPdo();

            $select = $pdo->query("SELECT * FROM cours");
            $listecours = array();

            while($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $cours = new ModelCours($row['login_responsable'], $row['nom'], $row['id_cours']);
                $listecours[] = $cours;
            }

            return $listecours;
        }

        //Fonction du controller pour récupérer un cours à partir de son id
        public static function getCours($id) {
            $model = new Model();
            $pdo = $model->getPdo();

            $select = $pdo->query('SELECT * FROM cours WHERE id_cours='.$id);
            while($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $cours = new ModelCours($row['login_responsable'], $row['nom'], $row['id_cours']);
                return $cours;
            }
        }

        //Fonction pour récupérer la liste des cours créés par un professeur
        public static function getCoursResponsable($responsable) {
            $model = new Model();
            $pdo = $model->getPdo();

            $select = $pdo->query('SELECT * FROM cours WHERE login_responsable="'.$responsable.'"');
            $listecours = array();

            while($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $cours = new ModelCours($row['login_responsable'], $row['nom'], $row['id_cours']);
                $listecours[] = $cours;
            }

            return $listecours;
        }

        //Fonction du controller pour insérer un cours dans la table des cours
        public static function insertCours($responsable, $nom) {    
            $model = new Model();
            $pdo = $model->getPdo();
            $recupID = $pdo->query("SELECT MAX(id_cours) FROM cours");
            $id = $recupID->fetchColumn() + 1;
            $insert = $pdo->query("INSERT INTO Cours VALUES('".$id."', '".$nom."', '".$responsable."')");
            //Redirection vers la page d'accueil
            header('Location: http://localhost/DAW-projet/view/users/accueil.php');
            exit();
        }
    
        //Fonction du controller pour supprimer un cours de la base de données
        public static function deleteCours($id) {
            $model = new Model();
            $pdo = $model->getPdo();
    
            $delete = $pdo->query('DELETE FROM Cours WHERE id_cours='.$id);
            //Redirection vers la page d'accueil
            header('Location: http://localhost/DAW-projet/view/users/accueil.php');
            exit();
        }
    
        //Fonction du controller pour modifier un cours de la table
        public static function modifCours($responsable, $nom, $id) {
            $model = new Model();
            $pdo = $model->getPdo();
    
            $update = $pdo->query('UPDATE Cours SET login_responsable="'.$responsable.'", nom="'.$nom.'" WHERE id_cours='.$id);
            //Redirection vers la page du cours
            header('Location: http://localhost/DAW-projet/view/cours/pageCours.php?id='.$id);
            exit();
        }
    }

?>
