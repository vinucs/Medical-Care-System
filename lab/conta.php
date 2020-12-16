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
                $new_e = array($patient[0], $patient[1], (string)$exam->date, (string)$exam->exam_type);
                array_push($exams, $new_e);
            }
        }

        return $exams;
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
                    <input type="submit" value="Marcar" class="default-button">
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
                            echo "<td>$exam[0]</td>";
                            echo "<td>$exam[1]</td>";
                            echo "<td>$exam[2]</td>";
                            echo "<td>$exam[3]</td>";
                            echo "<td>Alterar</td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>