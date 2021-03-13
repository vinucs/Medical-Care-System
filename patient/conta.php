<?php session_start();

    function getQueries() {
        $xml = simplexml_load_file("../back-end/consultas.xml");

        $queries = array();
        foreach($xml->children() as $querie) {
            if ((string)$querie->patient_id == $_SESSION['id']) {
                $new_q = array((string)$querie->doctor, (string)$querie->date, (string)$querie->sintomas);
                array_push($queries, $new_q);
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
                array_push($exams, $new_e);
            }
        }

        return $exams;
    }

    function compareFunction($a, $b) {
        $a_year = (int)substr($a[1], 0, 4);
        $b_year = (int)substr($b[1], 0, 4);
        if ($a_year < $b_year)
            return 1;
        if ($a_year > $b_year)
            return -1;

        $a_month = (int)substr($a[1], 5, 2);
        $b_month = (int)substr($b[1], 5, 2);
        if ($a_month < $b_month)
            return 1;
        if ($a_month > $b_month)
            return -1;

        $a_day = (int)substr($a[1], 8, 2);
        $b_day = (int)substr($b[1], 8, 2);
        if ($a_day < $b_day)
            return 1;
        if ($a_day > $b_day)
            return -1;

        return 0;
    }

    if ($_SESSION['tipo'] != 'patient'){
        session_destroy();
        header("Location: ../index.php");
    }

    $queries = getQueries();
    uasort($queries, 'compareFunction');
    $queries_date = array();
    foreach($queries as $q) {
        array_push($queries_date, $q[1]);
    }

    $exams = getExams();
    uasort($exams, 'compareFunction');
    $exams_date = array();
    foreach($exams as $e) {
        array_push($exams_date, $e[1]);
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
        <script type='text/javascript'>
            var queries = <?php echo json_encode($queries_date)?>;
            var exams = <?php echo json_encode($exams_date)?>;
        </script>
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
            <div class="acc-options" id="acc-options-tab">
                <ul>
                    <li><a onclick="loadTab('queries tab')">Suas Consultas</a></li>
                    <li><a onclick="loadTab('exams tab')">Seus Exames</a></li>
                    <li><a onclick="loadTab('statistics')">Estatisticas</a></li>
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
                        foreach($queries as $querie) {
                            echo "<tr>";
                            echo "<td>$querie[0]</td>";
                            echo "<td>$querie[1]</td>";
                            echo "<td>$querie[2]</td>";
                            echo "</tr>";
                        }
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
                        foreach($exams as $exam) {
                            echo "<tr>";
                            echo "<td>$exam[0]</td>";
                            echo "<td>$exam[1]</td>";
                            echo "<td>$exam[2]</td>";
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
                <h3>Consultas:</h3>
                <div class="select-style">
                    <div class="inline-content">
                        <p>Média Mensal:</p>
                        <p id="cmedia-mes">--</p>
                    </div>
                    <div class="inline-content">
                        <p>Total Anual:</p>
                        <p id="ctotal-ano">--</p>
                    </div>
                </div>
                <h3>Exames:</h3>
                <div class="select-style">
                    <div class="inline-content">
                        <p>Média Mensal:</p>
                        <p id="emedia-mes">--</p>
                    </div>
                    <div class="inline-content">
                        <p>Total Anual:</p>
                        <p id="etotal-ano">--</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>