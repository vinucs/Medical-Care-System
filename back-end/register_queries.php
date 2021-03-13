<?php session_start();

    function registerQuerie() {
        require('mongodb.php');
        $patient_id = addslashes($_POST["patient"]);
        $col = $database->selectCollection('contas');
        $result = $col->findOne(
            [
                'id' => $patient_id
            ]
        );

        $cpf = addslashes($result['cpf']);
        $name = addslashes($result['name']);
        $date = addslashes($_POST["date"]);
        $sintomas = addslashes($_POST["sintomas"]);
        $id = uniqid();
        $doctor_id = $_SESSION['id'];
        $doctor = $_SESSION['name'];    
        $col = $database->selectCollection('consultas');
        $col->insert(
            array(
                'id' => $id,
                'patient_name' => $name,
                'patient_cpf' => $cpf,
                'doctor_id' => $doctor_id,
                'doctor' => $doctor,
                'patient_id' => $patient_id,
                'date' => $date,
                'sintomas' => $sintomas
                )
            );
        echo "<script>window.location.replace('../doctor/conta.php');alert('Consulta marcada com sucesso!');</script>";
        unset($_POST);
    }

    registerQuerie();

?>