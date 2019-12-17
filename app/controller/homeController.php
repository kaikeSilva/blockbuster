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
                 $colecaoCategorias = Categoria::selecionaTodos();


                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['categorias'] = $colecaoCategorias;
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('home.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            
        }
    }