<?php

require_once('conexao.php');
$conexao = conexaoMysql();

if(isset($_POST['btn-cadastrar-transporte'])){

    $sql = "SELECT * FROM transporte ORDER BY id DESC LIMIT 1";

    $select = mysqli_query($conexao , $sql);

    if($rsConsulta = mysqli_fetch_array($select)){
        
        // if(!empty($_POST['checklist'])){

        //     foreach($_POST['checklist'] as $selected){
    
        //         $sqlAnimais = "INSERT INTO transporte_animal (id_transporte, id_animal)
        //                         VALUES (".$rsConsulta['id'].",".$selected.")";
        
        //         if(mysqli_query($conexao, $sqlAnimais)){
        //             // header('location: ../confirmar-transporte.php?idcliente='.$rsConsulta['id_cliente'].'&idtransporte='.$rsConsulta['id']);
        //         }else{
        //             echo("erro");
        //         }
        //     }
        // }
        
        if($rsConsulta['id_cliente'] != ""){

            if(!empty($_POST['checklistservico'])){

                foreach($_POST['checklistservico'] as $selectedServico){

                    $sqlServico = "INSERT INTO transporte_servico (id_transporte, id_servico) 
                                    VALUES (".$rsConsulta['id'].", ".$selectedServico.")";
                    //CADASTRE UM NOVO TRANSPORTE PARA NO ULTIMO PASSO DE CADASTRAMENTO DE TRANSPORTE, REALIZAR O UPDATE
                    if(mysqli_query($conexao, $sqlServico)){
                        
                        //header('location: ../confirmar-transporte.php?idcliente='.$rsConsulta['id_cliente'].'&idtransporte='.$rsConsulta['id']);
                        
                    }else{
                        echo($sqlServico);
                    }
                }
            }

            if(!empty($_POST['checklist'])){

                foreach($_POST['checklist'] as $selected){
    
                    $sqlAnimais = "INSERT INTO transporte_animal (id_transporte, id_animal)
                                    VALUES (".$rsConsulta['id'].",".$selected.")";
            
                    if(mysqli_query($conexao, $sqlAnimais)){
                        header('location: ../confirmar-transporte.php?idcliente='.$rsConsulta['id_cliente'].'&idtransporte='.$rsConsulta['id']);
                    }else{
                        echo($sqlAnimais);
                    }
                }
            }
            
        }else{
            if(!empty($_POST['checklistservico'])){

                foreach($_POST['checklistservico'] as $selectedServico){

                    $sqlServico = "INSERT INTO transporte_servico (id_transporte, id_servico) 
                                    VALUES (".$rsConsulta['id'].", ".$selectedServico.")";
                    //CADASTRE UM NOVO TRANSPORTE PARA NO ULTIMO PASSO DE CADASTRAMENTO DE TRANSPORTE, REALIZAR O UPDATE
                    if(mysqli_query($conexao, $sqlServico)){
                        
                        header('location: ../confirmar-transporte.php?idcliente='.$rsConsulta['id_cliente'].'&idtransporte='.$rsConsulta['id']);
                        
                    }else{
                        echo($sqlServico);
                    }
                }
            }
        }
            
        
       
    }
}

?>