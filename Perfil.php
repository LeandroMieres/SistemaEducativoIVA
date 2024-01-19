<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
$usuario_nombre = $_SESSION["usuario_nombre"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>SISTEMA IVA</h2>
            <a href="Facturas.php" class="menu-item"><i class="fas fa-file-invoice"></i> Facturas</a>
            <a href="Contribuyentes.php" class="menu-item"><i class="fas fa-users"></i> Contribuyentes</a>
            <a href="Perfil.php" class="menu-item"><i class="fas fa-user"></i> Perfil</a>
            <a href="PerfilCerrarSesión.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
        <div id="content">
            <h2>Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?></h2>
        </div>
    </div>
</body>

</html>