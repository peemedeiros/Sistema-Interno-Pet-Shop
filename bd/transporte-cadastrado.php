<?php

$idtransporte = (int) 0;

if(isset($_POST['btn-confirmar-transporte'])){

    require_once('conexao.php');
    $conexao = conexaoMysql();
    date_default_timezone_set('America/Sao_Paulo');

    $idtransporte = $_POST['idtransporte'];
    $cliente = $_POST['txt-transporte-cliente'];
    $telefone = $_POST['txt-transporte-telefone'];
    $celular = $_POST['txt-transporte-celular'];
    $forma_pagamento = $_POST['slt-pagamento'];

    //convertendo o numero que foi colocado como valor, no formato suportado pelo banco de dados
    $valor = explode(',', $_POST['valorTransport']);
    $valor = $valor[0].".".$valor[1];

    //convertendo o numero que foi colocado como valorServicos, no formato suportado pelo banco de dados
    $valorServicos = explode(',', $_POST['valorServicos']);
    $valorServicos = $valorServicos[0].".".$valorServicos[1];

    $cep = $_POST['txt-transporte-cep'];
    $rua = $_POST['txt-transporte-rua'];
    $numero = $_POST['txt-transporte-numero'];
    $bairro = $_POST['txt-transporte-bairro'];
    $cidade = $_POST['txt-transporte-cidade'];
    $estado = $_POST['txt-transporte-estado'];

    if(isset($_POST['dataAtual']))
    {
        $data = date('Y-m-d');
    }else{
        $data = $_POST['dataTransporte'];
    }

    $horario = $_POST['horarioTransporte'];
    

    if($idtransporte != 0)
    {
        $sql = "update transporte set 
        nome_cliente = '".$cliente."',
        telefone = '".$telefone."',
        celular = '".$celular."',
        id_formapagamento = ".$forma_pagamento.",
        valor_transporte = ".$valor.",
        valor_servicos = ".$valorServicos.",
        cep = '".$cep."',
        logradouro = '".$rua."',
        numero = '".$numero."',
        bairro = '".$bairro."',
        cidade = '".$cidade."',
        estado = '".$estado."',
        data_transporte = '".$data."',
        horario_transporte = '".$horario."' 
        where id =".$idtransporte;

        if(mysqli_query($conexao, $sql)){
            header('location: ../agendamento-transporte.php');
        }else{
            echo($sql);
        }
    }else{
        $sql = "insert into transporte 
        (nome_cliente, telefone, celular,
        id_formapagamento, valor_transporte, valor_servicos
        cep, logradouro, numero, bairro,
        cidade, estado, data_transporte, 
        horario_transporte) 
        values ('".$cliente."', '".$telefone."',
        '".$celular."', ".$forma_pagamento.", ".$valor.", ".$valorServicos.",
        '".$cep."', '".$rua."', '".$numero."', '".$bairro."',
        '".$cidade."', '".$estado."', '".$data."', '".$horario."')";

        if(mysqli_query($conexao, $sql)){
            header('location: ../agendamento-transporte.php');
        }else{
            echo($sql);
        }
    }
}


?>