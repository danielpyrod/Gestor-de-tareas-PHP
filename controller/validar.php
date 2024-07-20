<?php

//VALIDAR EL LOGIN DE USUARIO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $usuario_login = $_POST['usuario'];
    $password_login = $_POST['password'];

    include('../model/db.php');

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario_login, $password_login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if ($fila) {
            $_SESSION['usuario_id'] = $fila['id_usuario'];
            
            //echo $_SESSION['nombre_usuario'];
            header("Location: ../view/form_tasks.php");
            exit;
        } else {
            echo "No se encontró el usuario.";
        }
        $resultado->free();
    } else {
        echo "Usuario o contraseña incorrectos";
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../view/login.php");
    exit;
}
?>
