<?php

    if(!isset($_SESSION)){
        session_destroy();
        header('location: ../atendimento.php');
    }else{
        session_start();
        header('location: ../atendimento.php');
    }
?>