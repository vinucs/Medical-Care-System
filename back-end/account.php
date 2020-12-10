<?php session_start();

    if(isset(($_SESSION['id'])) && !empty($_SESSION['id'])) {
        switch($_SESSION['tipo']){
            case 'admin':
                header("Location: ../admin/conta.html");
                exit();
                break;
            case 'patient':
                header("Location: ../patient/conta.html");
                exit();
                break;
            case 'doctor':
                header("Location: ../doctor/conta.html");
                exit();
                break;
            case 'lab':
                header("Location: ../lab/conta.html");
                exit();
                break;
        }
    }
        
    header("Location: ../index.html");
?>