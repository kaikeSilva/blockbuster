<?php

class Imagem {


    static function cadastrarImagem() {

        /*pegar a conexão com o banco de dados para interagir com o banco*/
        $con = Connection::getConn();
          
        //testar se existem categorias cadastradas com o mesmo nome    
        if(isset($_FILES['arquivo'])){

            //pegar extensão do arquivo
            $extensao = strtolower(substr($_FILES['arquivo']['name'],-4));
            //criar nome para o arquivo
            $nome = md5(time()).$extensao;
            //colocar em diretorio
            $diretorio = 'imagens/carro/';

            move_uploaded_file($_FILES['arquivo']['tmp_name'],$diretorio.$nome);

            //inserir imagem
            $sql = "INSERT INTO  img_carro
            (arquivo)
            VALUES ( :nome);
            ";

            $sql = $con->prepare($sql);
            $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
            $resultado = $sql->execute();
            $ultimoId = $con->lastInsertId();

            return $ultimoId;
        } 
        return 401;
    }

    public static function retornarNome($id) {
        $con = Connection::getConn();

        $sql = "SELECT arquivo FROM img_carro
        where img_carro.imagem_id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $id, PDO::PARAM_STR);
        $sql->execute();

        /*
            apos executar a query armazenar as linhas vindas do banco
            em um array, se o array estiver vazio sinalizar isso para a controller.
        */
        $resultado = array();

        while($row = $sql->fetchObject('Imagem')) {
            $resultado[] = $row;
        }

        return $resultado;
    }
    
}

?>