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
    }

    $dbh = null;

    echo $content;
}


public static function retrieveMessages()
{
    $dbh = ControllerForum::getPDO();
    $content = "<h1>Messages de ".$_GET['topic_title']."</h1><br>";
    

    $query = 'SELECT contenu, date, author FROM Messages WHERE id_topic='.$_GET['topic_id']."";

    foreach($dbh->query($query) as $record)
    {
        $content .= "<div class=\"message\"><p>".$record['contenu']."</p>";
        $content .= "<div class=\"author\">".$record['author']."</div>";
        $content .= "<div class=\"date\">".$record['date']."</div></div>";
    }

    $dbh = null;

    echo $content;
}

}
