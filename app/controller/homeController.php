<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class HomeController 
    {
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $colecaoClientes = Cliente::selecionaTodos();

                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('home.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $parametros['clientes'] = $colecaoClientes;
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            
        }
    }