<?php
    
    function checkData($xml) {
        foreach ($xml->children() as $user) {
            if ($user->email == $_POST["email"]) {
                echo "<script>window.location.replace('../admin/conta.php');alert('Email já está em uso!');</script>";
                unset($_POST);
                return false;
            }
            if ($user['type'] == 'patient') {
                if ($user->cpf == $_POST["cpf"]) {
                    echo "<script>window.location.replace('../admin/conta.php');alert('Esse CPF já esta registrado!');</script>";
                    unset($_POST);
                    return false;
                }
            } else if ($user['type'] == 'lab') {
                if ($user->cnpj == $_POST['cnpj']) {
                    echo "<script>window.location.replace('../admin/conta.php');alert('Esse CNPJ já esta registrado!');</script>";
                    unset($_POST);
                    return false;
                    
                }
            } else if ($user['type'] == 'doctor') {
                if ($user->crm == $_POST['crm']) {
                    echo "<script>window.location.replace('../admin/conta.php');alert('Esse CRM já esta registrado!');</script>";
                    unset($_POST);
                    return false;
                }
            }
        }

        return true;
    }

    function register($xml) {
        $name = addslashes($_POST["name"]);
        $end = addslashes($_POST["adress"]);
        $tel = addslashes($_POST["tel"]);
        $email = addslashes($_POST["email"]);
        $senha = addslashes($_POST["password"]);
        $type = addslashes($_POST['user_type']);
        $id =  uniqid();
    
        $new_user = $xml->addChild('user');
        $new_user->addAttribute('type', $type);
        $new_user->addAttribute("id", $id);
        $new_user->addChild('name',  $name);
        $new_user->addChild('adress', $end);
        $new_user->addChild('telephone', $tel);
        $new_user->addChild('email', $email);
        $new_user->addChild('password', $senha);
        
        if ($_POST["user_type"] == 'patient') {
            $genero = addslashes($_POST["sex"]);
            $cpf = addslashes($_POST["cpf"]);
            $age = $_POST["age"];
            $new_user->addChild('genero', $genero);
            $new_user->addChild('idade', $age);
            $new_user->addChild('cpf', $cpf);
        } 
        else if ($_POST["user_type"] == 'doctor') {
            $espec = $_POST["especialidade"];
            $crm = $_POST["crm"];
            $new_user->addChild('especializacao', $espec);
            $new_user->addChild('crm', $crm);
        } 
        else if ($_POST["user_type"] == 'lab') {
            $cnpj = $_POST["cnpj"];
            $new_user->addChild('cnpj',$cnpj);
            if ($_POST["mamografia"] != NULL) {
                $new_user->addChild("exame", $_POST["mamografia"]);
            }
            if ($_POST["ressonancia"] != NULL) {
                $new_user->addChild("exame", $_POST["ressonancia"]);
            }
            if ($_POST["tomografia"] != NULL) {
                $new_user->addChild("exame", $_POST["tomografia"]);
            } 
            if ($_POST["sonografia"] != NULL) {
                $new_user->addChild("exame", $_POST["sonografia"]);
            }
        }

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML('contas.xml');
        echo "<script>window.location.replace('../admin/conta.php');alert('Usuário registrado com sucesso!');</script>";
        unset($_POST);
    }

    $xml = simplexml_load_file("contas.xml");

    if (checkData($xml)) {
        register($xml);
    }

?>