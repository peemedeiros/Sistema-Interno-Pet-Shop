<?php
    require_once('conexao.php');
    $conexao = conexaoMysql();

    $numeroAleatorio = rand(0,6);
    $avatar = (String)"";

    if(isset($_POST['btn-cadastrar-cliente'])){
        require_once('functions.php');
        //quebrando injection
        $nome = str_replace("'"," ", $_POST['txt-cliente-nome']);

        //somente numeros serao digitados
        $cpf = $_POST['txt-cliente-cpf'];

        //somente numeros serao digitados
        $telefone = $_POST['txt-cliente-telefone'];

        //somente numeros serao digitados
        $celular = $_POST['txt-cliente-celular'];

        //quebrando injection
        //O email esta sendo utilizado para salvar os instagrams dos clientes
        $email = str_replace("'"," ", $_POST['txt-cliente-email']);

        $sexo = $_POST['rdSexo'];

        //somente numeros serao digitados
        $cep = $_POST['txt-cliente-cep'];
        //quebrando injection
        $logradouro = str_replace("'", " ", $_POST['txt-cliente-logradouro']);
        $bairro = str_replace("'", " ", $_POST['txt-cliente-bairro']);
        $cidade = str_replace("'", " ", $_POST['txt-cliente-cidade']);
        $estado = str_replace("'", " ", $_POST['txt-cliente-estado']);
        $numero = $_POST['txt-cliente-numero'];

        if($sexo =="M"){
            $avatar = "man".$numeroAleatorio.".png";
        }elseif($sexo == "F"){
            $avatar = "woman".$numeroAleatorio.".png";
        }else{
            $avatar = "user1.png";
        }

        if($_POST['btn-cadastrar-cliente'] == "CADASTRAR"){

            session_destroy();

            if(inserirCliente($nome,$cpf,
                            $telefone,$celular,
                            $email,$sexo,$cep,$logradouro,
                            $bairro,$cidade,$estado,
                            $numero,$avatar)){
                                header('location: ../cliente-sucesso.php');
                            }

        }elseif($_POST['btn-cadastrar-cliente'] == "EDITAR"){

            if(!isset($_SESSION))
                session_start();

            $id = $_SESSION['id'];

            $sql = "UPDATE clientes SET nome ='".$nome."', cpf = '".$cpf."', 
                    telefone = '".$telefone."', celular = '".$celular."',
                    email = '".$email."', sexo = '".$sexo."', cep = '".$cep."',
                    logradouro = '".$logradouro."', bairro = '".$bairro."',
                    cidade = '".$cidade."', estado = '".$estado."', numero = '".$numero."' 
                    WHERE id = ".$id."";

            if(mysqli_query($conexao, $sql)){
    
                header('location: ../painel-cliente.php?idcliente='.$id);

            }
        }
        
    }
?>