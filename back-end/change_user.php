<?php session_start();
    require('mongodb.php');
    // function changeValue($value, $elem) {
    //     if (isset($value) && !empty($value))
    //         $elem = (string)$value;
    // }
    function checkData($user_id) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $user = $col->findOne(
            array(
                'id' => $user_id
            )
        );
        if (empty($user)) {
            $result = $col->findOne(
                array(
                    'email' => $_POST["email"]
                )
            );
            if (!empty($result) && $user['id'] != $result['id']) {
                echo "<script>alert('Email já está em uso!');window.history.back();</script>";
                unset($_POST);
                return false;
            }
            if ($result['user_type'] == 'patient') {
                $result = $col->findOne(
                    array(
                        'cpf' => $_POST["cpf"]
                    )
                );
                if (!empty($result) && $user['id'] != $result['id']) {
                    echo "<script>alert('Esse CPF já esta registrado!');window.history.back();</script>";
                    unset($_POST);
                    return false;
                }
            } else if ($result['user_type'] == 'lab') {
                $result = $col->findOne(
                    array(
                        'cnpj' => $_POST["cnpj"]
                    )
                );
                if (!empty($result) && $user['id'] != $result['id']) {
                    echo "<script>alert('Esse CNPJ já esta registrado!');window.history.back();</script>";
                    unset($_POST);
                    return false;
                }
            } else if ($result['user_type'] == 'doctor') {
                $result = $col->findOne(
                    array(
                        'crm' => $_POST["crm"]
                    )
                );
                if (!empty($result) && $user['id'] != $result['id']) {
                    echo "<script>alert('Esse CRM já esta registrado!');window.history.back();</script>";
                    unset($_POST);
                    return false;
                }
            }
        }
        return true;
    }

    function updateField($id,$fieldName, $value) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $col->update(
            ['id' => $id],
                ['$set' => 
                        [
                        $fieldName => $value
                        ]
                ]
            );

    }

    function changeUser($user_id) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $result = $col->findOne(
            array(
                'id' => $user_id
            )
        );
        if (!empty($result)) {
            if (isset($_POST['name']) && !empty($_POST['name']))
                updateField($user_id,'name',stripslashes($_POST['name']));
            if (isset($_POST['adress']) && !empty($_POST['adress']))
                updateField($user_id,'adress',stripslashes($_POST['adress']));
            if (isset($_POST['tel']) && !empty($_POST['tel']))
                updateField($user_id,'telephone',stripslashes($_POST['telephone']));
            if (isset($_POST['email']) && !empty($_POST['email']))
                updateField($user_id,'email',stripslashes($_POST['email']));
            if (isset($_POST['password']) && !empty($_POST['password']))
                updateField($user_id,'password',stripslashes($_POST['password']));
            if ($result['user_type'] == 'patient') {
                if (isset($_POST['age']) && !empty($_POST['age']))
                    updateField($user_id,'idade',stripslashes($_POST['age']));
                if (isset($_POST['sex']) && !empty($_POST['sex']))
                    updateField($user_id,'genero',stripslashes($_POST['sex']));
                if (isset($_POST['cpf']) && !empty($_POST['cpf']))
                    updateField($user_id,'cpf',stripslashes($_POST['cpf']));
            }
        } else if ($result['user_type'] == 'doctor') {
                if (isset($_POST['especialidade']) && !empty($_POST['especialidade']))
                    updateField($user_id,'especializacao',stripslashes($_POST['especialidade']));
                if (isset($_POST['crm']) && !empty($_POST['crm']))
                    updateField($user_id,'crm',stripslashes($_POST['crm']));
        } else if ($result['user_type'] == 'lab') {
            if (isset($_POST['cnpj']) && !empty($_POST['cnpj']))
                updateField($user_id,'cnpj',stripslashes($_POST['cnpj']));
            array_push($exames,$_POST["mamografia"]);
            array_push($exames,$_POST["ressonancia"]);
            array_push($exames,$_POST["tomografia"]);
            array_push($exames,$_POST["sonografia"]);
            $exames = array_filter($exames,'strlen');
            if (!empty($exames)) {
                updateField($user_id,'exames',$exames);
            }
        }
            #$col->update(
            #    ['id' => $id],
            #    ['$set' => $result]
            #    );
        echo "<script>alert('Usuário alterado com sucesso!');sessionStorage.setItem('tab', 'change user');window.location.replace('../admin/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['user']) && !empty($_GET['user'])) {

        if (checkData($_GET['user'])) {
            changeUser(stripslashes($_GET['user']));
        }
    } else {
        unset($_POST);
        unset($_GET);
        echo "<script>
        window.location.replace('../admin/conta.php');
        alert('Usuário inválido.');
        </script>";
    }

?>