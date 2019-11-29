<?php
    //criar uma classe model para interagir com o banco de dados e retornar os dados de cliente
    class Cliente 
    {
        public static function selecionaTodos()
        {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo os dados do cliente*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_f
            on pessoa_f.pessoa_id = pessoa.id_pessoa
            union 
            SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_j
            on pessoa_j.pessoa_id = pessoa.id_pessoa
            ORDER BY id_pessoa DESC";

            $sql = $con->prepare($sql);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Cliente')) {
                $resultado[] = $row;
            }

            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }

        static function retornarCliente($id) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_f
            on pessoa_f.pessoa_id = pessoa.id_pessoa
            where pessoa_f.pessoa_id = :id
            union 
            SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_j
            on pessoa_j.pessoa_id = pessoa.id_pessoa
            where pessoa_j.pessoa_id = :id;";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id', $id, PDO::PARAM_STR);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Cliente')) {
                $resultado[] = $row;
            }

            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }
    }