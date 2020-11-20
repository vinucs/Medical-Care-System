$xml = simplexml_load_file("contas.xml");

foreach ($xml->children() as $contas) {
    if ($contas->tipo == $_POST["tipo"]) {
        if ($contas->tipo == 'usuario') {
            if ($contas->cpf == $_POST["cpf"]) {
                echo '<script language=’javascript’ type=’text/javascript’>alert(‘Esse usuario ja esta registrado nessa modalidade!’);window.location.href=’cadastro.html’;</script>';
                unset($_POST);
                header('Refresh: 1; url = registro.html');
        } else {
            break;
        }
    } else if ($contas->tipo == 'laboratorio') {
        if ($contas->cnpj == $_POST['cnpj']) {
            echo '<script language=’javascript’ type=’text/javascript’>alert(‘Esse laboratorio ja foi registrado!’);window.location.href=’cadastro.html’;</script>';
            unset($_POST);
            header('Refresh: 1; url = registro.html');
        }
    } else if ($contas->tipo == 'medico') {
        if ($contas->crm == $_POST['crm']) {
            echo '<script language=’javascript’ type=’text/javascript’>alert(‘Esse medico ja se encontra registrado!’);window.location.href=’cadastro.html’;</script>';
            unset($_POST);
            header('Refresh: 1; url = registro.html');
            }
        }
    }
}


$n     = $_POST["nome"];
$end = $_POST["endereco"];
$tel = $_POST["telefone"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$id =  uniqid();

$filho = $xml->addChild('tipo',$POST["tipo"]);
$filho->addAttribute("id", $id);
$filho->addChild('nome',$nome);
$filho->addChild('endereco',$end);
$filho->addChild('telefone',$tel);
$filho->addChild('email',$email);
$filho->addChild('senha',$senha);


if ($_POST["tipo"] == 'usuario') {
//recebe os dados enviados pelo formulario
    $genero = $_POST["genero"];
    $nasc = $_POST["data_nasc"];
    $cpf = $_POST["CPF"];
    
    $filho->addChild('genero',$genero);
    $filho->addChild('data_nascimento',$nasc);
    $filho->addChild('cpf',$cpf);
} else if ($_POST["tipo"] == 'medico') {
    $espec = $_POST["especializacao"];
    $crm = $_POST["crm"];
    $filho->addChild('especializacao',$espec);
    $filho->addChild('crm',$crm);
    
} else if ($_POST["tipo"] == 'laboratorio') {
    $cnpj = $_POST["cnpj"];
    $filho->addChild('cnpj',$cnpj);
    if ($_POST["mamografia"] != NULL) {
        $filho->addChild("mamografia",$_POST["mamografia"]);
    } else if ($_POST["ressonancia"] != NULL) {
        $filho->addChild("ressonancia_magnetica",$_POST["ressonancia"]);
    } else if ($_POST["tomografia"] != NULL) {
        $filho->addChild("tomografia",$_POST["tomografia"]);
    } else if ($_POST["sonografia"] != NULL) {
        $filho->addChild("ultra_sonografia",$_POST["sonografia"]);
    }
}