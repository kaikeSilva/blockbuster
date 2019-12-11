<?php
    class Modelo 
    {
        public static function selecionaTodos()
        {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo os dados do modelo*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM modelo
            ORDER BY modelo_id DESC";

            $sql = $con->prepare($sql);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Categoria')) {
                $resultado[] = $row;
            }

            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            return $resultado;
        }

        static function alterarModelo($modelo) {
            
            /*pegar a conexão com o banco de dados para interagir com o banco
            e alterar o dado do modelo com o id correspondente*/
            $con = Connection::getConn();
            try {
                //alterar modelo
                $sql = "UPDATE modelo
                SET 
                nome = :nome,
                qtd_passageiros = :qtd_passageiros,
                ano_fabricacao = :ano_fabricacao,
                ano_modelo = :ano_modelo,
                combustivel = :combustivel,
                potencia = :potencia,
                porta_malas = :porta_malas,
                marca_id = :marca_id,
                categoria_id = :categoria_id
                WHERE modelo.modelo_id = :id
                ";

                //trocar as variaveis no sql
                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $modelo['nome'], PDO::PARAM_STR);
                $sql->bindValue(':qtd_passageiros', $modelo['qtd_passageiros'], PDO::PARAM_STR);
                $sql->bindValue(':ano_fabricacao', $modelo['ano_fabricacao'], PDO::PARAM_STR);
                $sql->bindValue(':ano_modelo', $modelo['ano_modelo'], PDO::PARAM_STR);
                $sql->bindValue(':combustivel', $modelo['combustivel'], PDO::PARAM_STR);
                $sql->bindValue(':potencia', $modelo['potencia'], PDO::PARAM_STR);
                $sql->bindValue(':porta_malas', $modelo['porta_malas'], PDO::PARAM_STR);
                $sql->bindValue(':marca_id', $modelo['marca_id'], PDO::PARAM_STR);
                $sql->bindValue(':id', $modelo['modelo_id'], PDO::PARAM_STR);
                $sql->bindValue(':categoria_id', $modelo['categoria_id'], PDO::PARAM_STR);
                $resultado = $sql->execute();

            } catch (Exception $th) {
                var_dump($th);
            }
        

            return $resultado;
        }

        static function cadastrarModelo($modelo) {
            /*pegar a conexão com o banco de dados para interagir com o banco*/
            $con = Connection::getConn();
            try 
            {
                //futura implementação de restrição ao inserir modelo
                if(Modelo::testarRepitido($modelo['nome'])){

                    //inserir o modelo
                    $sql = "INSERT INTO  modelo
                    ( nome, qtd_passageiros, ano_fabricacao, 
                    ano_modelo, combustivel, potencia, porta_malas, marca_id, categoria_id)
                    VALUES ( :nome, :qtd_passageiros, :ano_fabricacao,
                    :ano_modelo, :combustivel, :potencia, :porta_malas, :marca_id, :categoria_id)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':nome', $modelo['nome'], PDO::PARAM_STR);
                    $sql->bindValue(':qtd_passageiros', $modelo['qtd_passageiros'], PDO::PARAM_STR);
                    $sql->bindValue(':ano_fabricacao', $modelo['ano_fabricacao'], PDO::PARAM_STR);
                    $sql->bindValue(':ano_modelo', $modelo['ano_modelo'], PDO::PARAM_STR);
                    $sql->bindValue(':combustivel', $modelo['combustivel'], PDO::PARAM_STR);
                    $sql->bindValue(':potencia', $modelo['potencia'], PDO::PARAM_STR);
                    $sql->bindValue(':porta_malas', $modelo['porta_malas'], PDO::PARAM_STR);
                    $sql->bindValue(':marca_id', $modelo['marca_id'], PDO::PARAM_STR);
                    $sql->bindValue(':categoria_id', $modelo['categoria_id'], PDO::PARAM_STR);
                    
                    $resultado = $sql->execute();
                    return $resultado;

                } else {
                    throw new Exception("nome do modelo ja existe");
                }
                
            } catch (PDOException $th) {
                return $resultado;
                echo($th);
            }

            return $resultado;
        }

        private static function testarRepitido($nome)
        {
            /*pegar a conexão com o banco de dados para interagir*/
            $con = Connection::getConn();
            
            //verificar pf se cpf ou pessoa juridica se cnpj
            $sql = "SELECT * FROM modelo
            where modelo.nome = :nome;";

            $sql = $con->prepare($sql);
            $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
            $sql->execute();
            
            $resultado = array();

            while($row = $sql->fetchObject('Categoria')) {
                $resultado[] = $row;
            }
            
            //se a contagem de elementos de resultado for maior que zero significa que tem 
            //categoria cadastrada para o nome passado
            if (sizeOf($resultado) > 0 ) {
                return false;
            } else {
                return true;
            }

        }

        static function deletar($id) {
            
            $con = Connection::getConn();

            //deletar Modelo
            $sql = "DELETE FROM  modelo
            WHERE modelo.modelo_id = :id";
            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            
            $resultado = $sql->execute();

            return true;
        }

        public static function retornaId($nomeMarca) {
            $con = Connection::getConn();

            $sql = "SELECT marca_id FROM marca
            where marca.nome = :nome";
            $sql = $con->prepare($sql);
            $sql->bindValue(':nome', $nomeMarca, PDO::PARAM_STR);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Marca')) {
                $resultado[] = $row;
            }

            return $resultado;
        }
    }

?>