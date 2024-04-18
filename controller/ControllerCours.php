<?php

define("NOM_COURS", "Physique");

class ControllerCours
{

public static function loadPage()
{
    $content = "<h1>Cours de ".NOM_COURS."</h1>";
    $content .= "<div><a href=\"../forum/forum_template.php?className=".NOM_COURS."\">Forum du cours</a> </div>";

    echo $content;
}

}