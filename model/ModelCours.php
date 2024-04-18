<?php

    require_once('Model.php');
    
    class ModelCours {
        private $responsable;
        private $nom;
        private $id;

        function __construct($responsable = null, $nom = null, $id = null) {
            if($responsable != null) {$this->responsable = $responsable;}
            if($nom !=  null) {$this->nom = $nom;}
            if($id != null) {$this->id = $id;}
        }

        public function getResponsable() {return $this->responsable;}
        public function setResponsable($responsable) {$this->responsable = $responsable;}
        public function getNom() {return $this->nom;}
        public function setNom($nom) {$this->nom = $nom;}
        public function getId() {return $this->id;}
        public function setId($id) {$this->id = $id;}
    }

?>