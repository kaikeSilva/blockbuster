<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class VeiculoController 
    {
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco os veiculos e seus modelos
                $colecaoVeiculos = Veiculo::selecionaTodos();
                $colecaoModelos = Modelo::selecionaTodos();
                

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
                $template = $twig->load('veiculo.html');

                //array com chaves parametros dos modelos para substituir na view
                $parametros = array();
                $parametros['modelos'] = $colecaoModelos;

                //array com chaves parametros dos veiculos para subtituir na view
                $parametros['veiculos'] = $colecaoVeiculos;
                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('veiculo.html');
                $conteudo = $template->render();

                echo $conteudo;
            } 


        }

        //carregar pagina para alteração da imagem
        public function alterarImagem($id,$imagem) {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {

                //retornar nome da imagem atual do veiculo e os dados do veiculo
                $arquivo = Imagem::retornarNome($imagem);
                $veiculo = Veiculo::retornarVeiculo($id);

                $modelo = Modelo::retornarModelo($veiculo[0]->modelo_id);
                

                //solicitação ao banco os veiculos e seus modelos
                //$nomeImagemAtual = Imagem::retornarImagem($id,$imagem);
                

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
                $template = $twig->load('mudarImagemVeiculo.html');

                $parametros = array();
                $parametros['arquivos'] = $arquivo;
                $parametros['veiculos'] = $veiculo;
                $parametros['modelos'] = $modelo;

                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('mudarImagemVeiculo.html');
                $conteudo = $template->render();

                echo $conteudo;
            } 

        }

        //carregar logica para alerar as chaves estrangeiras no banco para a imagem escolhida
        public function salvarImagem() {
            $id = Imagem::cadastrarImagem();
            Veiculo::alterarImagem($_POST['veiculo_id'],$id);

            VeiculoController::index();
        }

        //retornar dados de veiculo por id
        public function retornarVeiculo($id) {
        }

        //atualizar dados do veiculo
        public function alterarVeiculo() {
            Veiculo::alterarVeiculo($_POST);
            VeiculoController::index();
        }

        //carregar pagina para cadastrar veiculo
        public function cadastrarVeiculo(){
            try {
                $modelos = Modelo::selecionaTodos();
                
                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */

                //carregar a view cadastrareiculo na tela
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('cadastrarVeiculo.html');

                //carregar modelos para o select
                $parametros = array();
                $parametros['modelos'] = $modelos;
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        //realizar o cadastro]
        public function realizarCadastro () {

            $idImagem = Imagem::cadastrarImagem($_FILES);
            $_POST['imagem'] = $idImagem;
            
            $resultado = Veiculo::cadastrarVeiculo($_POST);

            VeiculoController::index();
        }

        public function deletarVeiculo($id) 
        {
            //chamar a model para deletar
            $successoDeletar = Veiculo::deletar($id);

            //retornar a pagina inicial de veiculo

            VeiculoController::index();
        }
    }

?>