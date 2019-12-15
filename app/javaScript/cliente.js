/*
    Lógicas para validação de dados nas views relacionadas ao cliente
*/
function verificarTipo() {
    //desabilitar os campos que nao tem haver com o tipo do cliente que vai ser alterado
    try {
        var tipocpf = document.getElementsByName('tipo')[0].checked 
        console.log(tipocpf)
        
        if(tipocpf == false) {
            document.getElementById('rg').disabled = true
            document.getElementById('razao').disabled = true        
        } else {
            document.getElementById('razao').disabled = true
            document.getElementById('rg').disabled = tue
        }
    } catch (error) {
        console.log(error)
    }    
}

function retirarDisabled() {
    //desabilitar os campos que nao tem haver com o tipo do cliente que vai ser alterado
    try {
        var tipocpf = document.getElementsByName('tipo')[0].checked 
        console.log(tipocpf)
        
        if(tipocpf == false) {
            document.getElementById('rg').disabled = true
            document.getElementById('razao').disabled = false  
            document.getElementById('cpfCnpj').disabled = false       
        } else {
            document.getElementById('razao').disabled = true
            document.getElementById('rg').disabled = false
            document.getElementById('cpfCnpj').disabled = false
        }
    } catch (error) {
        console.log(error)
    }    
}

function verificarTipoCadastro() {
    //desabilitar os campos que nao tem haver com o tipo do cliente que vai ser alterado
    try {
        var tipocpf = document.getElementsByName('tipo')[0].checked 
        console.log(tipocpf)
        
        if(tipocpf == false) {
            document.getElementById('rg').disabled = true
            document.getElementById('razao').disabled = false        
        } else {
            document.getElementById('razao').disabled = true
            document.getElementById('rg').disabled = false
        }
    } catch (error) {
        console.log(error)
    }    
}



function validaDados() {
    var campos = Array()
    campos.push(document.getElementById('cpfCnpj'))
    campos.push(document.getElementById('nome'))
    campos.push(document.getElementById('razao'))
    campos.push(document.getElementById('rg'))
    campos.push(document.getElementById('telefone1'))
    campos.push(document.getElementById('email'))
    campos.push(document.getElementById('telefone2'))
    campos.push(document.getElementById('logradouro'))
    campos.push(document.getElementById('numero'))
    campos.push(document.getElementById('complemento'))
    campos.push(document.getElementById('bairro'))
    campos.push(document.getElementById('numero'))
    campos.push(document.getElementById('cidade'))
    campos.push(document.getElementById('estado'))
    campos.push(document.getElementById('cep'))
    
    //para cada campo verificar se esta vazio e se tem a quantidade de digitos correta


    vazio = percorrerVerificarVazio(campos)
    tamanho = percorrerVerificarTamanho(campos)

    console.log("validacao tamanho:"+tamanho)
    console.log("validacao vazio:"+vazio)

    if ( tamanho && vazio  ) {
        console.log("retorno: true")
        return true
    } else {
        if (vazio == false) {
            console.log("dfentro do if")
            alert ("preencha todos os campos marcados em vermelho!")
        }
        console.log("retorno: false")
        return false
    } 



}

function percorrerVerificarTamanho (campos) {
    var camposTamanho = 0
    var tipocpf = document.getElementsByName('tipo')[0].checked 
    campos.forEach(element => {
        try {
            switch (element.id) {
                case 'cpfCnpj':
                    if (tipocpf){
                        verificarTamanho(element,11)
                    } else verificarTamanho(element,14)
                    break;
                case 'rg':
                    //verificar rg apenas se o cliente passado for PF
                    if (tipocpf){
                        verificarTamanho(element,7)
                    }
                    break;
                case 'telefone1':
                    verificarTamanho(element,11)
                    break;
                case 'telefone2':
                    if(element.value.length != 0)
                        verificarTamanho(element,11)
                    break;
                case 'cep':    
                    verificarTamanho(element,8)
                    break;
                default:
                    break;
            }
        } catch (error) {
            alert(error)
            camposTamanho++
        }
    });

    if (camposTamanho > 0) {
        console.log("tamanhoCampos: "+ camposTamanho)
        return false
    } return true
}

function percorrerVerificarVazio (campos) {
    var camposVazios = 0
    campos.forEach(element => {
        camposVazios += verificarVazio(element)
    });

    if (camposVazios > 0) {
        return false
    } return true
}

function verificarTamanho(item,tamanho){
    if(item.value.length != tamanho && item.disabled == false){
        item.classList.add('erro')
        throw "campo "+item.id+" deve ter "+tamanho+" digitos"
    } else item.classList.remove('erro')
}

function verificarVazio(item) {
    if (item.value.length == '' && item.id != 'telefone2' && item.disabled == false ){
        item.classList.add('erro')
        return 1 
    } else {
        item.classList.remove('erro')
        return 0
    }
}

/*
    Lógicas para validação de dados nas views relacionadas a categoria
*/

//recolhe os campos que vao ser modificados e passa para uma função modificalos
function habilitarEdicao (id) {
    //mudar o botão para se tornar salvar e habilitar os campos para edição
    var btnAlterar = document.getElementById(id)
    var inputs = document.getElementsByClassName(id)
    
    alterarHabilitar(btnAlterar,inputs,id)    

    return false
}

//seta variaveis com os campos para enviar pro banco de dados
function habilitarSubmissao(id,pagina) {
    var inputs = document.getElementsByClassName(id)
    if (pagina == "categoria") {
        verificarSubmissao(inputs,id)
    } else if (pagina == "modelo")
    {   var idCategoria = document.getElementById('select-categoria')[document.getElementById('select-categoria').selectedIndex].className 
        criarSubmissaoModelo(inputs,idMarca,idCategoria)

    } else criarSubmissaoMarca(inputs,id)
}

