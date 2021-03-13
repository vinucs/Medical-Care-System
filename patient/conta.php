<?php session_start();

    function getQueries() {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('consultas');
        $cursor = $col->find(
            [ 'patient_id' => $_SESSION['id'] ]
        );
        $queries = iterator_to_array($cursor);
        return $queries;
    }

    function getExams() {
        require("../back-end/mongodb.php");
        $col = $database->selectCollection('exames');
        $cursor = $col->find(
                [ 'patient_id' => $_SESSION['id'] ]
        );
        $result = iterator_to_array($cursor);
        #return $cursor;
        return $result;
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

    if ($_SESSION['tipo'] != 'patient'){
        session_destroy();
        header("Location: ../index.php");
    }

    $queries = getQueries();
    uasort($queries, 'compareFunction');
    $queries_date = array();
    foreach($queries as $q) {
        array_push($queries_date, $q['date']);
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
                        foreach ($queries as $query) {
                            echo "<tr>";
                            $doctor = $query['doctor'];
                            $date = $query['date'];
                            $symptoms = $query['sintomas'];
                            echo "<td>$doctor</td>";
                            echo "<td>$date</td>";
                            echo "<td>$symptoms</td>";
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
                        foreach ($exams as $exam) {
                            echo "<tr>";
                            $lab_name = $exam["lab_name"];
                            $date = $exam["date"];
                            $exam_type = $exam["exam_type"];
                            echo "<td>$lab_name</td>";
                            echo "<td>$date</td>";
                            echo "<td>$exam_type</td>";
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