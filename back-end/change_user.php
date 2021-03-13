<?php session_start();
    require('mongodb.php');
    // function changeValue($value, $elem) {
    //     if (isset($value) && !empty($value))
    //         $elem = (string)$value;
    // }
    function checkData($user_id) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $result = $col->findOne(
            array(
                'id' => $user_id
            )
        );
        if (empty($result)) {
            $result = $col->findOne(
                array(
                    'email' => $_POST["email"]
                )
            );
        }
            if (!empty($result)) {
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
                if (!empty($result)) {
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
                if (!empty($result)) {
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
                if (!empty($result)) {
                    echo "<script>alert('Esse CRM já esta registrado!');window.history.back();</script>";
                    unset($_POST);
                    return false;
                }
            }
        return true;
    }

    

    function changeUser($user_id) {
        $result = $col->findOne(
            array(
                'id' => $user_id
            )
        );
        if (!empty($result)) {
            if (isset($_POST['name']) && !empty($_POST['name']))
                $result['name'] = stripslashes($_POST['name']);
            if (isset($_POST['adress']) && !empty($_POST['adress']))
                $result['adress'] = stripslashes($_POST['adress']);
            if (isset($_POST['tel']) && !empty($_POST['tel']))
                $result['telephone'] = stripslashes($_POST['tel']);
            if (isset($_POST['email']) && !empty($_POST['email']))
                $result['email'] = stripslashes($_POST['email']);
            if (isset($_POST['password']) && !empty($_POST['password']))
                $result['password'] = stripslashes($_POST['password']);
            if ($result['user_type'] == 'patient') {
                if (isset($_POST['age']) && !empty($_POST['age']))
                    $result['idade'] = stripslashes($_POST['age']);
                if (isset($_POST['sex']) && !empty($_POST['sex']))
                    $result['genero'] = stripslashes($_POST['sex']);
                if (isset($_POST['cpf']) && !empty($_POST['cpf']))
                    $result['cpf'] = stripslashes($_POST['cpf']);                
            } else if ($result['user_type'] == 'doctor') {
                if (isset($_POST['especialidade']) && !empty($_POST['especialidade']))
                    $result['especializacao'] = stripslashes($_POST['especialidade']);
                if (isset($_POST['crm']) && !empty($_POST['crm']))
                    $result['crm'] = stripslashes($_POST['crm']);
            } else if ($result['user_type'] == 'lab') {
                if (isset($_POST['cnpj']) && !empty($_POST['cnpj']))
                    $cnpj = stripslashes($_POST['cnpj']);
                    $col->updateOne(
                        ['id' => $id],
                        ['$set' => [
                                        'nome' => $name,
                                        'adress' => $adress,
                                        'telephone' => $telephone,
                                        'email' => $email,
                                        'password' => $password,
                                        'mamografia' => $_POST["mamografia"],
                                        'ressonancia' => $_POST['ressonancia'],
                                        'tomografia' => $_POST["tomografia"],
                                        'sonografia' => $_POST['sonografia']
                                    ]
                        ]
                        );
            }

            $col->updateOne(
                ['id' => $id],
                ['$set' => $result]
                );
            }
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