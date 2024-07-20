<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../view/login.php");
    exit();
}

class TaskController {
    private $conexion;

    public function __construct() {
        include('../model/db.php'); // Asegúrate de que este archivo establece la conexión $conexion
        $this->conexion = $conexion;
    }

    public function read() {
        $usuario_id = $_SESSION['usuario_id'];
        $sql = "SELECT * FROM tareas WHERE id_usuario='$usuario_id'";
        $resultado = mysqli_query($this->conexion, $sql);
        if ($resultado) {
            $tareas = array();
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $tareas[] = $fila;
            }
            return $tareas;
        } else {
            echo "ERROR: " . $this->conexion->error;
            return array();
        }
    }

    public function delete() {
        session_start();

        if (!isset($_POST['id_tarea'])) {
            echo "ID de la tarea no proporcionado";
            return;
        }
        
        $tarea_id = $_POST['id_tarea'];
        echo "ID de la tarea a eliminar: " . $tarea_id; // Depuración
        $sql = "DELETE FROM tareas WHERE id_tarea='$tarea_id'";
        if ($this->conexion->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Tarea eliminada exitosamente";
            

        } else {
            $_SESSION['mensaje'] = "Error al eliminar tarea: " . $this->conexion->error;
        }
        header("Location: ../view/form_tasks.php");
    }

    public function create() {
        $usuario_id = $_SESSION['usuario_id'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['task_end'];
        $listo = isset($_POST['listo']) ? 1 : 0;

        $sql = "INSERT INTO tareas (id_usuario, nombre_tarea, descripcion, listo, fecha_limite) VALUES ('$usuario_id', '$titulo', '$descripcion', '$listo', '$fecha')";
        if ($this->conexion->query($sql) === TRUE) {
            header("Location: ../view/form_tasks.php");
        } else {
            echo "Hubo un error: " . $this->conexion->error;
        }
    }

    public function getTaskById($id_tarea) {
        $sql = "SELECT * FROM tareas WHERE id_tarea='$id_tarea'";
        $resultado = mysqli_query($this->conexion, $sql);
        if ($resultado) {
            return mysqli_fetch_assoc($resultado);
        } else {
            echo "ERROR: " . $this->conexion->error;
            return null;
        }
    }
    
    //modif:
    public function update() {
        $tarea_id = $_POST['id_tarea'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['task_end'];
        $listo = isset($_POST['listo']) ? 1 : 0;
    
        $sql = "UPDATE tareas SET nombre_tarea='$titulo', descripcion='$descripcion', listo='$listo', fecha_limite='$fecha' WHERE id_tarea='$tarea_id'";
        if ($this->conexion->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Tarea actualizada exitosamente";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar tarea: " . $this->conexion->error;
        }
        header("Location: ../view/form_tasks.php");
    }

    public function closeConnection() {
        $this->conexion->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $taskController = new TaskController();
    if ($_POST['action'] == 'create') {
        $taskController->create();
    } elseif ($_POST['action'] == 'delete') {
        $taskController->delete();
    } elseif ($_POST['action'] == 'update') {
        $taskController->update();
    }
    $taskController->closeConnection();
}
?>
