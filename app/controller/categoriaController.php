<?php
    class CategoriaController {
        // pagina principal de categoria
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $colecaoClientes = Categoria::selecionaTodos();

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
                $template = $twig->load('categoria.html');

                //array com chaves parametros para substituir na view
                $parametros = array();
                $parametros['categorias'] = $colecaoClientes;
                $conteudo = $template->render($parametros);
                echo $conteudo;
                
                //caso lançado algum erro, exibir a mensagem e carregar a pagina sem os dados
            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('categoria.html');
                $conteudo = $template->render();
                echo $conteudo;
            } 

            
        }

        public function alterarCategoria() 
        {
            //preparar os dados de pessoa
            $categoria = array();
            $categoria['nome'] = $_POST['nome'];
            $categoria['categoria_id'] = $_POST['categoria_id'];
            $categoria['valor'] = $_POST['valor'];
            
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação a model para insirir
                $update = Categoria::alterarCategoria($categoria);

                $url['pagina'] = 'categoria';
                $url['metodo'] = 'index';
                Core::start($url);

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function cadastrarCategoria()
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
                $template = $twig->load('cadastrarCategoria.html');

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
            $categoria = array();
            $categoria['nome'] = $_POST['nome'];
            $categoria['valor'] = $_POST['valor'];

            try {
                //enviar dados para o banco
                $update = Categoria::cadastrarCategoria($categoria);

                $url['pagina'] = 'categoria';
                $url['metodo'] = 'index';
                Core::start($url);
            } catch (Exception $e) {
                //mostrar erro natela
                echo '<script language="javascript">';
                echo 'alert("ja existe categoria cadastrada com este nome");';
                echo '</script>';

                //recarregar a página
                $url['pagina'] = 'categoria';
                $url['metodo'] = 'cadastrarCategoria';
                Core::start($url);
            }

        }

        public function deletarCategoria($id) 
        {
            //chamar a model para deletar
            $successoDeletar = Categoria::deletar($id);

            //retornar a pagina index de categoria
            $url['pagina'] = 'categoria';
            $url['metodo'] = 'index';
            Core::start($url);
        }


    //fechamento da classe
    }
?>