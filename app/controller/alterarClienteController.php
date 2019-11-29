<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class AlterarClienteController 
    {
        public function index($id)
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $cliente = Cliente::retornarCliente($id);

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
                $template = $twig->load('alterarCliente.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $parametros['cliente'] = $cliente;
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            
        }
    }