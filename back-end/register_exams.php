<?php session_start();

    function registerExam($xml) {
        $patient_id = addslashes($_POST["patient"]);
        $date = addslashes($_POST["date"]);
        $exam_type = addslashes($_POST["exam-type"]);
        $id = uniqid();
        $lab_id = $_SESSION['id'];
        $lab = $_SESSION['name'];
    
        $new_exam = $xml->addChild('consulta');
        $new_exam->addAttribute("id", $id);
        $new_exam->addChild("lab_id", $lab_id);
        $new_exam->addChild('patient_id',  $patient_id);
        $new_exam->addChild("lab", $lab);
        $new_exam->addChild('date', $date);
        $new_exam->addChild('exam_type', $exam_type);

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML('exames.xml');
        echo "<script>window.location.replace('../lab/conta.php');alert('Exame marcado com sucesso!');</script>";
        unset($_POST);
    }

    $xml = simplexml_load_file("exames.xml");

    registerExam($xml);

?>