<?php

    class User {
        
        public function login($email, $senha) {

            if (file_exists('contas.xml')) {
                $xml = simplexml_load_file('contas.xml');
            } 
            else {
                return false;
            }

            foreach($xml->children() as $user) {
                if ($user->email == $email && $user->password == $senha) {
                    $_SESSION['tipo'] = $user['type'];                  
                    $_SESSION['email'] = $user->email;
                    $_SESSION['senha'] = $user->password;
                    $_SESSION['id'] = $user->id;
                    return true;
                }
            }
            unset($_POST);
            return false;
        }
        
    }

?>