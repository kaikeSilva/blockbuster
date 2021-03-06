<?php

require_once 'app/core/core.php';
require_once 'app/controller/homeController.php';
require_once 'app/controller/clienteController.php';
require_once 'app/controller/ErroController.php';
require_once 'app/controller/alterarClienteController.php';
require_once 'app/model/cliente.php';
require_once 'lib/database/conection.php';
require_once 'vendor/autoload.php';
require_once 'app/controller/categoriaController.php';
require_once 'app/model/categoria.php';
require_once 'app/controller/modeloController.php';
require_once 'app/model/modelo.php';
require_once 'app/controller/marcaController.php';
require_once 'app/model/marca.php';
require_once 'app/controller/imagemController.php';
require_once 'app/model/imagem.php';
require_once 'app/controller/veiculoController.php';
require_once 'app/model/veiculo.php';
require_once 'app/controller/locacaoController.php';
require_once 'app/model/locacao.php';
require_once 'app/controller/motoristaController.php';
require_once 'app/model/motorista.php';
require_once 'app/controller/imagemCarteiraController.php';
require_once 'app/model/imagemCarteira.php';

$template = file_get_contents('app\template\estrutura.html');

/*trecho para nao deixar sair nada na tela
armazenar o conteudo que iria sair em uma variavel*/
ob_start();    
    $core = new Core;
    $core->start($_GET);

    $saida = ob_get_contents();
ob_end_clean();

//integrar o conteudo vindo de core que veio de uma controller ao html da pagina
$tplPronto = str_replace ('{{conteudo}}',$saida,$template);

echo($tplPronto);