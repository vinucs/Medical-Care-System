<?php session_start();
    require('mongodb.php')
    $message = "Ocorreu algum erro!";
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $id = $_SESSION['id']
        $password = addslashes($_POST['password']);
        $col = $database->selectCollection('contas')
        $result = $col->findOne(
            array(
                'id': $id,
                'password': $password
            )
            );
        if (!empty($result)) {
            if (isset($_POST['email']) && !empty($_POST['email']))
                $email = addslashes($_POST['email']);
            if (isset($_POST['new_password']) && !empty($_POST['new_password']))
                $password = addslashes($_POST['new_password']);
            if (isset($_POST['adress']) && !empty($_POST['adress']))
                $adress = addslashes($_POST['adress']);
            if (isset($_POST['tel']) && !empty($_POST['tel']))
                $telephone = addslashes($_POST['tel']);
            $col->updateOne(
                ['id' => $_SESSION['id']],
                ['$set' => [
                                'email' => $email,
                                'password' => $password,
                                'adress' => $adress,
                                'telephone' => $telephone
                            ]
                ]
            );
                $message = 'Mudado com sucesso!';
        } else {
            $message = 'Senha inválida!';
        }
    }
    $session_type = $_SESSION['tipo'];
    echo $session_type;
    echo "<script>window.location.replace('../$session_type/conta.php');alert('$message'); </script>";
    unset($_POST);
?>