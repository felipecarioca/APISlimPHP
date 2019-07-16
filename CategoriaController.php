<?php

include_once('Categoria.php');
include_once('CategoriaDAO.php');


class CategoriaController {
    public function listar($request, $response, $args) {
        $dao= new CategoriaDAO;    
        $categorias =  $dao->listar();
        
        return $response->withJson($categorias);    
    }
    
    public function buscarPorId($request, $response, $args) {
        $id = $args['id'];
        
        $dao= new CategoriaDAO;    
        $categoria = $dao->buscarPorId($id);
        
        return $response->withJson($categoria);
    }

    public function inserir( $request, $response, $args) {
        $p = $request->getParsedBody();
        $categoria = new Categoria(0,$p['descricao']);
    
        $dao = new CategoriaDAO;
        $categoria = $dao->inserir($categoria);
    
        return $response->withJson($categoria,201);    
    }
    
    public function atualizar($request, $response, $args) {
        $id = $args['id'];
        $p = $request->getParsedBody();
        $categoria = new Categoria($id, $p['descricao']);
    
        $dao = new CategoriaDAO;
        $categoria = $dao->atualizar($categoria);
    
        return $response->withJson($categoria);    
    }

    public function deletar($request, $response, $args) {
        $id = $args['id'];

        $dao = new CategoriaDAO;
        $categoria = $dao->deletar($id);
    
        return $response->withJson($categoria);  
    }
}