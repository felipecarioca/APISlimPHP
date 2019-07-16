class CategoriaController {

    constructor(){}

    Salvar(event){
        
        event.preventDefault();
        
        var categoria = new Categoria();
        
        categoria.descricao = document.querySelector("#descricao").value;

        this.InserirCategoria(categoria);
    }

    InserirCategoria(categoria) {
        
        var self = this;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 201) {
                
                var conteudoPrincipal = document.getElementById('conteudo-principal');
                self.ViewCategorias(conteudoPrincipal);

            }
        };

        xhttp.open("POST", "http://localhost/marketduct/categorias", true);
        xhttp.setRequestHeader("Content-Type","application/json");
        xhttp.send(JSON.stringify(categoria));
        
    }

    GetCategorias(construir) {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
        	
        	if (this.readyState === 4 && this.status === 200) {

            	if(construir == 'select')
                	self.CreateSelectCategorias(JSON.parse(this.responseText));
                else
                	self.CreateTableCategorias(JSON.parse(this.responseText));

            }
        };

        xhttp.open("GET", "http://localhost/marketduct/categorias", true);
        xhttp.send();
    }

    CreateSelectCategorias(categorias){

        var categoria = document.getElementById('id_categoria');    
        
        for(var i in categorias){

    		var option = document.createElement("option");
			
			option.text = categorias[i].descricao;
			option.value = categorias[i].id;

			categoria.add(option);
        }
    }

    CreateTableCategorias(categorias){

        var str = ``;
    
        for(var i in categorias){
            str+=`
                <div class="coluna-produto">
                    <div class="campo-formulario" style="cursor: pointer; height: 80px; display: flex;" idproduto="${categorias[i].id}">
                        <img src="imagens/fogao.jpg" style="height: 100%; vertical-align: middle;">
                        <div style="padding-left: 10px;">
                            <div>
                                <span>${categorias[i].descricao}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        var categorias = document.querySelector("#categorias");
        categorias.innerHTML = str;
    }

    BotaoIncluir() {

        var self = this;

        var conteudoPrincipal = document.getElementById('conteudo-principal');
        self.ViewInserirCategoria(conteudoPrincipal);
    }

    ViewInserirCategoria(element) {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                element.innerHTML = this.responseText;

                var form = document.querySelector("#formIncluir");
                form.addEventListener("submit", self.Salvar.bind(self));
            }
        };

        xhttp.open("GET", "view/categoria.html", true);
        xhttp.send();
    }

    ViewCategorias() {

        var self = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
            	var conteudoPrincipal = document.getElementById('conteudo-principal');
                conteudoPrincipal.innerHTML = this.responseText;

                self.GetCategorias();

                var incluirCategoria = document.getElementById("incluirCategoria");
                incluirCategoria.onclick = self.BotaoIncluir.bind(self);

            }
        };

        xhttp.open("GET", "view/categorias.html", true);
        xhttp.send();
    }
}