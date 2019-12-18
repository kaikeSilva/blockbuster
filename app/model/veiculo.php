<?php

class Veiculo {

    public static function selecionaTodos()
    {
        /*pegar a conexão com o banco de dados para interagir com o banco
        pedindo os dados dos veicuos cadastrados*/
        $con = Connection::getConn();

        $sql = "SELECT * FROM veiculo
        ORDER BY veiculo_id DESC";

        $sql = $con->prepare($sql);
        $sql->execute();

        /*
            apos executar a query armazenar as linhas vindas do banco
            em um array, se o array estiver vazio sinalizar isso para a controller.
        */
        $resultado = array();

        while($row = $sql->fetchObject('Veiculo')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro");
        }

        return $resultado;
    }
    static function alterarImagem($idVeiculo,$idImagem) {
        /*pegar a conexão com o banco de dados para interagir com o banco
        */
            $con = Connection::getConn();
            try {
                //alterar a imagem do veiculo
                $sql = "UPDATE veiculo
                SET imagem_id = :idImagem
                WHERE veiculo.veiculo_id = :idVeiculo
                ";

                //trocar as variaveis no sql
                $sql = $con->prepare($sql);
                $sql->bindValue(':idImagem', $idImagem, PDO::PARAM_STR);
                $sql->bindValue(':idVeiculo', $idVeiculo, PDO::PARAM_STR);
                $resultado = $sql->execute();

            } catch (Exception $th) {
                var_dump($th);
            }
        

            return $resultado;
    }

    static function retornarVeiculo($id) {
        /*pegar a conexão com o banco de dados para interagir com o banco
        pedindo os dados do veiculo que contem o iod passado*/
        $con = Connection::getConn();

        $sql = "SELECT * FROM veiculo
        WHERE veiculo.veiculo_id = :id";

        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $id, PDO::PARAM_STR);
        $sql->execute();

        $resultado = array();

        while($row = $sql->fetchObject('Veiculo')) {
            $resultado[] = $row;
        }

        return $resultado;
    }

    //atualizar veiculo
    static function alterarVeiculo ($dados) {
        /*pegar a conexão com o banco de dados para interagir com o banco
            e alterar o dado do modelo com o id correspondente*/
            $con = Connection::getConn();
            try {
                //alterar veiculo
                $sql = "UPDATE veiculo
                SET 
                placa = :placa,
                chassi = :chassi,
                renavan = :renavan,
                preco_compra = :preco_compra,
                preco_venda = :preco_venda,
                quilometragem = :quilometragem,
                situacao = :situacao,
                modelo_id = :modelo_id
                WHERE veiculo.veiculo_id = :veiculo_id
                ";

                //trocar as variaveis no sql
                $sql = $con->prepare($sql);
                $sql->bindValue(':placa', $dados['placa'], PDO::PARAM_STR);
                $sql->bindValue(':chassi', $dados['chassi'], PDO::PARAM_STR);
                $sql->bindValue(':renavan', $dados['renavan'], PDO::PARAM_STR);
                $sql->bindValue(':preco_compra', $dados['preco_compra'], PDO::PARAM_STR);
                if(empty($dados['preco_venda']) ){
                    $sql->bindValue(':preco_venda', null, PDO::PARAM_STR);
                } else {
                    $sql->bindValue(':preco_venda', $dados['preco_venda'], PDO::PARAM_STR);
                }
                $sql->bindValue(':quilometragem', $dados['quilometragem'], PDO::PARAM_STR);
                $sql->bindValue(':situacao', $dados['situacao'], PDO::PARAM_STR);
                $sql->bindValue(':modelo_id', $dados['modelo_id'], PDO::PARAM_STR);
                $sql->bindValue(':veiculo_id', $dados['veiculo_id'], PDO::PARAM_STR);
                $resultado = $sql->execute();

            } catch (Exception $th) {
                var_dump($th);
            }
        

            return $resultado;
    }

    static function cadastrarVeiculo($veiculo) {
        /*pegar a conexão com o banco de dados para interagir com o banco*/
        $con = Connection::getConn();
        try 
        {
            //futura implementação de restrição ao inserir veiculo
            if(true){

                //inserir o veiculo
                $sql = "INSERT INTO  veiculo
                ( modelo_id, placa, chassi, 
                renavan, preco_compra, preco_venda, quilometragem, situacao, imagem_id)
                VALUES ( :modelo, :placa, :chassi,
                :renavan, :preco_compra, :preco_venda, :quilometragem, :situacao, :imagem)
                ";

                $sql = $con->prepare($sql);
                $sql->bindValue(':modelo', $veiculo['modelo'], PDO::PARAM_STR);
                $sql->bindValue(':placa', $veiculo['placa'], PDO::PARAM_STR);
                $sql->bindValue(':renavan', $veiculo['renavan'], PDO::PARAM_STR);
                $sql->bindValue(':chassi', $veiculo['chassi'], PDO::PARAM_STR);
                $sql->bindValue(':preco_compra', $veiculo['preco_compra'], PDO::PARAM_STR);

                if(empty($veiculo['preco_venda']) ){
                    $sql->bindValue(':preco_venda', null, PDO::PARAM_STR);
                } else {
                    $sql->bindValue(':preco_venda', $veiculo['preco_venda'], PDO::PARAM_STR);
                }

                $sql->bindValue(':quilometragem', $veiculo['quilometragem'], PDO::PARAM_STR);
                $sql->bindValue(':situacao', $veiculo['situacao'], PDO::PARAM_STR);
                $sql->bindValue(':imagem', $veiculo['imagem'], PDO::PARAM_STR);
                
                $resultado = $sql->execute();
                return $resultado;

            } else {
                throw new Exception("valor repitido");
            }
            
        } catch (PDOException $th) {
            return $resultado;
            echo($th);
        }

        return $resultado;
    }

    static function deletar($id) {
            
        $con = Connection::getConn();

        //deletar categoria
        $sql = "DELETE FROM  veiculo
        WHERE veiculo.veiculo_id = :id";

        $sql = $con->prepare($sql);
        $sql->bindValue(':id',$id , PDO::PARAM_STR);
        
        $resultado = $sql->execute();

        return true;
    }

    static function mudarSituacao($id) {
            
        $con = Connection::getConn();

        //deletar categoria
        $sql = "UPDATE veiculo
        SET 
        situacao = 'indisponivel'
        WHERE veiculo.veiculo_id = :veiculo_id
        ";

        $sql = $con->prepare($sql);
        $sql->bindValue(':veiculo_id',$id , PDO::PARAM_STR);
        $resultado = $sql->execute();

        return true;
    }
}

?>