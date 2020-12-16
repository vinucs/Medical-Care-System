<?php session_start();

    function registerQuerie($xml) {
        $patient_id = addslashes($_POST["patient"]);
        $date = addslashes($_POST["date"]);
        $sintomas = addslashes($_POST["sintomas"]);
        $id = uniqid();
        $doctor_id = $_SESSION['id'];
        $doctor = $_SESSION['name'];
    
        $new_querie = $xml->addChild('consulta');
        $new_querie->addAttribute("id", $id);
        $new_querie->addChild("doctor_id", $doctor_id);
        $new_querie->addChild('patient_id',  $patient_id);
        $new_querie->addChild("doctor", $doctor);
        $new_querie->addChild('date', $date);
        $new_querie->addChild('sintomas', $sintomas);

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML('consultas.xml');
        echo "<script>window.location.replace('../doctor/conta.php');alert('Consulta marcada com sucesso!');</script>";
        unset($_POST);
    }

    $xml = simplexml_load_file("consultas.xml");

    registerQuerie($xml);

?>