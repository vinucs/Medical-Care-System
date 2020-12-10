<?php

    class User {
        
        public function checkCredentials($email, $senha) {

            if (file_exists('contas.xml')) {
                $xml = simplexml_load_file('contas.xml');
            } 
            else {
                return false;
            }

            foreach($xml->children() as $user) {
                if ($user->email == $email && $user->password == $senha) {
                    $_SESSION['tipo'] = (string)$user['type'];
                    $_SESSION['id'] = (string)$user['id'];
                    return true;
                }
            }
            unset($_POST);
            return false;
        }
        
    }

?>