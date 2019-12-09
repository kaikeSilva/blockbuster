<?php
    class ModeloController {
        // pagina principal de categoria
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
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
                $template = $twig->load('modelo.html');

                //array com chaves parametros para substituir na view
                $parametros = array();
                $parametros['modelos'] = $colecaoModelos;
                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('modelo.html');
                $conteudo = $template->render();
                echo $conteudo;
            } 

            
        }
        
        public function alterarModelo() 
        {
            
            
            //preparar os dados de modelo
            $modelo = array();
            $modelo['nome'] = $_POST['nome'];
            $modelo['qtd_passageiros'] = $_POST['qtd_passageiros'];
            $modelo['ano_fabricacao'] = $_POST['ano_fabricacao'];
            $modelo['ano_modelo'] = $_POST['ano_modelo'];
            $modelo['combustivel'] = $_POST['combustivel'];
            $modelo['potencia'] = $_POST['potencia'];
            $modelo['porta_malas'] = $_POST['porta_malas'];
            $modelo['modelo_id'] = $_POST['modelo_id'];
            

            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação a model para insirir
                $update = Modelo::alterarModelo($modelo);

                $url['pagina'] = 'modelo';
                Core::start($url);

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function cadastrarModelo()
        {
            try {

                /*
                    twig é uma api que permite mostrar conteudos na view sem a necessidade de escrever
                    codigo php no html da view, assim o codigo não fica misturado.
                    sintaxe:
                        naview: {{conteudo}}
                        na controller: array[conteudo] = nome

                        o valores na view dentro de {{}} sao substituidos pela valor da chave no array

                */

                //carregar a view cadastrarModelo na tela
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('cadastrarModelo.html');


                $parametros = array();
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            
        }

        public function realizarCadastro() 
        {
            //preparar os dados de modelo

            $modelo = array();
            $modelo['nome'] = $_POST['nome'];
            $modelo['qtd_passageiros'] = $_POST['qtd_passageiros'];
            $modelo['ano_fabricacao'] = $_POST['ano_fabricacao'];
            $modelo['ano_modelo'] = $_POST['ano_modelo'];
            $modelo['combustivel'] = $_POST['combustivel'];
            $modelo['potencia'] = $_POST['potencia'];
            $modelo['porta_malas'] = $_POST['porta_malas'];

            try {
                //enviar dados para o banco
                $update = Modelo::cadastrarModelo($modelo);

                $url['pagina'] = 'modelo';
                Core::start($url);
            } catch (Exception $e) {
                //mostrar erro natela


                //recarregar a página
                $url['pagina'] = 'modelo';
                $url['metodo'] = 'cadastrarModelo';
                Core::start($url);
            }

        }

        public function deletarModelo($id) 
        {
            //chamar a model para deletar
            $successoDeletar = Modelo::deletar($id);

            //retornar a pagina inicial de modelo

            $url['pagina'] = 'modelo';
            Core::start($url);
        }


    //fechamento da classe
    }
?>