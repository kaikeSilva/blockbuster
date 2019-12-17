<?php
    class Locacao 
    {
        public static function selecionaTodos()
        {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo os dados da marca*/
            $con = Connection::getConn();

            $sql = "SELECT * FROM veiculo
            JOIN modelo
            ON veiculo.modelo_id = modelo.modelo_id
            JOIN img_carro
            ON veiculo.imagem_id = img_carro.imagem_id
            ";

            $sql = $con->prepare($sql);
            $sql->execute();

            /*
                apos executar a query armazenar as linhas vindas do banco
                em um array, se o array estiver vazio sinalizar isso para a controller.
            */
            $resultado = array();

            while($row = $sql->fetchObject('Locacao')) {
                $resultado[] = $row;
            }
            
            if (!$resultado) {
                throw new Exception("Não foi encontrado nenhum registro");
            }

            

           return $resultado;
        }

        static function alterarMarca($marca) {
            /*pegar a conexão com o banco de dados para interagir com o banco
            pedindo o dado do cliente com o id correspondente*/
            $con = Connection::getConn();
            try {
                //alterar a categoria
                $sql = "UPDATE marca
                SET nome = :nome
                WHERE marca.marca_id = :id
                ";

                //trocar as variaveis no sql
                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $marca['nome'], PDO::PARAM_STR);
                $sql->bindValue(':id', $marca['marca_id'], PDO::PARAM_STR);
                $resultado = $sql->execute();

            } catch (Exception $th) {
                var_dump($th);
            }
        

            return $resultado;
        }

        static function cadastrarMarca($marca) {
            /*pegar a conexão com o banco de dados para interagir com o banco*/
            $con = Connection::getConn();
            //testar se existem categorias cadastradas com o mesmo nome           
            $podeInserir = Marca::testarRepitido($marca['nome']);

            if($podeInserir){

                //inserir pf se cpf ou pessoa juridica se cnpj
                $sql = "INSERT INTO  marca
                ( nome)
                VALUES ( :nome)
                ";

                $sql = $con->prepare($sql);
                $sql->bindValue(':nome', $marca['nome'], PDO::PARAM_STR);
                
                $resultado = $sql->execute();

                return $resultado;

            } else {
                
                throw new Exception("nome da marca ja existe");
                return false;
            }
        
        }

        private static function testarRepitido($nome)
        {
            /*pegar a conexão com o banco de dados para interagir*/
            $con = Connection::getConn();
            
            //verificar pf se cpf ou pessoa juridica se cnpj
            $sql = "SELECT * FROM marca
            where marca.nome = :nome;";

            $sql = $con->prepare($sql);
            $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
            $sql->execute();
            
            $resultado = array();

            while($row = $sql->fetchObject('Marca')) {
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

        static function deletar($id) 
        {
            
            $con = Connection::getConn();

            //deletar categoria
            $sql = "DELETE FROM  marca
            WHERE marca.marca_id = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            
            $resultado = $sql->execute();

            return $resultado;
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