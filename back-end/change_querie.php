<?php session_start();

    require('mongodb.php');
    function changeQuerie($querie_id) {
        $col = $database->selectCollection('consultas');
        $result = $col->findOne(
            array(
                'id' => $querie_id
            )
        );
        if (!empty($result)) {
            if (isset($_POST['date']) && !empty($_POST['date']))
                $date = stripslashes($_POST['date']);
                $col->updateOne(
                    ['id' => $querie_id],
                    [
                        '$set' => 
                            [
                                'date' => $date
                            ]
                    ]
                    );
            if (isset($_POST['sintomas']) && !empty($_POST['sintomas']))
                $sintomas = stripslashes($_POST['sintomas']);
                $col->updateOne(
                    ['id' => $querie_id],
                    ['$set' => 
                            [
                                'sintomas' => $sintomas
                            ]
                    ]
                            );
            }

        $session_type = $_SESSION['tipo'];
        echo "<script>alert('Consulta alterada com sucesso!'); sessionStorage.setItem('tab', 'queries historic');window.location.replace('../" . $session_type . "/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['querie']) && !empty($_GET['querie'])) {
        changeQuerie(stripslashes($_GET['querie']));
    } else {
        $session_type = $_SESSION['tipo'];
        echo "<script>alert('Ocorreu algum erro!'); sessionStorage.setItem('tab', 'queries historic');window.location.replace('../$session_type/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }
?>