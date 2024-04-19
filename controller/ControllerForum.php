<?php

error_reporting(E_ALL);

define("MESSAGE_MAX_LENGTH", 500);

class ControllerForum
{

public static function getPDO()
{

    try
    {        
        $dbh =  new PDO('mysql:host=localhost;dbname=DAW_Project', 'root', '');
        return $dbh;
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

}



public static function retrieveTopics($className)
{

    $dbh = ControllerForum::getPDO();

    $_SESSION['class_name'] = $className;
    $query = "SELECT nom, titre, id, auteur FROM Topic WHERE nom='".$_SESSION['class_name']."'";
    $content = "<h1>Liste des topics de ".$_SESSION['class_name']."</h1><br>";

    foreach($dbh->query($query) as $record)
    {
        $content .= '<div class=topicEntry>';
        $content .= '<a href=topic_template.php?topic_id='.$record['id'].'&topic_title='.urlencode($record['titre']).'>'.$record['titre'].'</a> par ';
        $content .= $record['auteur'];

        if($_COOKIE['role'] == "administrateur" || $_COOKIE['role'] == "professeur")
        {
            $content .= "<div><form method=\"post\" action=\"../../config/routeur.php?id_cours=".$record['id']."\">";
            $content .= "<input type=\"submit\" name=\"btnDeleteTopic\" value=\"Supprimer\"/>";
            $content .= "</form></div>";
        }

        $content .= '</div>';
    }


    if($_COOKIE['role'] == "administrateur" || $_COOKIE['role'] == "professeur")
    //if($_SESSION['login']=="admin")
    {
        $content .= "<div class=addTopic><form method=\"post\" action=\"../../config/routeur.php\">";
        $content .= "<textarea name=\"topicInput\" rows=\"1\" cols=\"50\" placeholder=\"Ajouter un topic...\"></textarea><br>";
        $content .= "<input type=\"submit\" value=\"Ajouter\">";
        $content .= "</form></div>";
    }

    $dbh = null;
    echo $content;
}

public static function removeTopic($topic_id)
{

    $dbh = ControllerForum::getPDO();
    $query = "DELETE FROM Messages WHERE id_topic=".$topic_id;
    $dbh->exec($query);
    $query = "DELETE FROM Topic WHERE id=".$topic_id;
    $dbh->exec($query);
    $dbh = null;

    header('Location: ../view/forum/forum_template.php');
    ControllerForum::retrieveTopics($_SESSION['class_name']);
}

public static function addTopic()
{

    $dbh = ControllerForum::getPDO();
    $query = "INSERT INTO Topic (nom, titre, auteur) VALUES('".$_SESSION['class_name']."','".$_POST['topicInput']."','".$_SESSION['login']."')";
    $dbh->exec($query);

    header('Location: ../view/forum/forum_template.php');
    ControllerForum::retrieveTopics($_SESSION['class_name']);

    $dbh = null;
}


/*
Créer la page des messages du topic et charge ces derniers.
*/
public static function retrieveMessages()
{

    $dbh = ControllerForum::getPDO();
    $content = "<h1>Messages de ".urldecode($_GET['topic_title'])."</h1><br>";

    $_SESSION['topic_id'] = $_GET['topic_id'];
    $_SESSION['topic_title'] = $_GET['topic_title'];

    /*
    Parcours de la table des messages au cours duquel la mise en page
    et le chargement des données est effectué
    */
    $query = 'SELECT contenu, date, author, id_message FROM Messages WHERE id_topic='.$_GET['topic_id']."";

    foreach($dbh->query($query) as $record)
    {
        $content .= "<div class=\"message\">";


        //Chargement et mise en page des messages
        $content .= "<div>".$record['contenu']."</div>";
        $content .= "<div class=\"author\">".$record['author']."</div>";
        $content .= "<div class=\"date\">".$record['date']."</div>";



        //Place un bouton "suppression" sous les messages si l'utilisateur courant détient suffisamment de privilèges
        if($_COOKIE['role'] == "administrateur" || $_COOKIE['role'] == "professeur")
        {
            $content .= "<div><form method=\"post\" action=\"../../config/routeur.php?id_message=".$record['id_message']."\">";
            $content .= "<input type=\"submit\" name=\"btnDeleteMessage\" value=\"Supprimer\"/>";
            $content .= "</form></div>";
        }

        $content .= "</div>";
    }


    //Zone de saisie d'un nouveau message
    $content .= "<div><form method=\"post\" action=\"../../config/routeur.php?topic_id=".$_GET['topic_id']."&topic_title=".$_GET['topic_title']."\" class=\"inputArea\">";
    $content .= "<textarea name=\"messageInput\" rows=\"5\" cols=\"40\" size=\"50\"></textarea><br>";
    $content .= "<input type=\"submit\" value=\"Envoyer\" onclick=\"refreshMessages()\"></form></div>";

    $dbh = null;
    echo $content;
}

/*
Insère les données relatives à un nouveau message dans la table Messages
*/
public static function addMessage($topic_id, $topic_title)
{

    $dbh = ControllerForum::getPDO();

    if($_POST['messageInput'] != "" && strlen($_POST['messageInput']) < MESSAGE_MAX_LENGTH)
    {
        $query = 'INSERT INTO Messages (id_topic, contenu, author) VALUES ('.$_GET['topic_id'].', \''.$_POST['messageInput'].'\',\''.$_SESSION['login'].'\')';
        $dbh->query($query);
    }

    header('Location: ../view/forum/topic_template.php?topic_id='.$_GET['topic_id'].'&topic_title='.$_GET['topic_title']);
    ControllerForum::retrieveMessages();

}

public static function removeMessage($id_message)
{
    $dbh = ControllerForum::getPDO();

    $query = "DELETE FROM Messages WHERE id_message=".$id_message;
    $dbh->query($query);

    header('Location: ../view/forum/topic_template.php?topic_id='.$_SESSION['topic_id'].'&topic_title='.$_SESSION['topic_title']);
    ControllerForum::retrieveMessages();

}

}
