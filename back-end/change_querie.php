<?php session_start();

    function changeQuerie($xml, $querie_id) {

        foreach($xml->children() as $querie) {
            if ((string)$querie['id'] == $querie_id) {
                if (isset($_POST['date']) && !empty($_POST['date']))
                    $querie->date = stripslashes($_POST['date']);
                if (isset($_POST['sintomas']) && !empty($_POST['sintomas']))
                    $querie->sintomas = stripslashes($_POST['sintomas']);
                break;
            }
        }

        $att_xml = simplexml_import_dom($xml);
        $att_xml->saveXML("consultas.xml");

        $session_type = $_SESSION['tipo'];
        echo "<script>alert('Consulta alterada com sucesso!'); sessionStorage.setItem('tab', 'queries historic');window.location.replace('../" . $session_type . "/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }

    if (isset($_GET['querie']) && !empty($_GET['querie'])) {
        $xml = simplexml_load_file("consultas.xml");
        changeQuerie($xml, stripslashes($_GET['querie']));
    }
    else {
        $session_type = $_SESSION['tipo'];
        echo "<script>alert('Ocorreu algum erro!'); sessionStorage.setItem('tab', 'queries historic');window.location.replace('../$session_type/conta.php');</script>";
        unset($_POST);
        unset($_GET);
    }
?>