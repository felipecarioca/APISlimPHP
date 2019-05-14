<?php
    class Produto {
        public $id;
        public $descricao;
        public $preco;
        public $id_categoria;

        function __construct($id, $descricao, $preco, $id_categoria){
            $this->id = $id;
            $this->descricao = $descricao;
            $this->preco = $preco;
            $this->id_categoria = $id_categoria;
        }
    }
?>