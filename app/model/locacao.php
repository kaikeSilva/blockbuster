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

        static function cadastrarLocacao() {
            /*pegar a conexão com o banco de dados para interagir com o banco*/
            $con = Connection::getConn();
            //testar se existem categorias cadastradas com o mesmo nome           
            //$podeInserir = Marca::testarRepitido($marca['nome']);

            if(true){

                //inserir dados da locacao
                $sql = "INSERT INTO locacao 
                (   cliente_locacao,
                    veiculo_locacao, 
                    motorista_locacao,
                    dia_retirada,
                    mes_retirada, 
                    ano_retirada,
                    valor_locacao,
                    valor_seguro,
                    valor_caucao,
                    pgmto_total,
                    dia_devolucao,
                    mes_devolucao,
                    ano_devolucao
                    ) 
                    VALUES (
                    :cliente_locacao,
                    :veiculo_locacao,
                    :motorista_locacao,
                    :dia_retirada,
                    :mes_retirada,
                    :ano_retirada,
                    :valor_locacao,
                    :valor_seguro,
                    :valor_caucao,
                    :pgmto_total, 
                    :dia_devolucao, 
                    :mes_devolucao,
                    :ano_devolucao
                    )
                ";

                $sql = $con->prepare($sql);

                $sql->bindValue(':cliente_locacao', $_POST['cliente_id'], PDO::PARAM_STR);
                $sql->bindValue(':veiculo_locacao', $_POST['veiculo_id'], PDO::PARAM_STR);
                $sql->bindValue(':motorista_locacao', $_POST['motorista_id'], PDO::PARAM_STR);
                $sql->bindValue(':dia_retirada', $_POST['dia_inicio'], PDO::PARAM_STR);
                $sql->bindValue(':mes_retirada', $_POST['mes_inicio'], PDO::PARAM_STR);
                $sql->bindValue(':ano_retirada', $_POST['ano_inicio'], PDO::PARAM_STR);
                $sql->bindValue(':valor_locacao', $_POST['valor_locacao'], PDO::PARAM_STR);
                $sql->bindValue(':valor_seguro', $_POST['valor_seguro'], PDO::PARAM_STR);
                $sql->bindValue(':valor_caucao', $_POST['valor_caucao'], PDO::PARAM_STR);
                $sql->bindValue(':pgmto_total', $_POST['valor_total'], PDO::PARAM_STR);
                $sql->bindValue(':dia_devolucao', $_POST['dia_fim'], PDO::PARAM_STR);
                $sql->bindValue(':mes_devolucao', $_POST['meses_fim'], PDO::PARAM_STR);
                $sql->bindValue(':ano_devolucao', $_POST['ano_fim'], PDO::PARAM_STR);
                
                $resultado = $sql->execute();
                //inserir nova tabela cliente_locacao
                //inserir nova tabela veiculo_locacao
                //inserir nova tabela motorista_locacao

                return $resultado;

            } else {
                
                throw new Exception("nome da marca ja existe");
                return false;
            }
        
        }

        public static function consultarMotorista($id)
        {
            /*pegar a conexão com o banco de dados para interagir*/
            $con = Connection::getConn();
            
            //consultar motorista
            $sql = "SELECT *FROM  locacao
            WHERE locacao.motorista_locacao = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id',$id , PDO::PARAM_STR);
            $resultado = $sql->execute();
            
            $resultado = array();

            while($row = $sql->fetchObject('Motorista')) {
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


    }

?>