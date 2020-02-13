<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $status = (String)"";

    date_default_timezone_set('America/Sao_Paulo');

    $diaAtual = date("Y-m-d");

    if(isset($_POST['btn-dia-selecionado'])){

        $diaAtual = $_POST['date-monitoramento'];

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SIAP</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
        <script>
            $(document).ready(function(){
                $('.transporteInfo').click(function(){
                    $('#container-modalTransporte').css({
                        visibility:'visible',
                        opacity:'1',
                        zIndex:'999'
                    });
                });
                $('#close-modal').click(function(){
                    $('#container-modalTransporte').css({
                        visibity:'hidden',
                        opacity:'0',
                        zIndex:'-5'
                    });
                });
            });

            function visualizarOrdem(idtransporte, status){
                $.ajax({
                    type:"POST",
                    url:"modalTransporte.php",
                    data:{
                        modo:"visualizar",
                        id:idtransporte,
                        situacao:status
                    },
                    success: function(dados){
                        $('#modal-transporte').html(dados);
                    }
                });
            }
        </script>
    </head>
    <body>
    <?php
        require_once('modulo/menu.php');
    ?>
        <div id="container-modalTransporte">
            <img src="icon/cancel.png" alt="fechar" id="close-modal">
            <div id="modal-transporte">

            </div>
        </div>

        <div class="pagina-inicial-transporte-consulta flex-align-end">
            <div class="tranportes-confirmados tabela-grande">
                <div class="linha">
                    <h3>TRANSPORTES SOLICIDADOS DE HOJE</h3>
                    <form action="consultar-transporte.php" method="post" class="selecione-data">
                        <h6> Selecione data </h6>
                        <img src="icon/calendar.png" alt="calendario">
                        <input type="date" value="<?=$diaAtual?>" name="date-monitoramento" id="slt-data-monitoramento">
                        <button type="submit" name="btn-dia-selecionado">
                            <img src="icon/lupa.png" alt="lupa">
                        </button>
                    </form>
                </div>
                <div class="tabela-transportes">
                    <div class="linha-tabela-transporte">
                        <div class="coluna-tabeta-transporte">
                            CLIENTE
                        </div>
                        <div class="coluna-tabeta-transporte">
                            HORARIO AGENDADO
                        </div>
                        <div class="coluna-tabeta-transporte">
                            VALOR
                        </div>
                        <div class="coluna-tabeta-transporte">
                            VISUALIZAR
                        </div>
                        <div class="coluna-tabeta-transporte">
                            STATUS
                        </div>
                    </div>
                    <?php
                        $sql = "SELECT * FROM transporte WHERE data_transporte = '".$diaAtual."'  ORDER BY situacao = 1 DESC,horario_transporte ASC";

                        $select = mysqli_query($conexao, $sql);

                        $i = 0;
                        $cor = (String)"";

                        while($rsConsulta = mysqli_fetch_array($select))
                        {
                            $i++;
                            if($i % 2 == 0)
                                $cor = "cor";
                            else
                                $cor = "";
                            
                            $horario = date_create($rsConsulta['horario_transporte']);

                            if($rsConsulta['situacao'] == 1)
                            {
                                $status = "alarme.png";
                            }elseif($rsConsulta['situacao'] == 2)
                            {
                                $status = "warning.png";
                            }elseif($rsConsulta['situacao'] == 3)
                            {
                                $status = "taxi.png";
                            }elseif($rsConsulta['situacao'] == 4)
                            {
                                $status = "nopet.png";
                            }elseif($rsConsulta['situacao'] == 0)
                            {
                                $status = "cancelado.png";
                            }elseif($rsConsulta['situacao'] == 5)
                            {
                                $status = "verificado.png";
                            }
                            
                    ?>
                    <div class="linha-tabela-transporte-corpo <?=$cor?>">
                        <div class="coluna-tabeta-transporte border-none">
                            <?=$rsConsulta['nome_cliente']?>
                        </div>
                        <div class="coluna-tabeta-transporte border-none">
                            <?=date_format($horario, "H:i")?>
                        </div>
                        <div class="coluna-tabeta-transporte border-none">
                            R$<?=number_format($rsConsulta['valor_transporte']+$rsConsulta['valor_servicos'], 2 ,',','.')?>
                        </div>
                        <div class="coluna-tabeta-transporte border-none">
                            <a href="#">
                                <img src="icon/lupa.png" onclick="visualizarOrdem(<?=$rsConsulta['id']?>, '<?=$rsConsulta['situacao']?>');" class="transporteInfo" alt="visualizar">
                            </a> 
                        </div>
                        <div class="coluna-tabeta-transporte border-none">
                            
                            <img src="icon/<?=$status?>" alt="visualizar">
                            
                        </div>
                    </div>
                    <?php

                        }

                    ?>
                </div>
                
            </div>
            <div class="legenda-trasporte-status">
                <div>
                    <img src="icon/alarme.png" alt="agendado">
                    <h4>AGUARDANDO CONFIRMAÇÃO</h4>
                </div>
                <div>
                    <img src="icon/cancelado.png" alt="cancelado">
                    <h4>SERVIÇO CANCELADO</h4>
                </div>
                <div>
                    <img src="icon/warning.png" alt="aguardando">
                    <h4>AGUARDANDO TRANSPORTE</h4>
                </div>
                <div>
                    <img src="icon/taxi.png" alt="cancelado">
                    <h4>TAXI DOG A CAMINHO</h4>
                </div>
                <div>
                    <img src="icon/nopet.png" alt="cancelado">
                    <h4>NO PETSHOP</h4>
                </div>
                <div>
                    <img src="icon/verificado.png" alt="cancelado">
                    <h4>FINALIZADO</h4>
                </div>
            </div>
            
        </div>
    </body>
</html>