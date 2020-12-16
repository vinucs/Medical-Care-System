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

    function getQueries() {
        $xml = simplexml_load_file("../back-end/consultas.xml");

        $queries = array();
        foreach($xml->children() as $querie) {
            if ((string)$querie->doctor_id == $_SESSION['id']) {
                $patient = getPatient((string)$querie->patient_id);
                $new_q = array($patient[0], $patient[1], (string)$querie->date, (string)$querie->sintomas);
                array_push($queries, $new_q);
            }
        }

        return $queries;
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
                    <li><a onclick="loadTab('queris historic')">Histórico de Consultas</a></li>
                    <li><a onclick="loadTab('change user')">Alterar Cadastro</a></li>
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
                    <input type="submit" value="Marcar" class="default-button">
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
                                echo "<td>$querie[0]</td>";
                                echo "<td>$querie[1]</td>";
                                echo "<td>$querie[2]</td>";
                                echo "<td>$querie[3]</td>";
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