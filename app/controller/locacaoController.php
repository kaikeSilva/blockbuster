<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class LocacaoController 
    {
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $dadoLocacaoVeiculo = Locacao::selecionaTodos();
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

                $parametros['itens'] = $dadoLocacaoVeiculo;
                $parametros['selecionada'] = $_POST;

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacao.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacao.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();
            }

            
        }

        public function cliente(){
            //carregar paginas com os clientes
            var_dump($_POST);
            try {
                //solicitação ao banco
                $clientes = Cliente::selecionaTodos();


                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['clientes'] = $clientes;

                $parametros['veiculo_id'] = $_POST['veiculo_id'];

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoCliente.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoCliente.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();
            }

        }

        
        public function motorista(){
            //carregar paginas com os clientes
            var_dump($_POST);
            try {
                //solicitação ao banco os dados dos motoristas
                //por enquanto esta sendo buscado dos clientes
                $clientes = Cliente::selecionaTodos();


                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['clientes'] = $clientes;

                $parametros['veiculo_id'] = $_POST['veiculo_id'];
                $parametros['cliente_id'] = $_POST['cliente_id'];

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoMotorista.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoMotorista.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();
            }

        }

        public function dados(){
            //carregar paginas com os clientes
            var_dump($_POST);
            try {
                //solicitação ao banco os dados dos motoristas
                //por enquanto esta sendo buscado dos clientes
                $clientes = Cliente::selecionaTodos();


                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['clientes'] = $clientes;

                $parametros['veiculo_id'] = $_POST['veiculo_id'];
                $parametros['cliente_id'] = $_POST['cliente_id'];

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoDados.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoDados.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();
            }

        }


    }

?>