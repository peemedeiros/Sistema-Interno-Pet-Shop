<?php


    if(isset($_POST['btn-cadastrar-compra']))
    {
        require_once('conexao.php');
        $conexao = conexaoMysql();

        session_start();

        $cliente = $_POST['idcliente'];

        $precoTotal = explode(',',$_POST['precototal']);
        $precoTotal = $precoTotal[0].".".$precoTotal[1];
        
        $formaPagamento = $_POST['slt-pagamento'];
        $carrinho = $_GET['carrinho'];

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d');
        $horario = date('H:i:s');

        if($cliente != ""){

            $sql = "INSERT INTO compra (id_cliente, id_carrinho, id_formapagamento, data_compra, horario_compra, preco_total)
            VALUES (".$cliente.",".$carrinho.",".$formaPagamento.",'".$data."', '".$horario."', '".$precoTotal."')";

        }else{

            $sql = "INSERT INTO compra (id_carrinho, id_formapagamento, data_compra, horario_compra, preco_total)
            VALUES (".$carrinho.",".$formaPagamento.",'".$data."', '".$horario."', '".$precoTotal."')";

        }

        if(mysqli_query($conexao,$sql))
        {
            $sql = "SELECT * FROM carrinho_produto WHERE id_carrinho =".$carrinho;

            $select = mysqli_query($conexao, $sql);

            while($rsConsulta = mysqli_fetch_array($select))
            {
                $sql="UPDATE produtos set quantidade = quantidade - ".$rsConsulta['saida_produto']." WHERE id =".$rsConsulta['id_produto'];
                
                if(mysqli_query($conexao, $sql)){

                    $sqlPdf = "SELECT id FROM compra ORDER BY id DESC LIMIT 1";

                    $selectPdf = mysqli_query($conexao, $sqlPdf);

                    if($rsPdf = mysqli_fetch_array($selectPdf)){

                        header('location: ../modalCompras.php?idcompra='.$rsPdf['id'].'&idcliente='.$cliente);
                        session_unset();

                    }

                }else{
                    echo($sql);
                }
            }
           
        }else
        {
            echo($sql);
            echo("erro".$cliente);
        }


    }

?>