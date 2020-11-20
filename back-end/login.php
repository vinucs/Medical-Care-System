if (isset($_POST['email']) && !empty($_POST['email'] && isset($_POST['senha']) && !empty($_POST['senha']))) {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $tipo = addslashes($_POST['tipo']);
    require 'classes.php';
    if ($tipo == 'usuario') {
        $user = new Usuario;
    } else {
        if ($tipo == 'medico') {
            $user = new Medico;
        }
        else {
            if ($tipo == 'laboratorio') {
                $user = new Laboratorio;
            }
        }
    }
    session.start();
    if ($user->login($email,$senha,$tipo) == true) {
        if (isset(($_SESSION['id']))) {
            header("Location: " . $_SESSION['tipo'] . '.html');
        } else {
            header ("Location: login.php")
        }
    } else {
        header("Location: login.php");
    }