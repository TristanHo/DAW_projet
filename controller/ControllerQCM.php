<?php
require("../model/ModelQCM.php");

  class ControllerQCM{
    static function readAll(){
        $liste = ModelQCM::readAll();
        require("../view/list.php");
    }
    static function add(){
        if(isset($_GET['idquestion'])&&isset($_GET['question'])&&isset($_GET['choix1'])&&isset($_GET['choix2'])&&isset($_GET['choix3'])&&isset($_GET['choix4'])) {
            $question = $_GET['question'];
            $choix = array($_GET['choix1'] => 'FALSE', $_GET['choix2'] => 'FALSE', $_GET['choix3'] => 'FALSE', $_GET['choix4'] => 'FALSE');
            if (!empty($_GET['check']))
            {
                foreach($_GET['check'] as $value) {
                    $choix[$value] = 'TRUE';
                }

                $q = new ModelQuestion($_GET['idquestion'],$question,$choix);
                $qcm = new ModelQCM(1);
                $qcm->ajoutQuestion($q);
                
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

}

?>