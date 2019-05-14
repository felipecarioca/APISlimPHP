<?php
    include_once 'Produto.php';
	include_once 'PDOFactory.php';

    class ProdutoDAO
    {
        public function inserir(Produto $produto)
        {
            $qInserir = "INSERT INTO produto(descricao, preco, id_categoria) VALUES (:descricao,:preco,:id_categoria)";            
            
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qInserir);
            $comando->bindParam(":descricao",$produto->descricao);
            $comando->bindParam(":preco",$produto->preco);
            $comando->bindParam(":id_categoria",$produto->id_categoria);
            $comando->execute();
            $produto->id = $pdo->lastInsertId();
            return $produto;
        }

        public function deletar($id)
        {
            $qDeletar = "DELETE from produto WHERE id=:id";            
            $produto = $this->buscarPorId($id);
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qDeletar);
            $comando->bindParam(":id",$id);
            $comando->execute();
            return $produto;
        }

        public function atualizar(Produto $produto)
        {
            $qAtualizar = "UPDATE produto SET descricao=:descricao, preco=:preco, id_categoria=:id_categoria WHERE id=:id";            
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qAtualizar);
            $comando->bindParam(":descricao",$produto->descricao);
            $comando->bindParam(":preco",$produto->preco);
            $comando->bindParam(":id_categoria",$produto->id_categoria);
            $comando->bindParam(":id",$produto->id);
            $comando->execute();
            return $produto;        
        }

        public function listar()
        {
		    $query = 'SELECT * FROM produto';
    		$pdo = PDOFactory::getConexao();
	    	$comando = $pdo->prepare($query);
    		$comando->execute();
            $produtos=array();	
		    while($row = $comando->fetch(PDO::FETCH_OBJ)){
			    $produtos[] = new Produto($row->id,$row->descricao,$row->preco,$row->id_categoria);
            }
            return $produtos;
        }

        public function buscarPorId($id)
        {
 		    $query = 'SELECT * FROM produto WHERE id=:id';		
            $pdo = PDOFactory::getConexao(); 
		    $comando = $pdo->prepare($query);
		    $comando->bindParam ('id', $id);
		    $comando->execute();
		    $result = $comando->fetch(PDO::FETCH_OBJ);
		    return new Produto($result->id,$result->descricao,$result->preco,$result->id_categoria);           
        }
    }
?>