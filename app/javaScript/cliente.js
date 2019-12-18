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
    console.log(item)
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

function validarDadosVeiculo () {
    var inputs = document.getElementsByClassName('veiculo')
    var vazios = 0
    var key
    for (let index = 0; index < inputs.length; index++) {
        vazios += verificarVazioVeiculo(inputs[index]);
        try {
            key = inputs[index].id
            console.log(key)
            switch (key) {
                case 'placa':
                    verificarTamanho(inputs[index],7)
                    break;
                case 'renavan':
                    verificarTamanho(inputs[index],11)
                    break;
                case 'chassi':
                    verificarTamanho(inputs[index],17)
                    break;
                default:
                    break;
            }
        } catch (error) {
            alert(error)
            return false
        }
    }
    console.log(vazios)
    if (vazios>0) {
        alert('preencha todos os campos marcados em vermelho')
        return false
    }
    return true
    
}

//home controller
function mostrarLista() {
    var form = document.createElement("form");

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=locacao";

    //pegar o select
    selectCategoria = document.getElementById('categoria')
    

    //id da categoria selecionnada
    var elementoId = document.createElement("input");
    elementoId.value = selectCategoria[selectCategoria.selectedIndex].value;
    elementoId.name = 'categoria_id';
    elementoId.setAttribute("type","hidden")
    form.appendChild(elementoId)
    console.log(elementoId)



    document.body.appendChild(form);
    form.submit()
}

//locaçção

function retirarHidden() {
    var select = document.getElementById('categoria')
    var itens = document.getElementsByClassName('item-locacao')

    for (let index = 0; index < itens.length; index++) {
        if (itens[index].classList.contains(select[select.selectedIndex].value)) {
            itens[index].classList.remove('hidden-item')
            console.log('dentro do if')
            console.log(itens[index])
        } else {
            itens[index].classList.add('hidden-item')
            console.log('dentro do else')
            console.log(itens[index])
        }  
    }


}

function submeterVeiculo (id) {
    var form = document.createElement("form");

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=locacao&metodo=cliente";


    //id do veiculo
    var elementoId = document.createElement("input");
    elementoId.value = id;
    elementoId.name = "veiculo_id";
    elementoId.style.display = 'none';
    form.appendChild(elementoId)



    document.body.appendChild(form);
    form.submit()
}

function submeterCliente (idCliente, idVeiculo) {
    var form = document.createElement("form");
    console.log(idCliente)
    console.log(idVeiculo)

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=locacao&metodo=motorista";


    //id do veiculo
    var veiculo = document.createElement("input");
    veiculo.value = idVeiculo;
    veiculo.name = "veiculo_id";
    veiculo.style.display = 'none';
    form.appendChild(veiculo)

    //id do cliente
    var cliente = document.createElement("input");
    cliente.value = idCliente;
    cliente.name = "cliente_id";
    cliente.style.display = 'none';
    form.appendChild(cliente)



    document.body.appendChild(form);
    form.submit()
}

function submeterMotorista (idMotorista,  idVeiculo, idCliente) {
    var form = document.createElement("form");
    console.log('cliente',idCliente)
    console.log('veiculo',idVeiculo)
    console.log('motorista',idMotorista)

    form.setAttribute("type", "hidden");

    form.method = "POST";
    form.action = "?pagina=locacao&metodo=dados&id="+idMotorista;

    console.log(form.action);


    //id do veiculo
    var veiculo = document.createElement("input");
    veiculo.value = idVeiculo;
    veiculo.name = "veiculo_id";
    veiculo.style.display = 'none';
    form.appendChild(veiculo)

    //id do cliente
    var cliente = document.createElement("input");
    cliente.value = idCliente;
    cliente.name = "cliente_id";
    cliente.style.display = 'none';
    form.appendChild(cliente)

    //id do motorista
    var motorista = document.createElement("input");
    motorista.value = idMotorista;
    motorista.name = "motorista_id";
    motorista.style.display = 'none';
    form.appendChild(motorista)



    document.body.appendChild(form);
    form.submit()
}

function setarData () {
    console.log('dentro de data')
    if (document.getElementById('data-inicial')){
        document.getElementById('data-inicial').value = new Date().toDateInputValue();
    }
}

