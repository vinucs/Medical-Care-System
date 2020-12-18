<?php session_start();

    $message = "Ocorreu algum erro!";
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = addslashes($_POST['password']);
        $xml = simplexml_load_file("contas.xml");

        foreach($xml->children() as $user) {
            if ($_SESSION['id'] == (string)$user['id']) {
                if ($password == (string)$user->password) {
                    if (isset($_POST['email']) && !empty($_POST['email']))
                        $user->email = addslashes($_POST['email']);
                    if (isset($_POST['new_password']) && !empty($_POST['new_password']))
                        $user->password = addslashes($_POST['new_password']);
                    if (isset($_POST['adress']) && !empty($_POST['adress']))
                        $user->adress = addslashes($_POST['adress']);
                    if (isset($_POST['tel']) && !empty($_POST['tel']))
                        $user->telephone = addslashes($_POST['tel']);

                    $new_xml = simplexml_import_dom($xml);
                    $new_xml->saveXML('contas.xml');
                    $message = 'Mudado com sucesso!';
                    break;
                }
                else {
                    $message = 'Senha inválida!';
                    break;
                }
            }
        }
    }

    $session_type = $_SESSION['tipo'];
    echo $session_type;
    echo "<script>window.location.replace('../$session_type/conta.php');alert('$message'); </script>";
    unset($_POST);

?>