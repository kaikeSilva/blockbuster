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
                $colecaoMarcas = Marca::selecionaTodos();
                $colecaoCategorias = Categoria::selecionaTodos();
                

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

                //array com chaves parametros das marcas para subtituir na view
                $parametros['marcas'] = $colecaoMarcas;
                $conteudo = $template->render($parametros);
                
                //array com chaves parametros das marcas para subtituir na view
                $parametros['categorias'] = $colecaoCategorias;
                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('modelo.html');

                echo $conteudo;
            } 

            
        }
        
        public function alterarModelo() 
        {
            //buscar o id da marca e da categoria do modelo
            $nomeMarca = $_POST['marca'];
            $nomeCategoria = $_POST['categoria'];

            $marcaId = Marca::retornaId($nomeMarca);
            $categoriaId = Categoria::retornaId($nomeCategoria);
            
            //preparar os dados de modelo
            $modelo = array();
            $modelo['nome'] = $_POST['nome'];
            $modelo['qtd_passageiros'] = $_POST['qtd_passageiros'];
            $modelo['ano_fabricacao'] = $_POST['ano_fabricacao'];
            $modelo['ano_modelo'] = $_POST['ano_modelo'];
            $modelo['combustivel'] = $_POST['combustivel'];
            $modelo['potencia'] = $_POST['potencia'];
            $modelo['porta_malas'] = $_POST['porta_malas'];
            $modelo['marca_id'] = $marcaId[0]->marca_id;
            $modelo['modelo_id'] = $_POST['modelo_id'];
            $modelo['categoria_id'] = $categoriaId[0]->categoria_id;
            

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
                $marcas = Marca::selecionaTodos();
                $categorias = Categoria::selecionaTodos();
                

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

                //carregar marcas para o select
                $parametros = array();
                $parametros['marcas'] = $marcas;
                //carregar categorias para o select
                $parametros['categorias'] = $categorias;
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
            $modelo['marca_id'] = $_POST['marca_id'];
            $modelo['categoria_id'] = $_POST['categoria_id'];

            try {
                //enviar dados para o banco
                $update = Modelo::cadastrarModelo($modelo);

                $url['pagina'] = 'modelo';
                Core::start($url);
            } catch (Exception $e) {
                //mostrar erro na tela
                echo '<script language="javascript">';
                echo 'alert("'.$e->getMessage().'");';
                echo 'location.href = "http://localhost/blockbuster/?pagina=modelo&metodo=cadastrarModelo"';
                echo '</script>';
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