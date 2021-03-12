<?php


    class User {
        
        public function checkCredentials($email, $senha) {
            require('mongodb.php');
            $col = $database->selectCollection('contas');
            $result = $col->findOne(
                array(
                    'email' => $email,
                    'password' => $senha
                )
            );
            if (!empty($result)) {
                $_SESSION['tipo'] = $result['user_type'];
                $_SESSION['id'] = $result['id'];
                $_SESSION['name'] = $result['name'];
                return true;
            }
            unset($_POST);
            return false;
        }
        
    }

?>