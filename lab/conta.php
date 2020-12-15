<?php session_start();

    function getPatient() {
        $xml = simplexml_load_file("../back-end/contas.xml");

        $patients = array();
        foreach($xml->children() as $user) {
            if ((string)$user['type'] == 'patient') {
                $patients[] = (string)$user->name;
            }
        }
        return $patients;
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
                $new_e = array((string)$exam->patient, (string)$exam->date, (string)$exam->exam_type);
                $exams = array_merge($exams, $new_e);
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
                    <li class="navbar"><a href="../services.html">Serviços</a></li>
                    <li class="navbar"><a href="../history.html">História</a></li>
                    <li class="navbar"><a href="../contact.html">Fale com a EzMed</a></li>
                </ul>
            </nav>
            <div id="acc-header">
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
                                $patients = getPatient();
                                foreach($patients as $patient) {
                                    echo "<option value='$patient'>$patient</option>";
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
                            <th>Data</th>
                            <th>Exame</th>
                            <th></th>
                        </tr>
                    <?php
                        $exams = getExams();
                        echo "<tr>";
                        $cont = 0;
                        for($i = 0; $i < count($exams); $i++) {
                            echo "<td>$exams[$i]</td>";
                            $cont++;
                            if ($cont == 3){
                                echo "<td>Alterar</td>";
                                echo "</tr><tr>";
                                $cont = 0;
                            }
                        }
                        echo "</tr>";
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