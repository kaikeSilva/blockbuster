<?php
    //criar um objeto singleton para interagir com o banco de dados e retornar uma conexão
    abstract class Connection
    {
        private static $conn;

        public static function getConn()
        {
            //quando ja existe objeto conexao instanciado ele não cria outro
            if(self::$conn == null) {
                self::$conn = new PDO('mysql: host=localhost; dbname=blockbuster;','root','');
            }
            return self::$conn;

        }
    }