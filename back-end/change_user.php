<?php session_start();

    $message = "Ocorreu algum erro!";
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = addslashes($_POST['password']);
        $xml = simplexml_load_file("contas.xml");

        foreach($xml->children() as $user) {
            if ($_SESSION['id'] == (string)$user->id) {
                if ($password == (string)$user->password) {
                    if (isset($_POST['email']) && !empty($_POST['email']))
                        $user->email = addslashes($_POST['email']);
                    if (isset($_POST['new_password']) && !empty($_POST['new_password']))
                        $user->password = addslashes($_POST['new_password']);
                    $user->id = uniqid();
                    $new_xml = simplexml_import_dom($xml);
                    $new_xml->saveXML('contas.xml');
                    $message = 'Mudado com sucesso!';
                    break;
                }
                $message = 'Senha inválida!';

            }
        }
    }

    unset($_POST);
    echo "<script>
    window.location.replace('../admin/conta.html')
    alert('$message');
    </script>";
    exit();

?>