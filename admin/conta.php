<?php session_start();

    function getUsers() {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $users = array();
        foreach($xml->children() as $user) {
            if ((string)$user['id'] != $_SESSION['id']) {
                $new_u = array((string)$user['type'], (string)$user->name, (string)$user->email, (string)$user['id']);
                array_push($users, $new_u);
            }
        }

        return $users;
    }

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
            <div class="acc-options" id="acc-options-tab">
                <ul>
                    <li><a onclick="loadTab('register user')">Cadastrar Usuário</a></li>
                    <li><a onclick="loadTab('change user')">Alterar Cadastros</a></li>
                    <li><a onclick="loadTab('config acc')">Alterar Credenciais</a></li>
                </ul>
            </div>
            <div id="register-user-tab" class="content-section" style="display: none;">
                <h1>Cadastre um usuário.</h1>
                <form id="register-form" action="../back-end/register_user.php" method="POST" onsubmit="return validateRegisterForm()">
                    <input type="text" placeholder="Nome Completo" name="name" required>
                    <input type="text" placeholder="Endereço" name="adress"required>
                    <input type="tel" placeholder="Telefone" name="tel" onkeydown="fMasc(this, mTel);" required>
                    <input type="email" placeholder="Email" name="email" required>
                    <input type="password" placeholder="Senha" name="password" required>
                    <input type="password" placeholder="Confirmar Senha" name="cpassword" required>
                    <div class="select-style">
                        <p>Usuário:</p>
                        <div class="check-selection">
                            <div class="check-input">
                                <input type="radio" id="patient-check" name="user_type" value="patient" onclick="loadUserForm('patient form')">
                                <label for="patient">Paciente</label>
                            </div>
                            <div class="check-input">
                                <input type="radio" id="doctor-check" name="user_type" value="doctor" onclick="loadUserForm('doctor form')">
                                <label for="doctor">Médico</label>
                            </div>
                            <div class="check-input">
                                <input type="radio" id="lab-check" name="user_type" value="lab" onclick="loadUserForm('lab form')">
                                <label for="lab">Laboratório</label>          
                            </div>
                        </div>
                    </div>
                    <div id="patient-form" class="content-section">
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
                    <input type="submit" value="Cadastre-se" class="default-button">          
                </form>
            </div>
            <div id="change-user-tab" class="content-section" style="display: none;">
                <h1>Escolha um usuário para alterar.</h1>
                <table>
                    <tr>
                        <th>Usuário</th>
                        <th>Tipo</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    <?php
                        $users = getUsers();
                        foreach($users as $user) {
                            echo "<tr>";
                            echo "<td>$user[0]</td>";
                            echo "<td>$user[1]</td>";
                            echo "<td>$user[2]</td>";
                            echo "<td><a href='conta.php?user=$user[3]' onclick=\"loadTab('user form')\">Alterar</a></td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>              
            </div>
            <div id="config-acc-tab" class="content-section" style="display: none;">
                <h1>Configure suas credenciais.</h1>
                <form id="changeuser-form" action="../back-end/change_credentials.php" method="POST" onsubmit="return validateChangeUserForm()" >
                    <input type="email" placeholder="Novo email" name="email">
                    <input type="password" placeholder="Nova Senha" name="new_password">
                    <input type="password" placeholder="Confirme a Senha" name="new_cpassword">
                    <br>
                    <div class="input-label">
                        <label for="password"><p>Senha atual necessária:</p></label>
                        <input type="password" placeholder="Senha Atual" name="password" required>
                    </div>
                    <input type="submit" value="Mudar" class="default-button">
                </form>
            </div>
            <div id="change-user-form-tab" class="content-section">
                <?php echo "<h1>Mude o usuário $user_info[0]</h1>"; ?>
                <form id="register-form" action="../back-end/change_user.php" method="POST" onsubmit="return validateRegisterForm()">
                    <?php
                        echo "<input type='text' placeholder='$user_info[0]' name='name'>";
                        echo "<input type='text' placeholder='$user_info[1]' name='adress'>";
                        echo "<input type='tel' placeholder='$user_info[2]' name='tel' onkeydown='fMasc(this, mTel);'>";
                        echo "<input type='email' placeholder='$user_info[3]' name='email'>";
                        echo "<input type='password' placeholder='Nova Senha' name='password'>";
                        echo "<input type='password' placeholder='Confirmar Senha' name='cpassword'>";

                        if (end($user_info) == 'patient') {
                            echo "<div class='select-style'>
                                    <p>Sexo:</p>
                                    <select id='genero' name='sex'>
                                        <option value='nenhum'>----------</option>
                                        <option value='masculino'>Masculino</option>
                                        <option value='feminino'>Feminino</option>
                                    </select>
                                </div>
                                <input type='tel' placeholder=$user_info[6] name='age' onkeydown='fMasc(this, mNum);'>
                                <input type='tel' placeholder=$user_info[7] name='cpf' onkeydown='fMasc(this, mCPF);'>";
                        }
                        else if (end($user_info) == 'doctor') {
                            echo "<div class='select-style'>
                                    <p>Especialidade:</p>
                                    <select id='especialidade' name='especialidade'>
                                        <option value='nenhuma'>--------------</option>
                                        <option value='cardiologista'>Cardiologista</option>
                                        <option value='pediatra'>Pediatra</option>
                                        <option value='psiquiatra'>Psiquiatra</option>
                                        <option value='psicologo'>Psicólogo</option>
                                    </select>
                                </div>
                                <input type='text' placeholder=$user_info[6] name='crm' onkeydown='fMasc(this, mNum);'>";
                        }
                        else if (end($user_info) == 'lab') {
                            echo "<div class='select-style'>
                                    <p>Exames Realizados: </p>
                                    <div class='check-selection'>
                                        <div class='check-input'>
                                            <input type='checkbox' name='mamografia' value='Mamografia'>
                                            <label for='mamografia'>Mamografia</label>
                                        </div>
                                        <div class='check-input'>
                                            <input type='checkbox' name='ressonancia' value='Ressonancia Magnética'>
                                            <label for='ressonancia'>Ressonância Magnética</label>
                                        </div>
                                        <div class='check-input'>
                                            <input type='checkbox' name='tomografia' value='Tomografia'>
                                            <label for='tomografia'>Tomografia</label>
                                        </div>
                                        <div class='check-input'>
                                            <input type='checkbox' name='sonografia' value='Sonografia'>
                                            <label for='sonografia'>Ultra-sonografia</label>
                                        </div>
                                    </div>
                                </div>
                                <input type='text' placeholder=$user_info[5] name='cnpj' onkeydown='fMasc(this, mCNPJ);'>";
                        }

                    ?>

                    <div id="doctor-change-form" class="content-section" style="display:none">

                    </div>
                    <div id="lab-change-form" class="content-section" style="display:none">
                        
                    </div>
                    <div class="select-style">
                        <a href="conta.php" onclick="loadTab('change user')">Voltar</a>
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