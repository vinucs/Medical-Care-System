<?php

    function checkData() {

        require('mongodb.php');
        $col = $database->selectCollection('contas');

        $result = $col->findOne(
                [ 'email' => $_POST["email"] ]
        );
        if (!is_null($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Email já está em uso!');</script>";
            unset($_POST);
            return false;
        }

        $result = $col->findOne(
                [ 'cpf' => $_POST['cpf'] ]
            );
        if (!is_null($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CPF já esta registrado!');</script>";
            unset($_POST);
            return false;
        }

        $result = $col->findOne(
            array(
                'cnpj' => $_POST['cnpj']
                )
            );
        if (!is_null($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CNPJ já esta registrado!');</script>";
            unset($_POST);
            return false;
        }

        $result = $col->findOne(
                array(
                    'crm' => $_POST['crm']
                    )
                );
        if (!is_null($result)) {
            echo "<script>window.location.replace('../admin/conta.php');alert('Esse CRM já esta registrado!');</script>";
            unset($_POST);
            return false;
            }

        return true;
    }

    function register() {
        require('mongodb.php');
        $col = $database->selectCollection('contas');

        $name = stripslashes($_POST["name"]);
        $end = stripslashes($_POST["adress"]);
        $tel = stripslashes($_POST["tel"]);
        $email = stripslashes($_POST["email"]);
        $senha = stripslashes($_POST["password"]);
        $type = stripslashes($_POST['user_type']);
        $id =  uniqid();

        $col->insert(
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
            $col->update(
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
            $col->update(
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
            $col->update(
                ['id' => $id],
                ['$set' => [
                                'cnpj' => $cnpj
                           ]
                ]
                );
            $col->update(
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