<?php

    class Core 
    {
        public function start($urlGet)
        {
            /*buscar pela controller da pagina passada na url e usar
            metodos dessa controller, caso nao exista, buscar pela controller home*/
            if (isset($urlGet['pagina'])){
                $controller = ucfirst( $urlGet['pagina'].'controller' ); 
            } else {
                $controller = 'HomeController';
            }
              
            $acao = 'index';
            


            if (!class_exists($controller)) {
                $controller = 'ErroController';
            }

            //a controller da pagina de alteração de cadastro espera um id como parametro
            var_dump($urlGet);
            //instanciação da controller e utilização do metodo
            call_user_func_array(array(new $controller, $acao),array('id' => $urlGet['id']));

        }
    }