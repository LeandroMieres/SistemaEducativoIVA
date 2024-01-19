<?php
session_start([
    'cookie_lifetime' => 86400,  // Tiempo de vida de la cookie
    'cookie_secure'   => true,   // enviar la cookie si la conexión es segura (HTTPS)
    'cookie_httponly' => true    // Impedir JavaScript acceda a la cookie
]);


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
        <?php require_once("view/content/sidebar.php");?>
        <div id="content">
            <h2>Bienvenido, <?php echo htmlspecialchars($usuario_nombre, ENT_QUOTES, 'UTF-8'); ?></h2>
        </div>
    </div>
</body>

</html>