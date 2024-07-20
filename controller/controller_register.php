<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_re = $_POST['usuario_re'];
    $password_re = $_POST['password_re'];

    include('../model/db.php');

    // Verificar si el usuario ya existe
    $check_user_sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$usuario_re'";
    $check_user_result = mysqli_query($conexion, $check_user_sql);

    if (mysqli_num_rows($check_user_result) > 0) {
        // Si el usuario ya existe, redirigir a una página de error o mostrar un mensaje
        echo "El nombre de usuario ya existe. Por favor elige otro.";
    } else {
        // Si el usuario no existe, proceder con el registro
        $sql = "INSERT INTO usuarios (nombre_usuario, contraseña) VALUES ('$usuario_re','$password_re')";
        $resultado = mysqli_query($conexion, $sql);
        header("Location: ../view/login.php");
    }
}

?>
