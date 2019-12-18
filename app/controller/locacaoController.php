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
            try {
                //solicitação ao banco os dados dos motoristas
                //por enquanto esta sendo buscado dos clientes
                $motoristas = Motorista::selecionaTodos();


                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['motoristas'] = $motoristas;

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

        public function dados($motorista){
            //carregar paginas com os clientes
            if (Locacao::consultarMotorista($motorista))
            {
                //solicitação ao banco os dados dos motoristas
                //por enquanto esta sendo buscado dos clientes
                $veiculo = Veiculo::retornarVeiculo($_POST['veiculo_id']);
                $modelo = Modelo::retornarModelo($veiculo[0]->modelo_id);
                $categoria = Categoria::retornaCategoria($modelo[0]->categoria_id);

                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['motorista_id'] = $motorista;
                $parametros['veiculo_id'] = $_POST['veiculo_id'];
                $parametros['cliente_id'] = $_POST['cliente_id'];
                $parametros['categorias'] = $categoria;
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoDados.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } else {
                echo '<script language="javascript">';
                echo 'alert("Motorista não pode participar da locação pois ja esta vinculado a outra locação")';  
                echo '</script>';
                LocacaoController::motorista();
            }

        }

        public function finalizacao(){
            //carregar paginas com os clientes
            try {
                
                //solicitação ao banco os dados dos motoristas
                //por enquanto esta sendo buscado dos clientes
                var_dump($_POST);
                Locacao::cadastrarLocacao();
                Veiculo::mudarSituacao($_POST['veiculo_id']);
                $veiculo = Veiculo::retornarVeiculo($_POST['veiculo_id']);
                $modelo = Modelo::retornarModelo($veiculo[0]->modelo_id);
                $categoria = Categoria::retornaCategoria($modelo[0]->categoria_id);
                $cliente = Cliente::retornarCliente($_POST['cliente_id']);
                $motorista = Motorista::retornarMotorista($_POST['motorista_id']);

                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */
                $parametros = array();
                $parametros['veiculo'] = $veiculo;
                $parametros['motorista'] = $motorista;
                $parametros['modelo'] = $modelo;
                $parametros['categoria'] = $categoria;
                $parametros['cliente'] = $cliente;
                $parametros['dados'] = $_POST;
                var_dump($parametros);
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoFinalizacao.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render($parametros);

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('locacaoFinalizacao.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();
            }

        }
    }

?>