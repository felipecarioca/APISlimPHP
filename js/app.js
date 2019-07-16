var produtoController = new ProdutoController();

var conteudoPrincipal = document.getElementById('conteudo-principal');
produtoController.ViewProdutos(conteudoPrincipal);

var categoriaController = new CategoriaController();
var menuCategorias = document.getElementById('menu_categorias');
menuCategorias.onclick = categoriaController.ViewCategorias.bind(categoriaController);