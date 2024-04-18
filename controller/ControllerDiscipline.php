<?php



class ControllerCours
{

public static function loadPage()
{
    $content = "<h1>Cours de ".$_GET['id']."</h1>";
    $content .= "<div><a href=\"../forum/forum_template.php?className=".$_GET['id']."\">Forum du cours</a> </div>";

    echo $content;
}

}