<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/css/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div id="container">
        <div id="form-container">
            <h2>Iniciar Sesión</h2>
            <form action="Login.php" method="post">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php

session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit();
}

include("config/conexion.php");

function validarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = validarDatos($_POST["correo"]);
    $contrasena = validarDatos($_POST["contrasena"]);

    if (strlen($contrasena) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } else {
        $stmt = $conexion->prepare("SELECT id, nombre, contraseña FROM usuarios WHERE Email = ?");
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usuario_id, $usuario_nombre, $hashContrasena);
            $stmt->fetch();

            if (password_verify($contrasena, $hashContrasena)) {
                // Inicio de sesión exitoso, almacenar datos del usuario en la sesión
                $_SESSION["usuario_id"] = $usuario_id;
                $_SESSION["usuario_nombre"] = $usuario_nombre;

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Credenciales incorrectas.";
            }
        } else {
            $error = "Credenciales incorrectas.";
        }

        $stmt->close();
    }
}

$conexion->close();
?>