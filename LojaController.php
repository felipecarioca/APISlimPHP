<?php

include_once('Loja.php');
include_once('LojaDAO.php');


class LojaController {
    public function listar($request, $response, $args) 
    {
        $dao= new LojaDAO;
        $lojas =  $dao->listar();
                
        return $response->withJson($lojas);    
    }
    
    public function buscarPorId($request, $response, $args) 
    {
        $id = $args['id'];
        
        $dao= new LojaDAO;
        $loja = $dao->buscarPorId($id);
        
        return $response->withJson($loja);
    }

    public function inserir( $request, $response, $args) 
    {
        $l = $request->getParsedBody();
        $loja = new Loja(0, $l['id_produto'], $l['proprietario'], $l['vendedor']);
    
        $dao = new LojaDAO;
        $loja = $dao->inserir($loja);
    
        return $response->withJson($loja,201);    
    }
    
    public function atualizar($request, $response, $args) 
    {
        $id = $args['id'];
        $l = $request->getParsedBody();
        $loja = new Loja($id, $l['id_produto'], $l['proprietario'], $l['vendedor']);
        
        $dao = new LojaDAO;
        $loja = $dao->atualizar($loja);
        
        return $response->withJson($loja);    
    }

    public function deletar($request, $response, $args) 
    {
        $id = $args['id'];

        $dao = new LojaDAO;
        $loja = $dao->deletar($id);
    
        return $response->withJson($loja);  
    }
}