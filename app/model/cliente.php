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
            left join pessoa_j
            on pessoa_j.pessoa_id = pessoa.id_pessoa
            left join pessoa_f
            on pessoa_f.pessoa_id = pessoa.id_pessoa
            where pessoa.id_pessoa = :id;";

            /*$sql = "SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_j
            on pessoa_j.pessoa_id = pessoa.id_pessoa
            where pessoa_j.pessoa_id = :id
            union all
            SELECT * FROM pessoa
            join endereco
            on endereco.id_endereco = pessoa.p_endereco
            join pessoa_f
            on pessoa_f.pessoa_id = pessoa.id_pessoa
            where pessoa_f.pessoa_id = :id;
            ";

            */
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

        static function alterarCliente($pessoa,$endereco,$pessoaTipo,$tipo) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            $con = Connection::getConn();
            try {
                    //inserir pessoa primeiro

                $sql = "UPDATE pessoa
                SET nome = :nome,
                telefone_1 = :telefone_1,
                telefone_2 = :telefone_2,
                email = :email
                WHERE pessoa.id_pessoa = :id
                ";

                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $pessoa['nome'], PDO::PARAM_STR);
                $sql->bindValue(':telefone_1', $pessoa['telefone_1'], PDO::PARAM_STR);
                $sql->bindValue(':telefone_2', $pessoa['telefone_2'], PDO::PARAM_STR);
                $sql->bindValue(':email', $pessoa['email'] , PDO::PARAM_STR);
                $sql->bindValue(':id', $pessoa['id_pessoa'], PDO::PARAM_STR);
                $resultado = $sql->execute();

            //inserir endereco
            $sql = "UPDATE endereco
                SET logradouro = :logradouro,
                cep = :cep,
                bairro = :bairro,
                cidade = :cidade,
                numero = :numero,
                complemento = :complemento,
                estado = :estado
                WHERE endereco.id_endereco = :id
                ";

                $sql = $con->prepare($sql);
                $sql->bindValue(':logradouro',$endereco['logradouro'] , PDO::PARAM_STR);
                $sql->bindValue(':cep', $endereco['cep'], PDO::PARAM_STR);
                $sql->bindValue(':bairro', $endereco['bairro'], PDO::PARAM_STR);
                $sql->bindValue(':cidade', $endereco['cidade'], PDO::PARAM_STR);
                $sql->bindValue(':numero', $endereco['numero'] , PDO::PARAM_STR);
                $sql->bindValue(':complemento', $endereco['complemento'], PDO::PARAM_STR);
                $sql->bindValue(':estado', $endereco['estado'], PDO::PARAM_STR);
                $sql->bindValue(':id', $endereco['id_endereco'], PDO::PARAM_STR);
                $resultado = $sql->execute();
                
            //inserir pf se cpf ou pessoa juridica se cnpj
                if($tipo == 'f') {
                    $sql = "UPDATE pessoa_f
                    SET rg = :rg
                    WHERE pessoa_f.cpf = :id
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':rg', $pessoaTipo['rg'], PDO::PARAM_STR);
                    $sql->bindValue(':id', $pessoaTipo['cpf'], PDO::PARAM_STR);
                    $resultado = $sql->execute();

                } else {
                    $sql = "UPDATE pessoa_j
                    SET razao_social = :razao_social
                    WHERE pessoa_j.cnpj = :id
                    ";
                    $sql = $con->prepare($sql);
                    $sql->bindValue(':razao_social', $pessoaTipo['razao_social'], PDO::PARAM_STR);
                    $sql->bindValue(':id', $pessoaTipo['cnpj'], PDO::PARAM_STR);
                    $resultado = $sql->execute();

                }

            } catch (Exception $th) {
                var_dump($th);
            }
           

            
            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }

        static function cadastrarCliente($pessoa,$endereco,$pessoaTipo,$tipo) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            var_dump($pessoaTipo);
            var_dump($pessoa);
            var_dump($endereco);
            var_dump($tipo);
            $con = Connection::getConn();
            try {

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
                
                var_dump('inserção endereço');
                var_dump($resultado);
                var_dump($ultimoId);


                //inserir pessoa 
                $sql = "INSERT INTO  pessoa
                (id_pessoa, p_endereco, nome, telefone_1, telefone_2, email)
                VALUES (NULL, :ultimoId , :nome, :telefone_1, :telefone_2, :email)
                ";

                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $pessoa['nome'], PDO::PARAM_STR);
                $sql->bindValue(':telefone_1', $pessoa['telefone_1'], PDO::PARAM_STR);
                $sql->bindValue(':telefone_2', $pessoa['telefone_2'], PDO::PARAM_STR);
                $sql->bindValue(':email', $pessoa['email'] , PDO::PARAM_STR);
                $sql->bindValue(':ultimoId',  $ultimoId, PDO::PARAM_STR);
                
                $resultado = $sql->execute();
                $ultimoId = $con->lastInsertId();
                
                var_dump('inserção pessoa');
                var_dump($resultado);
                var_dump($ultimoId);
                
            //inserir pf se cpf ou pessoa juridica se cnpj
                if($tipo == 'f') {
                    $sql = "INSERT INTO  pessoa_f
                    (pessoa_id, cpf, rg)
                    VALUES (:ultimoId, :cpf, :rg)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':cpf', $pessoaTipo['cpf'], PDO::PARAM_STR);
                    $sql->bindValue(':rg', $pessoaTipo['rg'], PDO::PARAM_STR);
                    $sql->bindValue(':ultimoId', $ultimoId, PDO::PARAM_STR);
                    
                    $resultado = $sql->execute();
                    $ultimoId = $con->lastInsertId();
                    
                    var_dump('inserção pessoa fisica');
                    var_dump($resultado);
                    var_dump($ultimoId);

                } else {
                    $sql = "INSERT INTO pessoa_j
                    (pessoa_id, cnpj, razao_social)
                    VALUES (:ultimoId, :cnpj, :razao_social)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':razao_social', $pessoaTipo['razao_social'], PDO::PARAM_STR);
                    $sql->bindValue(':cnpj', $pessoaTipo['cnpj'], PDO::PARAM_STR);
                    $sql->bindValue(':ultimoId', $ultimoId, PDO::PARAM_STR);
                   
                    var_dump('inserção pessoa juridica');
                    $resultado = $sql->execute();
                    $ultimoId = $con->lastInsertId();
                    var_dump($resultado);
                    var_dump($ultimoId);

                }

                return $resultado;

            } catch (PDOException $th) {
                return $resultado;
                echo($th);
            }
           

            
            if (!$resultado) {
                throw new Exception("Não foi possibel inserir no banco de dados");
                return $resultado;
            }

            return $resultado;
        }

        static function deletar($id) {
            
            var_dump('dentro da model deletar');
            var_dump($id);
            $con = Connection::getConn();

            //deletar endereco
            $sql = "DELETE FROM  pessoa
            WHERE pessoa.id_pessoa = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            
            $resultado = $sql->execute();

            var_dump($resultado);

            return true;
        }
    }