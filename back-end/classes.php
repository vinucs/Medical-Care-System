class Usuario {
    public function login ($email,$senha,$tipo) {
        $xml = simplexml_load_file("contas.xml");
        foreach ($xml->children() as $contas) {
            if ($contas->tipo == $tipo) {
                if ($contas->email == $email) {
                    if ($contas->senha == $senha) {
                        $_SESSION['email'] = $email;
                        $_SESSION['senha'] = $senha;
                        $_SESSION['tipo'] = $tipo;
                        $_SESSION['id'] = $contas->id; // facilitar buscas dps
                        return true;
                    }
                }
            }
        }
        if (empty($_SESSION['email'])) {
            unset($_POST);
            return false;
        } 
    }
}