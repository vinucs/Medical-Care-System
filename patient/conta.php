<?php session_start();

    function getQueries() {
        $xml = simplexml_load_file("../back-end/consultas.xml");

        $queries = array();
        foreach($xml->children() as $querie) {
            if ((string)$querie->patient_id == $_SESSION['id']) {
                $new_q = array((string)$querie->doctor, (string)$querie->date, (string)$querie->sintomas);
                $queries = array_merge($queries, $new_q);
            }
        }

        return $queries;
    }

    function getExams() {
        $xml = simplexml_load_file("../back-end/exames.xml");
        
        $exams = array();
        foreach($xml->children() as $exam) {
            if ((string)$exam->patient_id == $_SESSION['id']) {
                $new_e = array((string)$exam->lab, (string)$exam->date, (string)$exam->exam_type);
                $exams = array_merge($exams, $new_e);
            }
        }

        return $exams;
    }

    if ($_SESSION['tipo'] != 'patient'){
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
                    <li><a onclick="loadTab('queries tab')">Suas Consultas</a></li>
                    <li><a onclick="loadTab('exams tab')">Seus Exames</a></li>
                </ul>
            </div>
            <div id="queries-tab" class="content-section">
                <div class="hist-panel">
                    <h1>Histórico de Consultas.</h1>
                    <table>
                        <tr>
                            <th>Médico</th>
                            <th>Data</th>
                            <th>Sintomas</th>
                        </tr>
                    <?php
                        $queries = getQueries();
                        echo "<tr>";
                        $cont = 0;
                        for($i = 0; $i < count($queries); $i++) {
                            echo "<td>$queries[$i]</td>";
                            $cont++;
                            if ($cont == 3){
                                echo "</tr><tr>";
                                $cont = 0;
                            }
                        }
                        echo "</tr>";
                    ?>
                    </table>
                </div>
            </div>
            <div id="exams-tab" class="content-section" style="display: none;">
                <div class="hist-panel">
                    <h1>Histórico de Exames.</h1>
                    <table>
                        <tr>
                            <th>Laboratório</th>
                            <th>Data</th>
                            <th>Exame</th>
                        </tr>
                    <?php
                        $exams = getExams();
                        echo "<tr>";
                        $cont = 0;
                        for($i = 0; $i < count($exams); $i++) {
                            echo "<td>$exams[$i]</td>";
                            $cont++;
                            if ($cont == 3){
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