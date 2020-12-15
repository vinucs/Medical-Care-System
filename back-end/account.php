<?php session_start();

    if(isset(($_SESSION['id'])) && !empty($_SESSION['id'])) {
        switch($_SESSION['tipo']){
            case 'admin':
                header("Location: ../admin/conta.php");
                exit();
                break;
            case 'patient':
                header("Location: ../patient/conta.php");
                exit();
                break;
            case 'doctor':
                header("Location: ../doctor/conta.php");
                exit();
                break;
            case 'lab':
                header("Location: ../lab/conta.php");
                exit();
                break;
        }
    }
        
    header("Location: ../index.php");
?>