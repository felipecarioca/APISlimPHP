function MarcarProduto(element) {
	
	var idProduto = element.getAttribute('idproduto');
	element.classList.add('produto');

	document.getElementById('id_selecionado').value = idProduto;

	var produtos = document.getElementsByClassName('campo-formulario');

	for (var i = 0; i < produtos.length; i++) {

		if(produtos[i].getAttribute('idproduto') != idProduto) {
			produtos[i].classList.remove("produto");
		}

	}

}