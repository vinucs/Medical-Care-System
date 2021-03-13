<?php session_start();

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        require 'classes.php';
        $user = new User;
    
        if ($user->checkCredentials($email, $senha) == true) {
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                header("Location: ../home.html");
                exit();
            } 
        }
    }
    session_unset();
    session_destroy();
?>

<script type="text/javascript">
alert('Email ou senha inválidos.');
window.location.href = "../index.php";
</script>