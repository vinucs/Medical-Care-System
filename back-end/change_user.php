<?php session_start();

    // function changeValue($value, $elem) {
    //     if (isset($value) && !empty($value))
    //         $elem = (string)$value;
    // }

    function checkData($xml, $user_id) {
        foreach ($xml->children() as $user) {
            if ($user['id'] != $user_id) {
                if ($user->email == $_POST["email"]) {
                    echo "<script>alert('Email já está em uso!');window.history.back();</script>";
                    unset($_POST);
                    return false;
                }
                if ($user['type'] == 'patient') {
                    if ($user->cpf == $_POST["cpf"]) {
                        echo "<script>alert('Esse CPF já esta registrado!');window.history.back();</script>";
                        unset($_POST);
                        return false;
                    }
                } else if ($user['type'] == 'lab') {
                    if ($user->cnpj == $_POST['cnpj']) {
                        echo "<script>alert('Esse CNPJ já esta registrado!');window.history.back();</script>";
                        unset($_POST);
                        return false;
                        
                    }
                } else if ($user['type'] == 'doctor') {
                    if ($user->crm == $_POST['crm']) {
                        echo "<script>alert('Esse CRM já esta registrado!');window.history.back();</script>";
                        unset($_POST);
                        return false;
                    }
                }
            }
        }

        return true;
    }

    function changeUser($xml, $user_id) {

        foreach($xml->children() as $user) {
            if ((string)$user['id'] == $user_id) {
                if (isset($_POST['name']) && !empty($_POST['name']))
                    $user->name = stripslashes($_POST['name']);
                if (isset($_POST['adress']) && !empty($_POST['adress']))
                    $user->adress = stripslashes($_POST['adress']);
                if (isset($_POST['tel']) && !empty($_POST['tel']))
                    $user->telephone = stripslashes($_POST['tel']);
                if (isset($_POST['email']) && !empty($_POST['email']))
                    $user->email = stripslashes($_POST['email']);
                if (isset($_POST['password']) && !empty($_POST['password']))
                    $user->password = stripslashes($_POST['password']);

                if ((string)$user['type'] == 'patient'){
                    if (isset($_POST['age']) && !empty($_POST['age']))
                        $user->idade = stripslashes($_POST['age']);
                    if (isset($_POST['sex']) && !empty($_POST['sex']))
                        $user->genero = stripslashes($_POST['sex']);
                    if (isset($_POST['cpf']) && !empty($_POST['cpf']))
                        $user->cpf = stripslashes($_POST['cpf']);
                }
                else if ((string)$user['type'] == 'doctor'){
                    if (isset($_POST['especialidade']) && !empty($_POST['especialidade']))
                        $user->especializacao = stripslashes($_POST['especialidade']);
                    if (isset($_POST['crm']) && !empty($_POST['crm']))
                        $user->crm = stripslashes($_POST['crm']);
                }
                else if ((string)$user['type'] == 'lab'){
                    if (isset($_POST['cnpj']) && !empty($_POST['cnpj']))
                        $user->cnpj = stripslashes($_POST['cnpj']);

                    foreach ($user->children() as $elem){
                        if ((string)$elem->getName() == 'exame')
                            unset($user->exame);
                    }
                    if ($_POST["mamografia"] != NULL)
                        $user->addChild("exame", $_POST["mamografia"]);
                    if ($_POST["ressonancia"] != NULL)
                        $user->addChild("exame", $_POST["ressonancia"]);
                    if ($_POST["tomografia"] != NULL)
                        $user->addChild("exame", $_POST["tomografia"]);
                    if ($_POST["sonografia"] != NULL)
                        $user->addChild("exame", $_POST["sonografia"]);
                }


                // foreach($user->children() as $e => $elem) {
                //     foreach ($_POST as $param_name => $param_val) {
                //         if ($param_name == $elem->getName() && isset($param_val) && !empty($param_val)){
                //             echo $elem->getName();
                //             echo addslashes($param_val);
                //             $elem = addslashes($param_val);
                //             break;
                //         }
                //     }
                // }
                break;
            }
        }

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML("contas.xml");

        echo "<script>alert('Usuário alterado com sucesso!');sessionStorage.setItem('tab', 'change user');window.location.replace('../admin/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $xml = simplexml_load_file("contas.xml");

        if (checkData($xml, $_GET['user'])) {
            changeUser($xml, stripslashes($_GET['user']));
        }
        
    }
    else {
        unset($_POST);
        unset($_GET);
        echo "<script>
        window.location.replace('../admin/conta.php');
        alert('Usuário inválido.');
        </script>";
    }

?>