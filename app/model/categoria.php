<?php
    class Categoria 
    {
        public static function selecionaTodos()
        {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo os dados do cliente*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM categoria
            ORDER BY categoria_id DESC";

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

        static function alterarCategoria($categoria) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            $con = Connection::getConn();
            try {
                //alterar a categoria
                $sql = "UPDATE categoria
                SET nome = :nome,
                valor = :valor
                WHERE categoria.categoria_id = :id
                ";

                //trocar as variaveis no sql
                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $categoria['nome'], PDO::PARAM_STR);
                $sql->bindValue(':valor', $categoria['valor'], PDO::PARAM_STR);
                $sql->bindValue(':id', $categoria['categoria_id'], PDO::PARAM_STR);
                $resultado = $sql->execute();

            } catch (Exception $th) {
                var_dump($th);
            }
        

            return $resultado;
        }

        static function cadastrarCategoria($categoria) {
            /*pegar a conexão com o banco de dados para interagir com o banco*/
            $con = Connection::getConn();
            try 
            {
              
                //testar se existem categorias cadastradas com o mesmo nome           
                $podeInserir = Categoria::testarRepitido($categoria['nome']);

                if($podeInserir){

                    //inserir pf se cpf ou pessoa juridica se cnpj
                    $sql = "INSERT INTO  categoria
                    ( nome, valor)
                    VALUES ( :nome, :valor)
                    ";

                    $sql = $con->prepare($sql);
                    $sql->bindValue(':nome', $categoria['nome'], PDO::PARAM_STR);
                    $sql->bindValue(':valor', $categoria['valor'], PDO::PARAM_STR);
                    
                    $resultado = $sql->execute();

                    return $resultado;

                } else {
                    $resultado = false;
                    throw new Exception("nome da categoria ja existe");
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
            $sql = "SELECT * FROM categoria
            where categoria.nome = :nome;";

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

            //deletar categoria
            $sql = "DELETE FROM  categoria
            WHERE categoria.categoria_id = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            
            $resultado = $sql->execute();

            return true;
        }

        public static function retornaId($nomeCategoria) {
            $con = Connection::getConn();

            $sql = "SELECT categoria_id FROM categoria
            where categoria.nome = :nome";
            $sql = $con->prepare($sql);
            $sql->bindValue(':nome', $nomeCategoria, PDO::PARAM_STR);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Categoria')) {
                $resultado[] = $row;
            }

            return $resultado;
        }
    }

?>