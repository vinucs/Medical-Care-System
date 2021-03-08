<?php session_start();
    require('mongodb.php');

    function changeExam($xml, $exam_id) {
        $result = $col->findOne(
            array(
                'id': $exam_id
            )
        );
        if (!empty($result)) {
            if (isset($_POST['date']) && !empty($_POST['date']))
                $date = stripslashes($_POST['date']);
            if (isset($_POST['exam_type']) && !empty($_POST['exam_type']))
                $exam_type = stripslashes($_POST['exam_type']);
        $col->updateOne(
            ['id' => $id],
            ['$set' => 
                    [
                        'date' => $date,
                        'exam_type' => $exam_type
                    ]
            ]
                    );
        }
    }

        echo "<script>alert('Exame alterado com sucesso!'); sessionStorage.setItem('tab', 'exams historic');window.location.replace('../lab/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['exam']) && !empty($_GET['exam'])) {
        changeExam();
    } else {
        echo "<script>alert('Ocorreu algum erro!'); sessionStorage.setItem('tab', 'exams historic');window.location.replace('../lab/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }
?>