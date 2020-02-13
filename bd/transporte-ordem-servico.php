<?php

require_once('conexao.php');
$conexao = conexaoMysql();

if(isset($_POST['btn-nopet'])){

    $idTransporte = $_GET['idtransporte'];

    $sqlTransporte ="SELECT * FROM transporte WHERE id =".$idTransporte;

    $selectTransport = mysqli_query($conexao,$sqlTransporte);

    if($rsTransporte = mysqli_fetch_array($selectTransport)){

        $nome = $rsTransporte['nome_cliente'];
        $celular = $rsTransporte['celular'];
        $idPagamento = $rsTransporte['id_formapagamento'];
        $valorTransporte = $rsTransporte['valor_transporte'];
        $valorServicos = $rsTransporte['valor_servicos'];

        //endereco
        $cep = $rsTransporte['cep'];
        $logradouro = $rsTransporte['logradouro'];
        $numero = $rsTransporte['numero'];
        $bairro = $rsTransporte['bairro'];
        $cidade = $rsTransporte['cidade'];
        $estado = $rsTransporte['estado'];

        //informacoes de data e hora
        $dataTransporte = $rsTransporte['data_transporte'];
        $horarioTransporte = $rsTransporte['horario_transporte'];

        $sql = "UPDATE transporte SET situacao = 4 WHERE id = ".$idTransporte;
        if(mysqli_query($conexao, $sql)){

        }else{
            echo("ERRO");
        }

        
    }else{
        echo("erro ao trazer as informacoes do transporte");
    }

    //Selecionar as informacoes do transporte para popular as informacoes da Ordem de Servico

    $sql = "SELECT * FROM transporte_animal WHERE id_transporte = ".$idTransporte;
    
    $select = mysqli_query($conexao, $sql);
    
    while($rsConsulta = mysqli_fetch_array($select)){

        //Cadastrando as Ordens de servico para cada animal selecionado no transporte
        $sqlInsert = "insert into ordem_servico (id_animal,nome_cliente,contato_cliente,data_ordem,horario_ordem,transporte,situacao,
        situacao_pagamento,total, numero,logradouro,cep,bairro,cidade,uf,valor_transporte) 
        values (".$rsConsulta['id_animal'].",'".$nome."','".$celular."','".$dataTransporte."','".$horarioTransporte."',1,'A',0,".$valorServicos.",
        '".$numero."','".$logradouro."','".$cep."','".$bairro."','".$cidade."','".$estado."',".$valorTransporte.")";

        if(mysqli_query($conexao, $sqlInsert)){

            //ultima ordem cadastrada
            $sqlOrdem = "SELECT * FROM ordem_servico ORDER BY id DESC LIMIT 1";
            $selectOrdem = mysqli_query($conexao,$sqlOrdem);
            $rsOrdem = mysqli_fetch_array($selectOrdem);

            //puxando os servicos selecionados do transporte
            $sqlServicos = "SELECT * FROM transporte_servico WHERE id_transporte = ".$idTransporte;
            $selectServico = mysqli_query($conexao, $sqlServicos);

            while($rsConsultaServicos = mysqli_fetch_array($selectServico)){

                //inserindo os servicos selecionados no agendamento de transporte no servicos da OS
                $sqlInsertServicos = "INSERT INTO ordem_servico_servico (id_ordem_servico, id_servico) 
                VALUES (".$rsOrdem['id'].",".$rsConsultaServicos['id_servico'].")";

                if(mysqli_query($conexao, $sqlInsertServicos)){
                    
                }else{
                    echo("ERRO AQUI");
                }
            }

        }else{
            echo($sql);
        }
    }


    header('location: ../consultar-transporte.php');
}


?>
