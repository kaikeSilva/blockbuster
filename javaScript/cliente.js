
function verificarTipo() {
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
    var camposVazios = 0
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

    var tipocpf = document.getElementsByName('tipo')[0].checked 
    
    //para cada campo verificar se esta vazio e se tem a quantidade de digitos correta
    campos.forEach(element => {
        try {
            camposVazios += verificarVazio(element,tipocpf)
            

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
            return false
        }
    });

    if(camposVazios > 0) {
        alert("preencha todos os campos!")
        return false
    } else return true



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
        throw 
    } else {
        item.classList.remove('erro')
        return 0
    }
}

function desabilitar() {

}
