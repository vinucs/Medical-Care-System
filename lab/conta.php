<?php session_start();

    function getAllPatients() {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('contas');
        $cursor = $col->find(
            array(
                'user_type' => 'patient'
            )
        );
        $result = iterator_to_array($cursor);
        return $result;

    }

    function getPatient($id) {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('contas');
        $result = $col->findOne(
            array(
                'id' => $id
            )
        );
        if (!empty($result)) {
            return $result;
        } else {
            return "Paciente não encontrado";
        }
    }

    function getExamsType() {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('contas');
        $result = $col->findOne(
            [ 'id' => $_SESSION['id'] ]
            );
        #$result = iterator_to_array($cursor);
        $exam_types = array_values($result['exames']);
        return $exam_types;
    }

    function getExams() {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('exames');
        $cursor = $col->find(
            [ 'lab_id' => $_SESSION['id'] ]
            );
        $result = iterator_to_array($cursor);
        return $result;
        $exams = array();
        foreach($result as $exam) {
            if ((string)$exam->lab_id == $_SESSION['id']) {
                $patient = getPatient((string)$exam['patient_id']);
                $new_e = array((string)$exam['id'], $patient['name'], $patient['cpf'], (string)$exam['date'], (string)$exam['exam_type']);
                array_push($exams, $new_e);
            }
        }

        return $exams;
    }

    function getExamInfo() {
        require("../back-end/mongodb.php");

        $exam_id = htmlspecialchars($_GET['exam']);
        $patient_name = htmlspecialchars($_GET['patient']);

        $exam_info = array();
        array_push($exam_info, $exam_id);
        array_push($exam_info, $patient_name);
        $col = $database->selectCollection('exames');
        $cursor = $col->find(
            [ 'id' => $exam_id ]
            );
        $result = iterator_to_array($cursor);
        #return $result;
        foreach($result as $exam) {
            array_push($exam_info, (string)$exam['date']);
            array_push($exam_info, (string)$exam['exam_type']);
        }

        return $exam_info;
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

    if (isset($_GET['exam']) && !empty($_GET['exam'])) {
        $exam_info = getExamInfo();
    }
    else {
        unset($_GET);
    }

    if ($_SESSION['tipo'] != 'lab'){
        session_destroy();
        header("Location: ../index.php");
    }

    $exams = getExams();
    uasort($exams, 'compareFunction');
    $exams_date = array();
    foreach($exams as $e) {
        array_push($exams_date, $e['date']);
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
        <script type='text/javascript'>var exams = <?php echo json_encode($exams_date)?>;</script>
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
                    <li><a onclick="loadTab('register exams')">Cadastrar Exames</a></li>
                    <li><a onclick="loadTab('exams historic')">Histórico de Exames</a></li>
                    <li><a onclick="loadTab('statistics')">Estatísticas</a></li>
                    <li><a onclick="loadTab('change user')">Altere sua Conta</a></li>
                </ul>
            </div>
            <div id="reg-exams-tab" class="content-section" style="display: none;">>
                <h1>Cadastre seus Exames!</h1>
                <form id="reg-exam-form" action="../back-end/register_exams.php" method="POST">
                    <div class="input-label">
                        <p>Paciente:</p>
                        <select name="patient" required>
                            <option value="nenhum">-------</option>
                            <?php
                                $patients = getAllPatients();
                                foreach($patients as $patient) {
                                    $id = $patient["id"];
                                    $name = $patient["name"];
                                    $cpf = $patient["cpf"];
                                    echo "<option value='$patient->id'>$patient->name - $patient->cpf</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-label">
                        <p>Data:</p>
                        <input type="date" name="date" value="2020-12-01" min="2018-01-01" max="2022-12-31" required>
                    </div>
                    <div class="input-label">
                        <p>Selecionar exame:</p>
                        <select name="exam-type" required>
                            <option value="nenhum">-------</option>
                            <?php
                                $exams_type = getExamsType();
                                foreach($exams_type as $exam) {
                                    echo "<option value='$exam'>$exam</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" form="reg-exam-form" class="default-button">Marcar</button>
                </form>
            </div>
            <div id="exams-hist-tab" class="content-section" style="display:none;">
                <div class="hist-panel">
                    <h1>Histórico de Exames.</h1>
                    <table>
                        <tr>
                            <th>Paciente</th>
                            <th>CPF</th>
                            <th>Data</th>
                            <th>Exame</th>
                            <th></th>
                        </tr>
                    <?php
                        foreach($exams as $exam) {
                            $name = $exam['name'];
                            $cpf = $exam['cpf'];
                            $date = $exam['date'];
                            $exam_type = $exam['exam_type'];
                            $id = $exam['id'];
                            echo "<tr>";
                            echo "<td>$name</td>";
                            echo "<td>$cpf</td>";
                            echo "<td>$date</td>";
                            echo "<td>$exam_type</td>";
                            echo "<td><a href='conta.php?exam=$id&patient=$name' onclick=\"loadTab('change exam')\"><u>Alterar</u></a></td>";
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
            <div id="change-user-tab" class="content-section" style="display: none;">
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
            <div id="change-exam-form-tab" class="content-section" style="display: none;">
                <?php 
                    $patient_name = $exam_info[1];
                    $exam_id = $exam_info[0];
                    $exam_date = $exam_info[2];
                    $exam_type = $exam_info[3];
                    echo "<h1>Altere o exame de $patient_name</h1>"; 
                    echo "<form id='change-exam-form' action='../back-end/change_exam.php?exam=$exam_id' method='POST'>";
                    echo "<div class='input-label'>
                        <p>Selecionar data:</p>
                        <input type='date' name='date' value=$exam_date min='2020-12-01' max='2022-12-31'></div>";
                    echo "<div class='input-label'>
                        <p>Selecionar exame:</p>
                        <select name='exam_type'>
                            <option value=''>----------</option>";
                    $exams_type = getExamsType();
                    foreach($exams_type as $exam) {
                        if ($exam == $exam_type)
                            echo "<option value='$exam' selected>$exam</option>";
                        else
                            echo "<option value='$exam'>$exam</option>";
                    }
                    echo "</select></div>";
                    ?>
                    <div class="inline-content">
                        <a href="conta.php" onclick="loadTab('exams historic')"><i><u>Voltar</i></u></a>
                        <button type="submit" form="change-exam-form" class="default-button">Alterar</button>
                    </div>   
                </form>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>