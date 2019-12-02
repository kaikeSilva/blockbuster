<?php

require_once 'app/core/core.php';
require_once 'app/controller/homeController.php';
require_once 'app/controller/clienteController.php';
require_once 'app/controller/ErroController.php';
require_once 'app/controller/alterarClienteController.php';
require_once 'app/model/cliente.php';
require_once 'lib/database/conection.php';
require_once 'vendor/autoload.php';

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