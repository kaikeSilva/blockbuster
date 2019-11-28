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

            //instanciação da controller e utilização do metodo
            call_user_func_array(array(new $controller, $acao),array());

        }
    }