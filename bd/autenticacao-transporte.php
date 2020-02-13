<?php
    require_once('conexao.php');
    $conexao = conexaoMysql();
    
    if(isset($_SESSION)){
        session_destroy();
    }

    if(isset($_POST['btn-confirmar'])){

        $cpf_cliente = $_POST['txtcpf-agendamento'];

        $sql = "SELECT * FROM clientes WHERE celular = '".$cpf_cliente."'";

        $select = mysqli_query($conexao, $sql);

        $rsConsulta = mysqli_fetch_array($select);

        if(empty($cpf_cliente) || $cpf_cliente != $rsConsulta['celular']){
            header('location: ../error-cpf.php?mod=invalid.php');
        }else{
            if($cpf_cliente == $rsConsulta['celular']){

                $valor_transporte = (double) 0;

                $sql = "INSERT INTO transporte (id_cliente, valor_transporte)
                        VALUES (".$rsConsulta['id']." , ".$valor_transporte.")";

                if(mysqli_query($conexao, $sql)){
                    header('location: ../transporte-animais.php?idcliente='.$rsConsulta['id']);
                }
            }
        }
    }elseif(isset($_POST['btn-sem-cadastro'])){

        $valor_transporte = (double) 0;

        $sql = "INSERT INTO transporte (valor_transporte)
                VALUES (".$valor_transporte.")";

        if(mysqli_query($conexao, $sql)){
            header('location: ../transporte-animais.php');
        }

    }
?>