//cria um formulario com os campos alterados e envia para o banco de dados
function verificarSubmissao(inputs,id) {
    var form = document.createElement("form");
    var element1 = document.createElement("input"); 
    var element2 = document.createElement("input");
    var element3 = document.createElement("input");  

    form.method = "POST";
    form.action = "?pagina=categoria&metodo=alterarCategoria";

    element1.value = inputs[0].value;
    element1.name = "nome";
    form.appendChild(element1);  

    element2.value = inputs[1].value;
    element2.name = "valor";
    form.appendChild(element2);

    element3.value = id;
    element3.name = "categoria_id";
    form.appendChild(element3);

    document.body.appendChild(form);

    form.submit();

    return false
}

//cria um formulario com os campos alterados e envia para o banco de dados
function criarSubmissaoModelo(inputs,idMarca, idCategoria) {
    
    var form = document.createElement("form");

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=modelo&metodo=alterarModelo";
    
    for (let index = 0; index < inputs.length; index++) {
        form.appendChild(retornaInput(inputs[index])) 
    }

    //marca escolhida
    var elementoId = document.createElement("input");
    elementoId.value = idMarca;
    elementoId.name = "modelo_id";
    form.appendChild(elementoId)

    //categoria escolhida
    var categoriaId = document.createElement("input");
    categoriaId.value = idCategoria;
    categoriaId.name = "categoria_id";

    document.body.appendChild(form);
    

    form.submit();

    return false
}

function criarSubmissaoMarca (inputs,id)
{
     
    var form = document.createElement("form");
    form.setAttribute("type", "hidden");


    form.method = "POST";
    form.action = "?pagina=marca&metodo=alterarMarca";
    
    for (let index = 0; index < inputs.length; index++) {
        form.appendChild(retornaInput(inputs[index])) 
    }

    var elementoId = document.createElement("input");
    elementoId.value = id;
    elementoId.name = "marca_id";
    form.appendChild(elementoId)

    document.body.appendChild(form);
    form.submit();

    return false
}

function retornaInput (input) {
    
    if(input.nodeName == "SELECT") {
        var elemento = document.createElement("input");
        elemento.value = input.options[input.selectedIndex].value;
        elemento.name =  input.name;
        return elemento
    } else {
        var elemento = document.createElement("input");
        elemento.value = input.value;
        elemento.name = input.name;
        return elemento
    }
    
}

//altera o botão e habilita os inputs
function alterarHabilitar(btn,inputs,id) {
    //trocar o botão de alterar para salvar 
    btn.style.visibility = "hidden"
    var idBtn = "btn-salvar-"+id
    var btnSalvar = document.getElementById(idBtn)
    btnSalvar.classList.remove('escondido')

    //habilitar inputs
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].disabled = false
        
    }
    inputs[0].focus()

}

//verifica se os campos de cadastrar categoria estão vazios
function validaDadosCategoria () {
    var campos = Array ()
    campos.push(document.getElementById('nome')) 
    campos.push(document.getElementById('valor'))

    var camposVazios = 0
    campos.forEach(element => {
        camposVazios += verificarVazio(element)
    });

    if (camposVazios > 0) {
        return false
    } return true
}

/*
    Lógicas para validação de dados nas views relacionadas a modelo
*/
//verifica se os campos de cadastrar modelo estão vazios
function validaDadosModelo () {
    var campos = document.getElementsByClassName('modelo')
    
    
    //setar o id da marca selecionad
    var marca = document.getElementById('marca')
    var idModelo = document.getElementById('select-marca')
    marca.value = idModelo[idModelo.selectedIndex].id

    //setar o id da marca selecionad
    var categoria = document.getElementById('categoria')
    var idCategoria = document.getElementById('select-categoria')
    var idCat = idCategoria[idCategoria.selectedIndex].id.replace("cat-","")
    categoria.value = idCat
    

    var camposVazios = 0

    for (let index = 0; index < campos.length; index++) {
        camposVazios += verificarVazio(campos[index]);    
    }

    if (camposVazios > 0) {
        alert("preencha todos os campos")
        return false
    } return true
}

/*
    Lógicas para imagens
*/

//previsualizar imagem
var loadFile = function(event) {
    var output = document.getElementById('output');

    output.src = URL.createObjectURL(event.target.files[0]);
  };

//habilitar submissao de veiculo
function habilitarSubmissaoVeiculo (idVeiculo,idModelo) {
    var inputs =  document.getElementsByClassName(idVeiculo);
    var vazios = 0
    for (let index = 0; index < inputs.length; index++) {
        vazios += verificarVazioVeiculo(inputs[index]);
    }

    if (vazios>0) {
        return false
    }

    var form = document.createElement("form");

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=veiculo&metodo=alterarVeiculo";
    
    for (let index = 0; index < inputs.length; index++) {
        form.appendChild(retornaInput(inputs[index])) 
    }

    //id do veiculo
    var elementoId = document.createElement("input");
    elementoId.value = idVeiculo;
    elementoId.name = "veiculo_id";
    form.appendChild(elementoId)



    document.body.appendChild(form);
    form.submit()

}

function verificarVazioVeiculo (item) {
    if (item.value.length == '' && item.name != 'preco_venda'){
        console.log(item)
        item.classList.add('erro')
        return 1 
    } else {
        item.classList.remove('erro')
        return 0
    }
}