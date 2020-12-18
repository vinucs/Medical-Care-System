<?php session_start();

    function changeExam($xml, $exam_id) {

        foreach($xml->children() as $exam) {
            if ((string)$exam['id'] == $exam_id) {
                if (isset($_POST['date']) && !empty($_POST['date']))
                    $exam->date = stripslashes($_POST['date']);
                if (isset($_POST['exam_type']) && !empty($_POST['exam_type']))
                    $exam->exam_type = stripslashes($_POST['exam_type']);
                break;
            }
        }

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML("exames.xml");

        echo "<script>alert('Exame alterado com sucesso!'); sessionStorage.setItem('tab', 'exams historic');window.location.replace('../lab/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['exam']) && !empty($_GET['exam'])) {
        $xml = simplexml_load_file("exames.xml");
        changeExam($xml, stripslashes($_GET['exam']));
    }
    else {
        echo "<script>alert('Ocorreu algum erro!'); sessionStorage.setItem('tab', 'exams historic');window.location.replace('../lab/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }
?>