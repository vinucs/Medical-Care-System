<?php session_start();

    require('mongodb.php');
    function registerQuerie() {
        $patient_id = addslashes($_POST["patient"]);
        $date = addslashes($_POST["date"]);
        $sintomas = addslashes($_POST["sintomas"]);
        $id = uniqid();
        $doctor_id = $_SESSION['id'];
        $doctor = $_SESSION['name'];
    
        $col = $database->selectCollection('consultas');
        $col->insertOne(
            array(
                'id' => $id,
                'doctor_id' => $doctor_id,
                'patient_id' => $patient_id,
                'doctor' => $doctor,
                'date' => $date,
                'sintomas' => $sintomas
                )
            );
        echo "<script>window.location.replace('../doctor/conta.php');alert('Consulta marcada com sucesso!');</script>";
        unset($_POST);
    }

    registerQuerie();

?>