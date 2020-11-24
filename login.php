<?php

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (isset($email) && isset($senha)) {
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        require 'classes.php';
        $user = new User;

        // $tipo = addslashes($_POST['tipo']);
        // require 'classes.php';

        // switch ($tipo) {
        //     case 'usuario':
        //         $user = new Usuario;
        //         break;
        //     case 'medico':
        //         $user = new Medico;
        //         break;
        //     case 'laboratorio':
        //         $user = new Laboratorio;
        //         break;
        //     case 'admin':
        //         $user = new Admin;
        //         break;

        // }
    
        echo 'maneiro';
        session_start();
        if ($user->login($email, $senha) == true) {
            if (isset(($_SESSION['id']))) {
                header("Location: " . $_SESSION['tipo'] . '/index.html');
                exit();
            } 
        }
    }
    header("Location: login.html");
    // echo '<script type=‘text/javascript’>alert(‘Usuario ou senha incorreta!’); window.location.href=‘login.html’;</script>'; /// Alerta

?>