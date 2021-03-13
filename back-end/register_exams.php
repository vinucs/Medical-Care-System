<?php session_start();
    
    function registerExam() {
        require('mongodb.php');
        $patient_id = addslashes($_POST["patient"]);
        $date = addslashes($_POST["date"]);
        $exam_type = addslashes($_POST["exam-type"]);
        $id = uniqid();
        $lab_id = $_SESSION['id'];
        $lab = $_SESSION['name'];
        $col2 = $database->selectCollection('contas');
        $result = $col2->findOne(
            [
                'id' => $patient_id
            ]
        );

        $col = $database->selectCollection('exames');
        $col->insert(
            array(
                'name' => $result['name'],
                'cpf' => $result['cpf'],
                'id' => $id,
                'lab_id' => $lab_id,
                'patient_id' => $patient_id,
                'lab' => $lab,
                'date' => $date,
                'exam_type' => $exam_type
                )
            );
        echo "<script>window.location.replace('../lab/conta.php');alert('Exame marcado com sucesso!');</script>";
        unset($_POST);
    }

    registerExam();

?>