//feedback para input de data
function verificaMes(selecionado,id) {

    //verificar quantos dias tem o mes
    switch (selecionado) {
        case '2':
            setarDias(28,id)
            break
        case '4':
        case '6':
        case '9':
        case '11':
            setarDias(30,id)
            break
        default:
            setarDias(31,id)
            break
    }

    //modificar os dias que nao fazem parte do mes para disabled
    function setarDias(dias,id) {
        console.log(id)
        if (id == 'option-mes-inicio') {
            let selectDias = document.getElementById('option-dia-inicio')
            let optionDias = selectDias.getElementsByTagName('option')
            selectDias.disabled = false

            for (let i = 25; i < optionDias.length; i++) {
                optionDias[i].disabled = false
                optionDias[i].style.color = '#495057';   
            }

            for (let i = dias+1; i < optionDias.length; i++) {
                optionDias[i].disabled =true
                optionDias[i].style.color = '#d9534f'; //danger cor do bootstrap
            }
        } else {
            let selectDias = document.getElementById('option-dia-fim')
            let optionDias = selectDias.getElementsByTagName('option')
            selectDias.disabled = false

            for (let i = 25; i < optionDias.length; i++) {
                optionDias[i].disabled = false
                optionDias[i].style.color = '#495057';   
            }

            for (let i = dias+1; i < optionDias.length; i++) {
                optionDias[i].disabled =true
                optionDias[i].style.color = '#d9534f'; //danger cor do bootstrap
            }
        }
        
    }
}

//validar campos de data vazios
function verificarVazioData() {
    var datas = document.getElementsByClassName('data')
    var datasVazias = 0

    for (let index = 0; index < datas.length; index++) {
        if (datas[index].value == 0) {
            datas[index].classList.add('erro')
            datasVazias++
        } else datas[index].classList.remove('erro')
    }

    if (datasVazias!=0) {
        alert('preencha todas as datas')
        //return false
    }
    
    //validar se o dia de devolução é posterior
    var diaInicio = document.getElementById('option-dia-inicio')[document.getElementById('option-dia-inicio').selectedIndex].value
    var mesInicio = document.getElementById('option-mes-inicio')[document.getElementById('option-mes-inicio').selectedIndex].value
    var anoInicio = document.getElementById('option-ano-inicio')[document.getElementById('option-ano-inicio').selectedIndex].value

    var diaFim = document.getElementById('option-dia-fim')[document.getElementById('option-dia-fim').selectedIndex].value
    var mesFim = document.getElementById('option-mes-fim')[document.getElementById('option-mes-fim').selectedIndex].value
    var anoFim = document.getElementById('option-ano-fim')[document.getElementById('option-ano-fim').selectedIndex].value

    if(!verificarDataVemDepois(diaInicio,mesInicio,anoInicio,diaFim,mesFim,anoFim)) return false 

    //calcular valores
    var dataInicial = mesInicio+"/"+diaInicio+"/"+anoInicio
    var dataFinal = mesFim+"/"+diaFim+"/"+anoFim
    var date1 = new Date(dataInicial) ;
    var date2 = new Date(dataFinal); 
  
    // To calculate the time difference of two dates 
    var Difference_In_Time = date2.getTime() - date1.getTime(); 
    
    // To calculate the no. of days between two dates 
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    var valorCategoria = document.getElementsByName('valor')[0].value
    var locacao = Math.floor(Difference_In_Days)* valorCategoria
    document.getElementById('valor-locacao').innerHTML = locacao
    gerarelemento('valor_locacao',locacao)

    var seguro = locacao * 0.05 
    document.getElementById('valor-seguro').innerHTML = seguro
    gerarelemento('valor_seguro', seguro)
    
    var caucao = (locacao + (locacao * 0.05))/2 
    document.getElementById('valor-caucao').innerHTML = caucao
    gerarelemento('valor_caucao',caucao)


    var total = (locacao * 0.05) + locacao 
    document.getElementById('valor-total').innerHTML = total
    gerarelemento('valor_total',total)
}

function gerarelemento(nome, valor) {
    var form = document.getElementById('locacao') 
    console.log(form)
    var elemento = document.createElement("input");
    elemento.value = valor;
    elemento.name = nome;
    elemento.style.display = 'none';
    form.appendChild(elemento)
}

function verificarDataVemDepois (di,mi,ai,df,mf,af) {
    if (ai > af) {
        var anoI = document.getElementById('option-ano-fim')
        console.log(anoI)
        anoI.classList.add('erro')
        var anoF = document.getElementById('option-ano-inicio')
        anoF.classList.add('erro')
        alert('A data de entrega deve ser posterior a data de locação!')
        return false
    } else {
        document.getElementById('option-ano-fim').classList.remove('erro')
        document.getElementById('option-ano-inicio').classList.remove('erro')

        if(mi>mf && ai==af) {
            document.getElementById('option-mes-fim').classList.add('erro')
            document.getElementById('option-mes-inicio').classList.add('erro')
            alert('A data de entrega deve ser posterior a data de locação!')
            return false
        } else {
            document.getElementById('option-mes-fim').classList.remove('erro')
            document.getElementById('option-mes-inicio').classList.remove('erro')

            if (di >= df && mi == mf && ai == af) {
                document.getElementById('option-dia-fim').classList.add('erro')
                document.getElementById('option-dia-inicio').classList.add('erro')
                alert('A data de entrega deve ser posterior a data de locação!')
                return false
            }
        }
    }

    return true
}
