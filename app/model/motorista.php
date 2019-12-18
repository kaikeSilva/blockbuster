<?php
    //criar uma classe model para interagir com o banco de dados e retornar os dados de cliente
    class Motorista 
    {
        public static function selecionaTodos()
        {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo os dados do cliente*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM motorista
            join endereco
            on endereco.id_endereco = motorista.id_endereco
            ORDER BY id_motorista DESC";

            $sql = $con->prepare($sql);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Motorista')) {
                $resultado[] = $row;
            }

            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }

        static function retornarMotorista($id) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM Motorista
            join endereco
            on endereco.id_endereco = motorista.id_endereco
            where motorista.id_motorista = :id;";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id', $id, PDO::PARAM_STR);
            $sql->execute();
            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Motorista')) {
                $resultado[] = $row;
            }

            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }

        static function cadastrarMotorista($motorista,$endereco) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            try{
            $con = Connection::getConn();     

                //if($podeInserir){
                    //inserir endereco
                    $sql = "INSERT INTO  endereco
                    (logradouro, cep, bairro, cidade, numero, complemento, estado)
                    VALUES ( :logradouro , :cep, :bairro, :cidade, :numero, :complemento, :estado)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':logradouro',$endereco['logradouro'] , PDO::PARAM_STR);
                    $sql->bindValue(':cep', $endereco['cep'], PDO::PARAM_STR);
                    $sql->bindValue(':bairro', $endereco['bairro'], PDO::PARAM_STR);
                    $sql->bindValue(':cidade', $endereco['cidade'], PDO::PARAM_STR);
                    $sql->bindValue(':numero', $endereco['numero'] , PDO::PARAM_STR);
                    $sql->bindValue(':complemento', $endereco['complemento'], PDO::PARAM_STR);
                    $sql->bindValue(':estado', $endereco['estado'], PDO::PARAM_STR);

                    $resultado = $sql->execute();
                    $ultimoId = $con->lastInsertId();

                    //inserir motorista
                    $sql = "INSERT INTO  motorista
                    (id_motorista, id_endereco, nome, cpf, rg, telefone_1, telefone_2, email, numeroRegistro, categoria, dataValidade, id_imagem)
                    VALUES (NULL, :ultimoId , :nome, :cpf, :rg, :telefone_1, :telefone_2, :email, :numeroRegistro, :categoria, :dataValidade, :imagem)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':nome', $motorista['nome'], PDO::PARAM_STR);
                    $sql->bindValue(':cpf', $motorista['cpf'], PDO::PARAM_STR);
                    $sql->bindValue(':rg', $motorista['rg'], PDO::PARAM_STR);
                    $sql->bindValue(':telefone_1', $motorista['telefone_1'], PDO::PARAM_STR);
                    $sql->bindValue(':telefone_2', $motorista['telefone_2'], PDO::PARAM_STR);
                    $sql->bindValue(':email', $motorista['email'] , PDO::PARAM_STR);
                    $sql->bindValue(':numeroRegistro', $motorista['numeroRegistro'], PDO::PARAM_STR);
                    $sql->bindValue(':categoria', $motorista['categoria'], PDO::PARAM_STR);
                    $sql->bindValue(':dataValidade', $motorista['dataValidade'], PDO::PARAM_STR);
                    $sql->bindValue(':imagem', $motorista['imagem'], PDO::PARAM_STR);
                    $sql->bindValue(':ultimoId',  $ultimoId, PDO::PARAM_STR);
                    var_dump($motorista);
                    $resultado = $sql->execute();
                /*} else {
                    throw new Exception("cpf/cnpj repitidos");
                }*/
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        static function deletar($id) {
            
            $con = Connection::getConn();

            //deletar pessoa
            $sql = "DELETE FROM  motorista
            WHERE pessoa.id_pessoa = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            
            $resultado = $sql->execute();


            return true;
        }

    }