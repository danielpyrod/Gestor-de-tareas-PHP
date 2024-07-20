<?php  
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('header.php');
include('../controller/controller_tasks.php');

$taskController = new TaskController();
$tareas = $taskController->read();
?>

<?php
$isEditing = isset($_GET['edit']);
$task = null;
if ($isEditing) {
    $taskId = $_GET['edit'];
    $task = $taskController->getTaskById($taskId);
}
?>

<?php if (isset($_SESSION['mensaje'])) { ?>
<div class="mensaje">
  <span class="cerrar" onclick="this.parentElement.style.display='none';">&times;</span>
  <p><?php echo $_SESSION['mensaje']; ?></p>
</div>
<?php unset($_SESSION['mensaje']); } // Limpiar el mensaje de la sesión } ?>


<div class="container">
    <div class="formulario">
        <form action="../controller/controller_tasks.php" method="post">
            <input type="hidden" name="action" value="<?php echo $isEditing ? 'update' : 'create'; ?>">
            <?php if ($isEditing): ?>
                <input type="hidden" name="id_tarea" value="<?php echo $task['id_tarea']; ?>">
            <?php endif; ?>
            <input type="text" name="titulo" placeholder="Título" required value="<?php echo $isEditing ? htmlspecialchars($task['nombre_tarea']) : ''; ?>">
            <textarea name="descripcion" rows="6" cols="24" placeholder="Descripción" required><?php echo $isEditing ? htmlspecialchars($task['descripcion']) : ''; ?></textarea>
            <input type="date" id="end" name="task_end" value="<?php echo $isEditing ? $task['fecha_limite'] : '2024-01-21'; ?>" min="2024-01-01" max="2025-12-31" required>
            <div class="checkbox-container">
                <label for="listo">Listo</label>
                <input type="checkbox" id="listo" name="listo"  value="1" <?php echo $isEditing && $task['listo'] ? 'checked' : ''; ?>>
            </div>
            <button type="submit"><?php echo $isEditing ? 'Actualizar' : 'Crear'; ?> tarea</button>
        </form>
    </div>

    <div class="tareas">
        <table class="tareas-tabla">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha Límite</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tarea['nombre_tarea']); ?></td>
                        <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($tarea['fecha_limite']); ?></td>
                        <td><?php echo $tarea['listo'] ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-clock blue"></i>'; ?></td>
                        <td>
                            <form action="../controller/controller_tasks.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
                                <button type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            <a href="form_tasks.php?edit=<?php echo $tarea['id_tarea']; ?>"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$taskController->closeConnection();
include('footer.php'); 
?>
