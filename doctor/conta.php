<?php session_start();

    function getAllPatients() {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $cursor = $col->find(
                [ 'user_type' => 'patient' ]
        );

        $users = iterator_to_array($cursor);
        $patients = array();
        foreach($users as $user) {
                $new_p = array((string)$user->name, (string)$user->cpf, (string)$user['id']);
                array_push($patients, $new_p);
            }

        return $patients;
    }

    function getPatient($id) {
        require('mongodb.php');
        $col = $database->selectCollection('contas');
        $patient = $col->findOne(
                [ 'user_type' => 'patient' ]
        );
        if (!is_null($patient)) {
            return $patient;
        } else {
            return "Paciente não encontrado";
        }
    }

    function getQueries() {
        require('mongodb.php');
        $col = $database->selectCollection('consultas');
        $cursor = $col->find(
                [ 'doctor_id' => $_SESSION['id'] ]
        );
        $queries = iterator_to_array($cursor);

        if (!($queries)) {
            return "Não há consultas marcadas.";
        }

        $formatted_queries = array();
        foreach($queries as $querie) {
            if ((string)$querie->doctor_id == $_SESSION['id']) {
                $patient = getPatient((string)$querie->patient_id);
                $new_q = array((string)$querie['id'], $patient[0], $patient[1], (string)$querie->date, (string)$querie->sintomas);
                array_push($formatted_queries, $new_q);
            }
        }

        return $formatted_queries;
    }

    function getQuerieInfo() {
        require('mongodb.php');
        $col = $database->selectCollection('consultas');
        $querie_id = htmlspecialchars($_GET['querie']);
        $patient_name = htmlspecialchars($_GET['patient']);
        $query = $col->findOne(
            [ 'id' => $querie_id]
        );
        return $query;
    }

    if (isset($_GET['querie']) && !empty($_GET['querie'])) {
        $querie_info = getQuerieInfo();
    }
    else {
        unset($_GET);
    }

    if ($_SESSION['tipo'] != 'doctor'){
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
            <div class="acc-options">
                <ul>
                    <li><a onclick="loadTab('register queries')">Cadastrar Consultas</a></li>
                    <li><a onclick="loadTab('queries historic')">Histórico de Consultas</a></li>
                    <li><a onclick="loadTab('change user')">Altere sua Conta</a></li>
                </ul>
            </div>
            <div id="reg-queries-tab" class="content-section">
                <h1>Cadastre suas Consultas!</h1>
                <form id="changeuser-form" action="../back-end/register_queries.php" method="POST">
                    <div class="input-label">
                        <p>Paciente:</p>
                        <select name="patient" required>
                            <option value="nenhum">-------</option>
                            <?php
                                $patients = getAllPatients();
                                foreach($patients as $patient) {
                                    echo "<option value='$patient[2]'>$patient[0] - $patient[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-label">
                        <p>Data:</p>
                        <input type="date" name="date" value="2020-12-01" min="2020-12-01" max="2022-12-31" required>
                    </div>
                    <textarea name="sintomas" rows="10" cols="34" class="text-area" required>Sintomas.</textarea>
                    <button type="submit" form="changeuser-form" class="default-button">Marcar</button>
                </form>
            </div>
            <div id="queries-hist-tab" class="content-section" style="display: none;">
                <div class="hist-panel">
                    <h1>Histórico de Consultas.</h1>
                    <table>
                        <tr>
                            <th>Paciente</th>
                            <th>CPF</th>
                            <th>Data</th>
                            <th>Sintomas</th>
                            <th></th>
                        </tr>
                        <?php
                            $queries = getQueries();
                            foreach($queries as $querie) {
                                echo "<tr>";
                                echo "<td>$querie[1]</td>";
                                echo "<td>$querie[2]</td>";
                                echo "<td>$querie[3]</td>";
                                echo "<td>$querie[4]</td>";
                                echo "<td><a href='conta.php?querie=$querie[0]&patient=$querie[1]' onclick=\"loadTab('change querie')\"><u>Alterar</u></a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div id="config-acc-tab" class="content-section" style="display: none;">
                <h1>Configurar Conta.</h1>
                <form id="change-user-form" action="../back-end/change_credentials.php" method="POST" onsubmit="return validateChangeUserForm()" >
                    <input type="email" placeholder="Novo email" name="email">
                    <input type="text" placeholder="Novo endereço" name="adress">
                    <input type="tel" placeholder="Novo telefone" name="tel" onkeydown="fMasc(this, mTel);">
                    <input type="password" placeholder="Nova Senha" name="new_password">
                    <input type="password" placeholder="Confirme a Senha" name="new_cpassword">
                    <br>
                    <div class="input-label">
                        <label for="password"><p>Senha atual necessária:</p></label>
                        <input type="password" placeholder="Senha Atual" name="password" required>
                    </div>
                    <button type="submit" form="change-user-form" class="default-button">Mudar</button>
                </form>
            </div>
            <div id="change-querie-form-tab" class="content-section" style="display: none;">
                <?php echo "<h1>Altere a consulta de $querie_info[1].</h1>"; 
                    echo "<form id='change-querie-form' action='../back-end/change_querie.php?querie=$querie_info[0]' method='POST'>";
                    echo "<input type='date' name='date' value=$querie_info[2] min='2020-12-01' max='2022-12-31'>";
                    echo "<textarea name='sintomas' rows='10' cols='34' class='text-area'>$querie_info[3]</textarea>";
                    ?>
                    <div class="inline-content">
                        <a href="conta.php" onclick="loadTab('queries hist')"><i><u>Voltar</i></u></a>
                        <button type="submit" form="change-querie-form" class="default-button">Alterar</button>
                    </div>   
                </form>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>