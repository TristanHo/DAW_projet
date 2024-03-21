<?php
require("../model/ModelVoiture.php");

  class ControllerVoiture{
    static function readAll(){
        $liste =ModelVoiture::readAll();
        require("../view/list.php");
    }
    static function add(){
        if(isset($_GET['imma'])&&isset($_GET['model'])&&isset($_GET['coul']))
        {
            $v=new ModelVoiture($_GET['imma'],$_GET['model'],$_GET['coul']);
            $ok=$v->save();
            if($ok){
                self::readAll();
            }else
            {
                header("Location../views/error.php");
            }
        }
        else{
            header("Location../views/error.php");
        }
    }

}

?>