<?php

    class Core 
    {
        public static function start($urlGet)
        {
            //ação guarda o metodo que vai ser usado da controller
            if(isset($urlGet['metodo'])){
                $acao = $urlGet['metodo'];
            } else {
                $acao = 'index';
            }

            /*buscar pela controller da pagina passada na url e usar
            metodos dessa controller, caso nao exista, buscar pela controller home*/
            if (isset($urlGet['pagina'])){
                $controller = ucfirst( $urlGet['pagina'].'controller' ); 
            } else {
                $controller = 'HomeController';
            }

            //caso tente acessar uma pagina invalida enviar para pagina de erro
            if (!class_exists($controller)) {
                $controller = 'ErroController';
            }

            //instanciação da controller e utilização do metodo


            //a controller da pagina de alteração de cadastro espera um id como parametro
            //nem todos as paginas enviam o parametro id, verificdar se foi setado antes de enviar para controller
            if(isset($urlGet['id']) && $urlGet['id'] !=null ){
                $id = $urlGet['id'];
            } else {
                $id = null;
            }
            var_dump($controller);
            var_dump($acao);
            call_user_func_array(array(new $controller, $acao),array('id'=>$id));


        }
    }