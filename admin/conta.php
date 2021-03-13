<?php session_start();

    require('mongodb.php');

    function getUsers() {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $cursor = $col->find();
        $users = iterator_to_array($cursor);
        return $users;
    }

    function getUserInfo($ch_user) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $user_info = $col->findOne(
                    ['id' => $ch_user]
                    );
                    
        #array_push($user_info, (string)$user['type']);
        return $user_info;
    }

    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $user_info = getUserInfo(addslashes($_GET['user']));
    }
    else {
        unset($_GET);
    }

    if ($_SESSION['tipo'] != 'admin'){
        session_destroy();
        header("Location: ../index.php");
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
                    <li><a onclick="loadTab('config acc')">Mudar Credenciais</a></li>
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
                                    <input type="checkbox" name="sonografia" value="Ultra-Sonografia">
                                    <label for="sonografia">Ultra-sonografia</label>
                                </div>
                            </div>
                        </div>
                        <input type="text" placeholder="CNPJ" name="cnpj" onkeydown="fMasc(this, mCNPJ);">
                    </div>
                    <button type="submit" form="register-form" class="default-button">Cadastre-se</button>         
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
                            $user_type = $user['user_type'];
                            $name = $user['name'];
                            $email = $user['email'];
                            $id = 'id';
                            echo "<tr>";
                            echo "<td>$name</td>";
                            echo "<td>$user_type</td>";
                            echo "<td>$email</td>";
                            echo "<td><a href='conta.php?user=$user[$id]' onclick=\"loadTab('user form')\"><u>Alterar</u></a></td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>              
            </div>
            <div id="config-acc-tab" class="content-section" style="display: none;">
                <h1>Configure suas credenciais.</h1>
                <form id="change-cred-form" action="../back-end/change_credentials.php" method="POST" onsubmit="return validateChangeCredentialsForm()" >
                    <input type="email" placeholder="Novo email" name="email">
                    <input type="password" placeholder="Nova Senha" name="new_password">
                    <input type="password" placeholder="Confirme a Senha" name="new_cpassword">
                    <br>
                    <div class="input-label">
                        <label for="password"><p>Senha atual necessária:</p></label>
                        <input type="password" placeholder="Senha Atual" name="password" required>
                    </div>
                    <button type="submit" form="change-cred-form" class="default-button">Mudar</button>
                </form>
            </div>
            <div id="change-user-form-tab" class="content-section">
                <?php 
                    $name = $user_info['name'];
                    $adress = $user_info['adress'];
                    $tel = $user_info['telephone'];
                    $email = $user_info['email'];
                    $password = $user_info['password'];
                    echo "<h1>Mude o usuário $name.</h1>"; 
                    echo "<form id='change-user-form' action='../back-end/change_user.php?user=$user_info[$id]' method='POST' onsubmit='return validateChangeUserForm()'>";
                ?>
                    <script type="text/javascript">
                        var change_user_type = "<?php echo end($user_info); ?>";
                    </script>
                    <?php
                        echo "<input type='text' placeholder='Nome' name='name' value=''>";
                        echo "<input type='text' placeholder='Endereço' name='adress' value=''>";
                        echo "<input type='tel' placeholder='Telefone' name='tel' value='' onkeydown='fMasc(this, mTel);'>";
                        echo "<input type='email' placeholder='Email' name='email' value=''>";
                        echo "<input type='password' placeholder='Nova Senha' name='password' value=''>";
                        echo "<input type='password' placeholder='Confirmar Senha' name='cpassword' value=''>";

                        if (end($user_info) == 'patient') {
                            echo "<div class='select-style'>
                                    <p>Sexo:</p>
                                    <select id='genero' name='sex'>
                                        <option value=''>----------</option>";
                            if ($user_info[6] == 'masculino') {
                                echo "<option value='masculino' selected>Masculino</option>
                                    <option value='feminino'>Feminino</option>";
                            }
                            else {
                                echo "<option value='masculino'>Masculino</option>
                                    <option value='feminino' selected>Feminino</option>";
                            }
                            echo "</select>
                                    </div>
                                    <input type='tel' placeholder='$user_info[7]' name='age' value='$user_info[7]' onkeydown='fMasc(this, mNum);'>
                                    <input type='tel' placeholder='$user_info[8]' name='cpf' value='$user_info[8]' onkeydown='fMasc(this, mCPF);'>";
                        }
                        else if (end($user_info) == 'doctor') {
                            echo "<div class='select-style'>
                                    <p>Especialidade:</p>
                                    <select id='especialidade' name='especialidade'>
                                        <option value=''>--------------</option>
                                        <option value='cardiologista'>Cardiologista</option>
                                        <option value='pediatra'>Pediatra</option>
                                        <option value='psiquiatra'>Psiquiatra</option>
                                        <option value='psicologo'>Psicólogo</option>
                                    </select>
                                </div>
                                <input type='text' placeholder='$user_info[7]' name='crm' value='$user_info[7]' onkeydown='fMasc(this, mNum);'>";
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
                                <input type='text' placeholder='$user_info[6]' name='cnpj' value='$user_info[6]' onkeydown='fMasc(this, mCNPJ);'>";
                        }

                    ?>
                    <div class="inline-content">
                        <a href="conta.php" onclick="loadTab('change user')"><i><u>Voltar</i></u></a>
                        <button type="submit" form="change-user-form" class="default-button">Alterar</button>
                    </div>   
                </form>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>