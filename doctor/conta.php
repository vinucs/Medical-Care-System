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

    function getQueries() {
        $xml = simplexml_load_file("../back-end/consultas.xml");
        $queries = array();
        foreach($xml->children() as $querie) {
            if ((string)$querie->doctor_id == $_SESSION['id']) {
                $new_q = array((string)$querie->patient, (string)$querie->date, (string)$querie->sintomas);
                $queries = array_merge($queries, $new_q);
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
                            <th>Data</th>
                            <th>Sintomas</th>
                            <th></th>
                        </tr>
                        <?php
                            $queries = getQueries();
                            echo "<tr>";
                            $cont = 0;
                            for($i = 0; $i < count($queries); $i++) {
                                echo "<td>$queries[$i]</td>";
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