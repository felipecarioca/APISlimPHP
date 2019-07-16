<?php
    include_once 'Categoria.php';
	include_once 'PDOFactory.php';

    class CategoriaDAO
    {
        public function inserir(Categoria $categoria)
        {
            $qInserir = "INSERT INTO categoria(descricao) VALUES (:descricao)";
            
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qInserir);
            $comando->bindParam(":descricao",$categoria->descricao);
            $comando->execute();
            $categoria->id = $pdo->lastInsertId();
            
            return $categoria;
        }

        public function deletar($id)
        {
            $qDeletar = "DELETE from categoria WHERE id=:id";
                        
            $categoria = $this->buscarPorId($id);
            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qDeletar);
            $comando->bindParam(":id",$id);
            $comando->execute();

            return $categoria;
        }

        public function atualizar(Categoria $categoria)
        {
            $qAtualizar = "UPDATE categoria SET descricao=:descricao WHERE id=:id";     

            $pdo = PDOFactory::getConexao();
            $comando = $pdo->prepare($qAtualizar);
            $comando->bindParam(":descricao",$categoria->descricao);
            $comando->bindParam(":id",$categoria->id);
            $comando->execute();


            return $categoria;
        }

        public function listar()
        {
		    $query = 'SELECT * FROM categoria';

    		$pdo = PDOFactory::getConexao();
	    	$comando = $pdo->prepare($query);
    		$comando->execute();
            $categorias=array();	
		    
            while($row = $comando->fetch(PDO::FETCH_OBJ)){
                $categorias[] = new Categoria($row->id,$row->descricao);
            }

            return $categorias;
        }

        public function buscarPorId($id)
        {
 		    $query = 'SELECT * FROM categoria WHERE id=:id';		
            $pdo = PDOFactory::getConexao(); 
		    $comando = $pdo->prepare($query);
		    $comando->bindParam ('id', $id);
		    $comando->execute();
		    $result = $comando->fetch(PDO::FETCH_OBJ);
		    
            return new Categoria($result->id,$result->descricao);           
        }
    }
?>