<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class MotoristaController 
    {   //carrega pagina inicial de cliente
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco
                $colecaoMotoristas = Motorista::selecionaTodos();

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
                $template = $twig->load('motorista.html');

                //array com chaves parametros para substituir na view
                $parametros = array();
                $parametros['motoristas'] = $colecaoMotoristas;
                $conteudo = $template->render($parametros);
                echo $conteudo;

            } catch (Exception $e) {
                echo $e->getMessage();
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('motorista.html');
                $conteudo = $template->render();
                echo $conteudo;
            } 

            
        }
        //carrega a pagina de cadastro
        public function cadastrarMotorista  ()
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
                $template = $twig->load('cadastrarMotorista.html');

                //array com chaver parametros para substituir na view
                $parametros = array();
                $conteudo = $template->render($parametros);

                echo $conteudo;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            
        }

        //envia os dados para o banco de dados
        public function realizarCadastro() 
        {
        try {
            //preparar os dados de pessoa
            $motorista = array();
            $motorista['nome'] = $_POST['nome'];
            $motorista['cpf'] = $_POST['cpf'];
            $motorista['rg'] = $_POST['rg'];
            $motorista['telefone_1'] = $_POST['telefone_1'];
            $motorista['telefone_2'] = $_POST['telefone_2'];
            $motorista['email'] = $_POST['email'];
            $motorista['numeroRegistro'] = $_POST['numeroRegistro'];
            $motorista['categoria'] = $_POST['categoria'];
            $motorista['dataValidade'] = $_POST['dataValidade'];

            //preparar imagem
            $idImagem = ImagemCarteira::cadastrarImagem($_FILES);
            $motorista['imagem'] = $idImagem;

            //preparar os dados do endereço
            $endereco = array();
            $endereco['logradouro'] = $_POST['logradouro'];
            $endereco['cep'] = $_POST['cep'];
            $endereco['bairro'] = $_POST['bairro'];
            $endereco['cidade'] = $_POST['cidade'];
            $endereco['numero'] = $_POST['numero'];
            $endereco['complemento'] = $_POST['complemento'];
            $endereco['estado'] = $_POST['estado'];

            $update = Motorista::cadastrarMotorista($motorista, $endereco);

                $url['pagina'] = 'motorista';
                $url['metodo'] = 'index';
                Core::start($url);
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
        } catch (Exception $e) {
            $url['pagina'] = 'motorista';
            $url['metodo'] = 'cadastrarMotorista';
            Core::start($url);
        }
    }

        /*public function deletarCliente($id) 
        {
            $successoDeletar = Cliente::deletar($id);

            if ($successoDeletar ) {

                $url['pagina'] = 'cliente';
                $url['metodo'] = 'index';
                Core::start($url);

            } else {
                
                $mensagem = "não deletado";
            }
            
            return true;
        }*/
}