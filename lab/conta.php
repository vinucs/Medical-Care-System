<?php session_start();

    function getAllPatients() {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $patients = array();
        foreach($xml->children() as $user) {
            if ((string)$user['type'] == 'patient') {
                $new_p = array((string)$user->name, (string)$user->cpf, (string)$user['id']);
                array_push($patients, $new_p);
            }
        }

        return $patients;
    }

    function getPatient($id) {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $patient = array();
        foreach($xml->children() as $user) {
            if ((string)$user['id'] == $id) {
                array_push($patient, (string)$user->name);
                array_push($patient, (string)$user->cpf);
                return $patient;
            }
        }

        array_push($patient, "Pacient not found");
        array_push($patient, "Pacient not found");
        return $patient;
        
    }

    function getExamsType() {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $exams = array();
        foreach($xml->children() as $user) {
            if ((string)$user['id'] == $_SESSION['id']) {
                foreach($user->children() as $elem) {
                    if ($elem->getName() == 'exame')
                        $exams[] = (string)$elem;
                }
                break;
            }
        }

        return $exams;
    }

    function getExams() {
        $xml = simplexml_load_file("../back-end/exames.xml");

        $exams = array();
        foreach($xml->children() as $exam) {
            if ((string)$exam->lab_id == $_SESSION['id']) {
                $patient = getPatient((string)$exam->patient_id);
                $new_e = array((string)$exam['id'], $patient[0], $patient[1], (string)$exam->date, (string)$exam->exam_type);
                array_push($exams, $new_e);
            }
        }

        return $exams;
    }

    function getExamInfo() {
        $xml = simplexml_load_file("../back-end/exames.xml");
        $exam_id = htmlspecialchars($_GET['exam']);
        $patient_name = htmlspecialchars($_GET['patient']);

        $exam_info = array();
        array_push($exam_info, $exam_id);
        array_push($exam_info, $patient_name);
        foreach($xml->children() as $exam) {
            if ((string)$exam['id'] == $exam_id) {
                array_push($exam_info, (string)$exam->date);
                array_push($exam_info, (string)$exam->exam_type);

                break;
            }
        }

        return $exam_info;
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
                    <li><a onclick="loadTab('register exams')">Cadastrar Exames</a></li>
                    <li><a onclick="loadTab('exams historic')">Histórico de Exames</a></li>
                    <li><a onclick="loadTab('change user')">Altere sua Conta</a></li>
                </ul>
            </div>
            <div id="reg-exams-tab" class="content-section">
                <h1>Cadastre seus Exames!</h1>
                <form id="reg-exam-form" action="../back-end/register_exams.php" method="POST">
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
                    <div class="input-label">
                        <p>Selecionar exame:</p>
                        <select name="exam-type" required>
                            <option value="nenhum">-------</option>
                            <?php
                                $exams = getExamsType();
                                foreach($exams as $exam) {
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
                        $exams = getExams();
                        foreach($exams as $exam) {
                            echo "<tr>";
                            echo "<td>$exam[1]</td>";
                            echo "<td>$exam[2]</td>";
                            echo "<td>$exam[3]</td>";
                            echo "<td>$exam[4]</td>";
                            echo "<td><a href='conta.php?exam=$exam[0]&patient=$exam[1]' onclick=\"loadTab('change exam')\"><u>Alterar</u></a></td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>
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
                <?php echo "<h1>Altere o exame de $exam_info[1].</h1>"; 
                    echo "<form id='change-exam-form' action='../back-end/change_exam.php?exam=$exam_info[0]' method='POST'>";
                    echo "<div class='input-label'>
                        <p>Selecionar data:</p>
                        <input type='date' name='date' value=$exam_info[2] min='2020-12-01' max='2022-12-31'></div>";
                    echo "<div class='input-label'>
                        <p>Selecionar exame:</p>
                        <select name='exam_type'>
                            <option value=''>----------</option>";
                    $exams = getExamsType();
                    foreach($exams as $exam) {
                        if ($exam == $exam_info[3])
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