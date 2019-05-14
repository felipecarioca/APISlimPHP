<?php
    include_once 'Loja.php';
	include_once 'PDOFactory.php';
    
    class LojaDAO
    {
        public function inserir(Loja $loja)
        {
            $qInserir = "INSERT INTO loja(id_produto, proprietario, vendedor) VALUES (:id_produto, :proprietario, :vendedor)";
            
            $pdo = PDOFactory::getConexao();
            
            $comando = $pdo->prepare($qInserir);
            $comando->bindParam(":id_produto",$loja->id_produto);
            $comando->bindParam(":proprietario",$loja->proprietario);
            $comando->bindParam(":vendedor",$loja->vendedor);
            $comando->execute();

            $loja->id = $pdo->lastInsertId();
            
            return $loja;
        }

        public function deletar($id)
        {
            $qDeletar = "DELETE from loja WHERE id=:id";
                        
            $loja = $this->buscarPorId($id);
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qDeletar);
            $comando->bindParam(":id",$id);
            $comando->execute();

            return $loja;
        }

        public function atualizar(Loja $loja)
        {
            $qAtualizar = "UPDATE loja SET id_produto=:id_produto, proprietario = :proprietario, vendedor = :vendedor WHERE id=:id";     

            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qAtualizar);
            $comando->bindParam(":id_produto",$loja->id_produto);
            $comando->bindParam(":proprietario",$loja->proprietario);
            $comando->bindParam(":vendedor",$loja->vendedor);
            $comando->bindParam(":id",$loja->id);
            $comando->execute();

            return $loja;        
        }

        public function listar()
        {
		    $query = 'SELECT * FROM loja';

    		$pdo = PDOFactory::getConexao();
	    	$comando = $pdo->prepare($query);
    		$comando->execute();
            $lojas=array();	
		    
            while($row = $comando->fetch(PDO::FETCH_OBJ)){
			    $lojas[] = new Loja($row->id,$row->id_produto,$row->proprietario, $row->vendedor);
            }
            
            return $lojas;
        }

        public function buscarPorId($id)
        {
 		    $query = 'SELECT * FROM loja WHERE id=:id';		
            $pdo = PDOFactory::getConexao(); 
		    $comando = $pdo->prepare($query);
		    $comando->bindParam ('id', $id);
		    $comando->execute();
		    $result = $comando->fetch(PDO::FETCH_OBJ);
		    
            return new Loja($result->id,$result->id_produto,$result->proprietario, $result->vendedor);           
        }
    }
?>