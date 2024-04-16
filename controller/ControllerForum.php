<?php

error_reporting(E_ALL);

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
    
    $query = "SELECT nom, titre, id, auteur FROM Topic WHERE nom='".$className."'";
    $content = "<h1>Liste des topics de ".$className."</h1><br>";

    foreach($dbh->query($query) as $record)
    {
        $content .= '<div><a href=topic_template.php?topic_id='.$record['id'].'&topic_title='.$record['titre'].'>'.$record['titre'].'</a> par ';
        $content .= $record['auteur'].'</div>';
        $_SESSION['topic_id'] = $record['id'];
        $_SESSION['topic_title'] = $record['titre'];
    }

    $dbh = null;
    echo $content;
}


public static function retrieveMessages()
{
    $dbh = ControllerForum::getPDO();
    $content = "<h1>Messages de ".$_SESSION['topic_title']."</h1><br>";
    
    $query = 'SELECT contenu, date, author, id_message FROM Messages WHERE id_topic='.$_GET['topic_id']."";

    foreach($dbh->query($query) as $record)
    {
        $content .= "<div class=\"message\">";

        $content .= "<div>".$record['contenu']."</div>";
        $content .= "<div class=\"author\">".$record['author']."</div>";
        $content .= "<div class=\"date\">".$record['date']."</div>";

        if($_SESSION['login']=="admin")
        {
            $content .= "<div><form method=\"post\" action=\"../../controller/routeur.php?id_message=".$record['id_message']."\">";
            $content .= "<input type=\"submit\" name=\"btnDeleteMessage\" value=\"Supprimer\"/>";
            $content .= "</form></div>";
        }

        $content .= "</div>";
    }

    $dbh = null;
    echo $content;
}

public static function addMessage()
{

    $dbh = ControllerForum::getPDO();

    $query = 'INSERT INTO Messages (id_topic, contenu, author) VALUES ('.$_SESSION['topic_id'].', \''.$_GET['messageInput'].'\',\''.$_SESSION['login'].'\')';
    $dbh->query($query);

    header('Location: ../view/forum/topic_template.php?topic_id='.$_SESSION['topic_id'].'&topic_title='.$_SESSION['topic_title']);
    ControllerForum::retrieveMessages();

}

public static function removeMessage($id_message)
{

    if($_SESSION['login'] != 'admin'){ return; } 

    
    $dbh = ControllerForum::getPDO();

    $query = "DELETE FROM Messages WHERE id_message=".$id_message;
    $dbh->query($query);

    header('Location: ../view/forum/topic_template.php?topic_id='.$_SESSION['topic_id'].'&topic_title='.$_SESSION['topic_title']);
    ControllerForum::retrieveMessages();

}

}