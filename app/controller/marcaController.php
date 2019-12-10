<?php
    class MarcaController {
        // pagina principal de categoria
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $colecaoMarcas = Marca::selecionaTodos();

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
                $template = $twig->load('marca.html');

                //array com chaves parametros para substituir na view
                $parametros = array();
                $parametros['marcas'] = $colecaoMarcas;
                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('marca.html');
                $conteudo = $template->render();
                echo $conteudo;
            } 

            
        }

        public function alterarMarca() 
        {
            //preparar os dados de marca
            $marca = array();
            $marca['nome'] = $_POST['nome'];
            $marca['marca_id'] = $_POST['marca_id'];

            
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação a model para insirir
                $update = Marca::alterarMarca($marca);

                $url['pagina'] = 'marca';
                Core::start($url);

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function cadastrarMarca()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {

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
                $template = $twig->load('cadastrarMarca.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            
        }

        public function realizarCadastro() 
        {
            //preparar os dados de categoria
            $marca = array();
            $marca['nome'] = $_POST['nome'];

            try {
                //enviar dados para o banco
                $cadastro = Marca::cadastrarMarca($marca);
                var_dump($cadastro);
                if ($cadastro) {
                    $urlMarca = array();
                    $pagina = 'marca';
                    $urlMarca['pagina'] = $pagina;
                    Core::start($urlMarca);                              
                }
            } catch (Exception $e) {
                echo '<script language="javascript">';
                echo 'alert("'.$e->getMessage().'");';
                echo 'location.href = "http://localhost/blockbuster/?pagina=marca&metodo=cadastrarMarca"';
                echo '</script>';
            }

        }

        public function deletarMarca($id) 
        {
            //chamar a model para deletar
            var_dump($id);
            $successoDeletar = Marca::deletar($id);

            //retornar a pagina index de categoria
            echo '<script language="javascript">';
            echo 'location.href = "http://localhost/blockbuster/?pagina=marca"';
            echo '</script>';
        }

    //fechamento da classe
    }
?>