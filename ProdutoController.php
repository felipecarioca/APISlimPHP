<?php

include_once('Produto.php');
include_once('ProdutoDAO.php');
include_once('Loja.php');
include_once('LojaDAO.php');


class ProdutoController {
    public function listar($request, $response, $args) {
        $dao= new ProdutoDAO;    
        $produtos =  $dao->listar();
                
        return $response->withJson($produtos);    
    }
    
    public function buscarPorId($request, $response, $args) {
        $id = $args['id'];
        
        $dao= new ProdutoDAO;    
        $produto = $dao->buscarPorId($id);
        
        return $response->withJson($produto);
    }

    public function inserir( $request, $response, $args) {
        $p = $request->getParsedBody();
        $produto = new Produto(0, $p['descricao'], $p['preco'], $p['id_categoria']);
    
        $dao = new ProdutoDAO;
        $produto = $dao->inserir($produto);

        // Inserindo o produto na tabela loja...
        $loja = new Loja(0, $produto->id, $p['id_usuario'], 0);

        $lojaDao = new LojaDAO;
        $loja = $lojaDao->inserir($loja);
    
        return $response->withJson($produto,201);
    }
    
    public function atualizar($request, $response, $args) {
        $id = $args['id'];
        $p = $request->getParsedBody();
        $produto = new Produto($id, $p['descricao'], $p['preco'], $p['id_categoria']);
    
        $dao = new ProdutoDAO;
        $produto = $dao->atualizar($produto);
    
        return $response->withJson($produto);    
    }

    public function deletar($request, $response, $args) {
        $id = $args['id'];

        $dao = new ProdutoDAO;
        $produto = $dao->deletar($id);
    
        return $response->withJson($produto);  
    }
}