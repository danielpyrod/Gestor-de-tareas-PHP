<?php

session_start();

if (isset($_SESSION["usuario"])){
    // redirigir a login
    header("Location: view/form_tasks.php");
    $a = isset($_SESSION["usuario"]);

    exit;
}

header("Location: view/login.php");
?>
