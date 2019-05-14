<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	include_once('CategoriaController.php');
	include_once('LojaController.php');
	include_once('ProdutoController.php');
	include_once('UsuarioController.php');
	
	require './vendor/autoload.php';

	$app = new \Slim\App;

	// Categorias

	/*
	$app->group('/categorias', function() use ($app) {
	    $app->get('','CategoriaController:listar');
	    $app->post('','CategoriaController:inserir');

	    $app->get('/{id}','CategoriaController:buscarPorId');    
	    $app->put('/{id}','CategoriaController:atualizar');
	    $app->delete('/{id}', 'CategoriaController:deletar');
	});
	*/	

	// Produtos

	$app->group('/produtos', function() use ($app) {
	    $app->get('','ProdutoController:listar');
	    $app->post('','ProdutoController:inserir');

	    $app->get('/{id}','ProdutoController:buscarPorId');    
	    $app->put('/{id}','ProdutoController:atualizar');
	    $app->delete('/{id}', 'ProdutoController:deletar');
	});	

	$app->run();

?>