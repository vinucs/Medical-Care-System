<?php

    require('mongodb.php');

    class User {
        
        public function checkCredentials($email, $senha) {
            $col = $database->selectCollection('contas')
            $result = $col->findOne(
                array(
                    'email': $email,
                    'password': $senha
                )
            );
                if (!empty(result)) {
                    $_SESSION['tipo'] = (string)$user['type'];
                    $_SESSION['id'] = (string)$user['id'];
                    $_SESSION['name'] = $result['nome'];
                    return true;
                }
            }
            unset($_POST);
            return false;
        }
        
    }

?>