<?php session_start();

    function getAllPatients() {
        require('../back-end/mongodb.php');
        $col = $database->selectCollection('contas');
        $cursor = $col->find(
                [ 'user_type' => 'patient' ]
        );

        $patients = iterator_to_array($cursor);
        return $patients;
    }

    function getPatient($id) {
        require('../back-end/mongodb.php');
        $col = $database->selectCollection('contas');
        $patient = $col->findOne(
                [ 'user_type' => 'patient' ]
        );
        return $patient;
    }

    function getQueries() {
        require('../back-end/mongodb.php');
        $col = $database->selectCollection('consultas');
        $cursor = $col->find(
                [ 'doctor_id' => $_SESSION['id'] ]
        );
        $queries = iterator_to_array($cursor);
        return $queries;
    }

    function getQuerieInfo() {
        require('../back-end/mongodb.php');
        $col = $database->selectCollection('consultas');
        $querie_id = htmlspecialchars($_GET['querie']);
        $query = $col->findOne(
            [ 'id' => $querie_id]
        );
        return $query;
    }

    function compareFunction($a, $b) {
        $a_year = (int)substr($a['date'], 0, 4);
        $b_year = (int)substr($b['date'], 0, 4);
        if ($a_year < $b_year)
            return 1;
        if ($a_year > $b_year)
            return -1;

        $a_month = (int)substr($a['date'], 5, 2);
        $b_month = (int)substr($b['date'], 5, 2);
        if ($a_month < $b_month)
            return 1;
        if ($a_month > $b_month)
            return -1;

        $a_day = (int)substr($a['date'], 8, 2);
        $b_day = (int)substr($b['date'], 8, 2);
        if ($a_day < $b_day)
            return 1;
        if ($a_day > $b_day)
            return -1;

        return 0;
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

    $queries = getQueries();
    uasort($queries, 'compareFunction');
    $queries_date = array();
    foreach($queries as $q) {
        array_push($queries_date, $q['date']);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>EzMed</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <!--scripts-->
        <script type='text/javascript'>var queries = <?php echo json_encode($queries_date)?>;</script>
        <script defer src="scripts.js"></script>
        <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
        <!-- CSS -->
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
            <div class="acc-options" id="acc-options-tab" style="display: none;">
                <ul>
                    <li><a onclick="loadTab('register queries')">Cadastrar Consultas</a></li>
                    <li><a onclick="loadTab('queries historic')">Histórico de Consultas</a></li>
                    <li><a onclick="loadTab('statistics')">Estatísticas</a></li>
                    <li><a onclick="loadTab('change user')">Altere sua Conta</a></li>
                </ul>
            </div>
            <div id="reg-queries-tab" class="content-section" style="display: none;">
                <h1>Cadastre suas Consultas!</h1>
                <form id="changeuser-form" action="../back-end/register_queries.php" method="POST">
                    <div class="input-label">
                        <p>Paciente:</p>
                        <select name="patient" required>
                            <option value="nenhum">-------</option>
                            <?php
                                $patients = getAllPatients();
                                foreach($patients as $patient) {
                                    $id = $patient['id'];
                                    $name = $patient['name'];
                                    $cpf = $patient['cpf'];
                                    echo "<option value='$id'>$name - $cpf</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-label">
                        <p>Data:</p>
                        <input type="date" name="date" value="2020-12-01" min="2018-01-01" max="2022-12-31" required>
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
                            foreach($queries as $querie) {
                                $name = $querie['patient_name'];
                                $cpf = $querie['patient_cpf'];
                                $date = $querie['date'];
                                $symptoms = $querie['sintomas'];
                                $patient_id = $querie['patient_id'];
                                $querie_id = $querie['id'];
                                echo "<tr>";
                                echo "<td>$name</td>";
                                echo "<td>$cpf</td>";
                                echo "<td>$date</td>";
                                echo "<td>$symptoms</td>";
                                echo "<td><a href='conta.php?querie=$querie_id&patient=$patient_id' onclick=\"loadTab('change querie')\"><u>Alterar</u></a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div id="statistics-tab" class="content-section" style="display: none;">
                <h1>Veja suas estatísticas!</h1>
                <div class="select-style">
                    <div class="inline-content">
                        <p>Escolha o ano:</p>
                        <select onchange="selectedYear.call(this, event)">
                            <option value='----'>----</option>
                            <option value='2018'>2018</option>
                            <option value='2019'>2019</option>
                            <option value='2020'>2020</option>
                            <option value='2021'>2021</option>
                            <option value='2022'>2022</option>
                        </select>
                    </div>
                </div>
                <div id='chart'></div>
                <div class="select-style">
                    <div class="inline-content">
                        <p>Média Mensal:</p>
                        <p id="media-mes">--</p>
                    </div>
                    <div class="inline-content">
                        <p>Total Anual:</p>
                        <p id="total-ano">--</p>
                    </div>
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
                <?php 
                    $patient_name = $querie_info['patient_name'];
                    $query_id = $querie_info['id'];
                    $date = $querie_info['date'];
                    $symptoms = $querie_info['sintomas'];
                    echo "<h1>Altere a consulta de $patient_name.</h1>"; 
                    echo "<form id='change-querie-form' action='../back-end/change_querie.php?querie=$query_id' method='POST'>";
                    echo "<input type='date' name='date' value=$date min='2020-12-01' max='2022-12-31'>";
                    echo "<textarea name='sintomas' rows='10' cols='34' class='text-area'>$symptoms</textarea>";
                    ?>
                    <div class="inline-content">
                        <a href="conta.php" onclick="loadTab('queries historic')"><i><u>Voltar</i></u></a>
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