class ProdutoController {

    constructor(){}

    Salvar(event){
        
        event.preventDefault();
        
        var produto = new Produto();
        
        produto.descricao = document.querySelector("#descricao").value;
        produto.preco = document.querySelector("#preco").value;        
        //produto.id_categoria = document.getElementById("id_categoria").value;
        produto.id_categoria = document.querySelector("#id_categoria").value;

        this.InserirProduto(produto);
    }

    InserirProduto(produto) {
        var self = this;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 201) {
                //console.log(JSON.parse(this.responseText));
                
                var conteudoPrincipal = document.getElementById('conteudo-principal');
                self.ViewProdutos(conteudoPrincipal);

            }
        };

        xhttp.open("POST", "http://localhost/marketduct/produtos", true);
        xhttp.setRequestHeader("Content-Type","application/json");
        xhttp.send(JSON.stringify(produto));
        
    }

    Editar(event){
        
        event.preventDefault();
        
        var produto = new Produto();
        
        produto.id = document.querySelector("#id").value;
        produto.descricao = document.querySelector("#descricao").value;
        produto.preco = document.querySelector("#preco").value;
        produto.id_categoria = document.querySelector("#id_categoria").value;
        
        this.EditarProduto(produto);
    }

    EditarProduto(produto) {
        var self = this;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                //console.log(JSON.parse(this.responseText));
                
                var conteudoPrincipal = document.getElementById('conteudo-principal');
                self.ViewProdutos(conteudoPrincipal);

            }
        };

        xhttp.open("PUT", "http://localhost/marketduct/produtos/" + produto.id, true);
        xhttp.setRequestHeader("Content-Type","application/json");
        xhttp.send(JSON.stringify(produto));
        
    }

    GetProduto(idProduto) {

        var self = this;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                var produto = JSON.parse(this.responseText);

                document.getElementById("id").value = produto.id;
                document.getElementById("descricao").value = produto.descricao;
                document.getElementById("preco").value = produto.preco;

                document.getElementById("id_categoria").value = produto.id_categoria;

            }
        };

        xhttp.open("GET", "http://localhost/marketduct/produtos/" + idProduto, true);
        xhttp.send();
    }

    GetProdutos() {

        var self = this;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                self.MontarProdutos(JSON.parse(this.responseText));

            }
        };

        xhttp.open("GET", "http://localhost/marketduct/produtos", true);
        xhttp.send();
    }

    MontarProdutos(produtos){

        var str = ``;
    
        for(var i in produtos){
            str+=`
                <div class="coluna-produto">
                    <div class="campo-formulario" style="cursor: pointer; display: flex;" idproduto="${produtos[i].id}" onclick="MarcarProduto(this);">
                        <img src="imagens/tenis.jpg" style="height: 100%; vertical-align: middle;">
                        <div style="padding-left: 10px;">
                            <div>
                                <span>${produtos[i].descricao}</span>
                            </div>
                            <div>
                                <span style="font-weight: normal;">${produtos[i].preco}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        var produtos = document.querySelector("#produtos");
        produtos.innerHTML = str;
    }

    DeletarProduto() {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            
            if (this.readyState === 4 && this.status === 200) {
                
                // Carregamos a view dos produtos atualizada
                var conteudoPrincipal = document.getElementById('conteudo-principal');
                self.ViewProdutos(conteudoPrincipal);
    
            }
        };

        var produto = document.getElementById('id_selecionado').value;
        
        xhttp.open("DELETE", "http://localhost/marketduct/produtos/" + produto, true);
        xhttp.setRequestHeader("Content-Type","application/json");
        xhttp.send();
        
    }

    BotaoIncluir() {

        var self = this;

        var conteudoPrincipal = document.getElementById('conteudo-principal');
        self.ViewInserirProduto(conteudoPrincipal);
    }

    BotaoEditar() {

        if(!document.getElementById('id_selecionado').value)
            alert('Selecione algum produto!');
        else {

            var self = this;

            var conteudoPrincipal = document.getElementById('conteudo-principal');
            self.ViewEditarProduto(conteudoPrincipal);
        
        }
    }

    BotaoExcluir() {

        if(!document.getElementById('id_selecionado').value)
            alert('Selecione algum produto!');
        else {
            var self = this;
            self.DeletarProduto();
        }
        
    }
    
    ViewProdutos(element) {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                element.innerHTML = this.responseText;

                self.GetProdutos();

                var incluirProduto = document.getElementById("incluirProduto");
                incluirProduto.onclick = self.BotaoIncluir.bind(self);

                var excluirProduto = document.getElementById("excluirProduto");
                excluirProduto.onclick = self.BotaoExcluir.bind(self);

                var editarProduto = document.getElementById("editarProduto");
                editarProduto.onclick = self.BotaoEditar.bind(self);

            }
        };

        xhttp.open("GET", "view/produtos.html", true);
        xhttp.send();
    }
    
    ViewInserirProduto(element) {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                element.innerHTML = this.responseText;

                var categoriaController = new CategoriaController();

                categoriaController.GetCategorias('select');

                var form = document.querySelector("#formIncluir");
                form.addEventListener("submit", self.Salvar.bind(self));
            }
        };

        xhttp.open("GET", "view/produto.html", true);
        xhttp.send();
    }

    ViewEditarProduto(element) {

        var self = this;
        var idProduto = document.getElementById('id_selecionado').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                element.innerHTML = this.responseText;

                document.getElementById('tituloPagina').innerHTML = 'Editar Produto';

                // Montamos o select de categorias
                var categoriaController = new CategoriaController();
                categoriaController.GetCategorias('select');

                // Inserimos os dados existentes nos campos
                self.GetProduto(idProduto);

                var form = document.querySelector("#formIncluir");
                form.addEventListener("submit", self.Editar.bind(self));
            }
        };

        xhttp.open("GET", "view/produto.html", true);
        xhttp.send();
    }
}