<?php

    function conexaoMysql(){
        
        $server = (string) "localhost"; //local de instalação do banco de dados

        $user = (string) "root"; //usuario para conexão com o banco de dados

        $password = (string) ""; //senha para conexão com o banco de dados

        $database = (string) "augustospet"; //nome do database

        $conexao = mysqli_connect($server, $user, $password, $database);
        
        return $conexao;
    }
    
?>