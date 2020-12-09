<?php session_start();

    if (isset($_POST['email']) && !empty($_POST['email'] && isset($_POST['senha']) && !empty($_POST['senha']))) {
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
    
        if ($user->checkCredentials($email, $senha) == true) {
            if (isset(($_SESSION['id'])) && !empty($_SESSION['id'])) {
                header("Location: ../home.html");
                exit();
            } 
        }
    }
    session_unset();
    session_destroy();
    
    $message = 'Email ou senha inválidos.';
    echo "<script>
        window.location.replace('../index.html')
        alert('$message');
    </script>";

?>