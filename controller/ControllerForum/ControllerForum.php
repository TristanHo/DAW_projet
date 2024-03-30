<?php

include '../../model/ModelForum';

class ControllerForum
{
    private $modelForum;

    public function __construct()
    {
        $this->modelForum = array();
    }

    public function fillFromCSV()
    {
        include '../../model/ModelForum/ModelSub.php';

        $fd = fopen("../../model/ModelForum/disciplines.csv", "r");
        if(!$fd){ echo '<p>Erreur de chargement des disciplines</p><br>'; return; }

        while(($discipline = fgetcsv($fd, null, ';')) !== FALSE)
        {
            array_push($this->modelForum, new ModelSub($discipline[0], array()));
        }

        fclose($fd);
    }

    public function fillHomepage()
    {
        foreach($this->modelForum as $subs)
        {
            echo '<li><a href="../../controller/routeur.php?id='.$subs->getDiscipline().'" id="'.$subs->getDiscipline().'">'.$subs->getDiscipline().'</li>';
        }
    }
}