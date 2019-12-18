<?php
    //classe para retornar o html de home e dados
    //o controller se comunica com as views e com as models
    class ImagemCarteiraController 
    {
        public function index()
        {
            /*
                Controller faz a solicitação para a model enviar os dados do banco,
                mostrar dados recebidos ou a menssagem de erro vinda da model.
            */
            try {
                //solicitação ao banco


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
                $template = $twig->load('imagemCarteira.html');

                //renderizar o template, parametros de render seriam dados vindos de alguma model
                echo $template->render();

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            
        }

        public function cadastrarImagem() {
            var_dump($_FILES);
            $resultado = ImagemCarteira::cadastrarImagem();

            var_dump($resultado);
        }
    }

?>