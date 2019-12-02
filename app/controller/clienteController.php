<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class ClienteController 
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
                $template = $twig->load('cliente.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $parametros['clientes'] = $colecaoClientes;
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (Exception $e) {
                echo $e->getMessage();
            } finally {
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('cliente.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $parametros['clientes'] = 0;
                $conteudo = $template->render($parametros);

                echo $conteudo;
            }

            
        }

        public function cadastrarCliente()
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
                $template = $twig->load('cadastrarCliente.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            
        }

        public function alterarCliente() 
        {

            //preparar os dados de pessoa
            $pessoa = array();
            $pessoa['id_pessoa'] = $_POST['id_pessoa'];
            $pessoa['nome'] = $_POST['nome'];
            $pessoa['telefone_1'] = $_POST['telefone_1'];
            $pessoa['telefone_2'] = $_POST['telefone_2'];
            $pessoa['email'] = $_POST['email'];

            //preparar os dados do endereço
            $endereco = array();
            $endereco['id_endereco'] = $_POST['p_endereco'];
            $endereco['logradouro'] = $_POST['logradouro'];
            $endereco['cep'] = $_POST['cep'];
            $endereco['bairro'] = $_POST['bairro'];
            $endereco['cidade'] = $_POST['cidade'];
            $endereco['numero'] = $_POST['numero'];
            $endereco['complemento'] = $_POST['complemento'];
            $endereco['estado'] = $_POST['estado'];
            
             
            


            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                //preparar dados de pessoa fisica ou juridica
                if ( $_POST['tipo'] == 'j'){
                    $pessoaJ = array();
                    $pessoaJ['cnpj'] = $_POST['cpfcnpj'];
                    $pessoaJ['razao_social'] = $_POST['razao_social'];
                    $update = Cliente::alterarCliente($pessoa,$endereco,$pessoaJ,'j');

                } else {
                    $pessoaF = array();
                    $pessoaF['cpf'] = $_POST['cpfcnpj'];
                    $pessoaF['rg'] = $_POST['rg'];
                    $update = Cliente::alterarCliente($pessoa,$endereco,$pessoaF,'f');

                }

                if ($update ) {
                    $url['pagina'] = 'cliente';
                    $url['metodo'] = 'index';
                    Core::start($url);
                } else {
                    $mensagem = "não inserido no banco de dados";
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function realizarCadastro() 
        {
            var_dump($_POST);
            //preparar os dados de pessoa
            $pessoa = array();
            $pessoa['nome'] = $_POST['nome'];
            $pessoa['telefone_1'] = $_POST['telefone_1'];
            $pessoa['telefone_2'] = $_POST['telefone_2'];
            $pessoa['email'] = $_POST['email'];

            //preparar os dados do endereço
            $endereco = array();
            $endereco['logradouro'] = $_POST['logradouro'];
            $endereco['cep'] = $_POST['cep'];
            $endereco['bairro'] = $_POST['bairro'];
            $endereco['cidade'] = $_POST['cidade'];
            $endereco['numero'] = $_POST['numero'];
            $endereco['complemento'] = $_POST['complemento'];
            $endereco['estado'] = $_POST['estado'];
            
             
            


            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                //preparar dados de pessoa fisica ou juridica
                if ( $_POST['tipo'] == 'j'){
                    $pessoaJ = array();
                    $pessoaJ['cnpj'] = $_POST['cpfcnpj'];
                    $pessoaJ['razao_social'] = $_POST['razao_social'];
                    $update = Cliente::cadastrarCliente($pessoa,$endereco,$pessoaJ,'j');

                } else {
                    $pessoaF = array();
                    $pessoaF['cpf'] = $_POST['cpfcnpj'];
                    $pessoaF['rg'] = $_POST['rg'];
                    $update = Cliente::cadastrarCliente($pessoa,$endereco,$pessoaF,'f');

                }

                if ($update ) {

                    var_dump($update);
                    $url['pagina'] = 'cliente';
                    $url['metodo'] = 'index';
                    Core::start($url);
                    var_dump($update);

                } else {
                    
                    $mensagem = "não inserido no banco de dados";
                    var_dump($update);
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        
    }