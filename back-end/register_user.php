<?php

    require('mongodb.php');

    function checkData() {
        $result = $col->findOne(array('email' => $_POST["email"]))
        if (!empty($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Email já está em uso!');</script>";
            unset($_POST);
            return false;
        }
        $result = $col->findOne(
            array(
                'cpf' => $_POST['cpf']
                )
            );
        if (!empty($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CPF já esta registrado!');</script>";
            unset($_POST);
            return false;
        }
        $result = $col->findOne(
            array(
                'cnpj' => $_POST['cnpj']
                )
            );
        if (!empty($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CNPJ já esta registrado!');</script>";
            unset($_POST);
            return false;
        }
        $result = $col->findOne(
                array(
                    'crm' => $_POST['crm']
                    )
                );
        if (!empty($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CRM já esta registrado!');</script>";
            unset($_POST);
            return false;
            }
        return true;
    }

    function register() {
        $name = stripslashes($_POST["name"]);
        $end = stripslashes($_POST["adress"]);
        $tel = stripslashes($_POST["tel"]);
        $email = stripslashes($_POST["email"]);
        $senha = stripslashes($_POST["password"]);
        $type = stripslashes($_POST['user_type']);
        $id =  uniqid();

        $col = $database->selectCollection('contas');
        $col->insertOne(
            array(
                'type' => $type,
                'id' => $id,
                'name' => $name,
                'adress' => $end,
                'telephone' => $tel,
                'email' => $email,
                'password' => $senha
                )
            );
        
        if ($_POST["user_type"] == 'patient') {
            $genero = stripslashes($_POST["sex"]);
            $cpf = stripslashes($_POST["cpf"]);
            $age = stripslashes($_POST["age"]);
            $col->updateOne(
                ['id' => $id],
                ['$set' => [
                                'genero' => $genero,
                                'cpf' => $cpf,
                                'idade' => $age
                           ]
                ]
                );
        } 
        else if ($_POST["user_type"] == 'doctor') {
            $espec = stripslashes($_POST["especialidade"]);
            $crm = stripslashes($_POST["crm"]);
            $col->updateOne(
                ['id' => $id],
                ['$set' => [
                                'especializacao' => $espec,
                                'crm' => $crm
                           ]
                ]
                );
        } 
        else if ($_POST["user_type"] == 'lab') {
            $cnpj = stripslashes($_POST["cnpj"]);
            $col->updateOne(
                ['id' => $id],
                ['$set' => [
                                'cnpj' => $cnpj
                           ]
                ]
                );
            }
            $col->updateOne(
                ['id' => $id],
                ['$set' => [
                                'mamografia' => $_POST["mamografia"],
                                'ressonancia' => $_POST['ressonancia'],
                                'tomografia' => $_POST["tomografia"],
                                'sonografia' => $_POST['sonografia']
                            ]
                ]
                );
        }
        echo "<script>window.location.replace('../admin/conta.php');alert('Usuário registrado com sucesso!');</script>";
        unset($_POST);
    }

    if (checkData()) {
        register();
    }

?>