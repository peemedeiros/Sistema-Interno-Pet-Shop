<?php
require_once('conexao.php');
$conexao = conexaoMysql();

$sql = "SELECT id FROM compra ORDER BY id DESC LIMIT 1 ";
$select = mysqli_query($conexao, $sql);
$rsConsulta = mysqli_fetch_array($select);

$idCompra = $rsConsulta['id'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/styles.css">
        <title>SIAP</title>
    </head>
    <body>
        <div class="pagina-inicial-atendimento">
            <div class="container center">
                
                <div class="cliente-cadastrado">
                    <div class="cpf-cliente-delete">
                        <img src="../icon/checkmark.png" alt="disponivel" id="avaliable">
                        <h1>COMPRA REALIZADA</h1>
                    </div>
                </div>
                <div class="">

                </div>
                
            </div>
        </div>
    </body>
</html>