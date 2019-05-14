<?php
    class Categoria {
        public $id;
        public $descricao;

        function __construct($id, $descricao){
            $this->id = $id;
            $this->descricao = $descricao;
        }
    }
?>