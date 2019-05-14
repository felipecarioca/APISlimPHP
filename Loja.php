<?php
    class Loja {
        public $id;
        public $id_produto;
        public $proprietario;
        public $vendedor;

        function __construct($id, $id_produto, $proprietario, $vendedor) {
            $this->id = $id;
            $this->id_produto = $id_produto;
            $this->proprietario = $proprietario;
            $this->vendedor = $vendedor;
        }
    }
?>