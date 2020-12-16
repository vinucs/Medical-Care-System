<?php session_start();

    function getUserInfo($ch_user) {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $user_info = array();
        foreach($xml->children() as $user) {
            if ((string)$user['id'] == $ch_user) {
                foreach($user->children() as $elem)
                    array_push($user_info, (string)$elem);
                    
                array_push($user_info, (string)$user['type']);
                break;
            }
        }

        return $user_info;
    }

    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $user_info = getUserInfo(addslashes($_GET['user']));
    }
    else {
        unset($_GET);
        echo "<script>
        window.location.replace('../admin/conta.php')
        alert('Usuário inválido.');
        </script>";
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>EzMed</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <!--swup-->
        <script defer src="scripts.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../styles.css">
    </head>
    <body>
        <header class="header">
            <a href="../home.html"><img class="logo" src="../images/EzMedLogo.png" alt="logo"></a>
            <nav>
                <ul class="navbar">
                    <li><a href="../services.html">Serviços</a></li>
                    <li><a href="../services.html">História</a></li>
                    <li><a href="../contact.html">Fale com a EzMed</a></li>
                </ul>
            </nav>
            <div class="acc-header">
                <a href="conta.php" id="acc-ref"><button class="default-button">Conta</button></a>
                <a href="../back-end/logout.php" onclick="logout()"><img id="logout-img" src="../images/logout.png"></a>
            </div>
        </header>        
        <div class="container">
            <div id="change-user-form" class="content-section">
                <h1>Cadastre um usuário.</h1>
                <form id="register-form" action="../back-end/register_user.php" method="POST" onsubmit="return validateRegisterForm()">
                    <?php
                        echo "<input type='text' placeholder='$user_info[0]' name='name'>";
                        echo "<input type='text' placeholder='$user_info[1]' name='adress'>";
                        echo "<input type='tel' placeholder='$user_info[2]' name='tel' onkeydown='fMasc(this, mTel);'>";
                        echo "<input type='email' placeholder='$user_info[3]' name='email'>";
                        echo "<input type='password' placeholder='Nova Senha' name='password'>";
                        echo "<input type='password' placeholder='Confirmar Senha' name='cpassword'>";
                    ?>
                    <div id="patient-form" class="content-section" style="display:none">
                        <div class="select-style">
                            <p>Sexo:</p>
                            <select id="genero" name="sex">
                                <option value="nenhum">-</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                        </div>
                        <input type="tel" placeholder="Idade" name="age" onkeydown="fMasc(this, mNum);">
                        <input type="tel" placeholder="CPF" name="cpf" onkeydown="fMasc(this, mCPF);">
                    </div>
                    <div id="doctor-form" class="content-section" style="display:none">
                        <div class="select-style">
                            <p>Especialidade:</p>
                            <select id="especialidade" name="especialidade">
                                <option value="nenhuma">-</option>
                                <option value="cardiologista">Cardiologista</option>
                                <option value="pediatra">Pediatra</option>
                                <option value="psiquiatra">Psiquiatra</option>
                                <option value="psicologo">Psicólogo</option>
                            </select>
                        </div>
                        <input type="text" placeholder="CRM" name="crm" onkeydown="fMasc(this, mNum);">
                    </div>
                    <div id="lab-form" class="content-section" style="display:none">
                        <div class="select-style">
                            <p>Exames Realizados: </p>
                            <div class="check-selection">
                                <div class="check-input">
                                    <input type="checkbox" name="mamografia" value="Mamografia">
                                    <label for="mamografia">Mamografia</label>
                                </div>
                                <div class="check-input">
                                    <input type="checkbox" name="ressonancia" value="Ressonancia Magnética">
                                    <label for="ressonancia">Ressonância Magnética</label>
                                </div>
                                <div class="check-input">
                                    <input type="checkbox" name="tomografia" value="Tomografia">
                                    <label for="tomografia">Tomografia</label>
                                </div>
                                <div class="check-input">
                                    <input type="checkbox" name="sonografia" value="Sonografia">
                                    <label for="sonografia">Ultra-sonografia</label>
                                </div>
                            </div>
                        </div>
                        <input type="text" placeholder="CNPJ" name="cnpj" onkeydown="fMasc(this, mCNPJ);">
                    </div>
                    <div class="select-style">
                        <a href="conta.php">Voltar</a>
                        <input type="submit" value="Cadastre-se" class="default-button"> 
                    </div>   
                </form>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>