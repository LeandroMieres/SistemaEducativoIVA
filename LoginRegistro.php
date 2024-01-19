<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/css/login.css">
    <title>Registrarse</title>
</head>

<body>
    <div id="container">
        <div id="form-container">
            <h2>Registrarse</h2>
            <form action="LoginRegistro.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="email" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
</body>

</html>
<?php
include("config/conexion.php");

function validarDatos($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = validarDatos($_POST["nombre"]);
    $correo = validarDatos($_POST["email"]);
    $contrasena = validarDatos($_POST["contrasena"]);

    if (strlen($nombre) > 50) {
        $error = "Error: El nombre no puede superar los 50 caracteres.";
    }

    if (strlen($correo) > 50) {
        $error = "Error: El correo electrónico no puede superar los 50 caracteres.";
    }

    if (strlen($contrasena) > 255) {
        $error = "Error: La contraseña no puede superar los 255 caracteres.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Error: El formato del correo electrónico no es válido.";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        $error = "Error: El nombre solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[a-zA-Z0-9]*$/", $contrasena)) {
        $error = "Error: La contraseña solo puede contener letras y números.";
    }
    $hashContrasena = password_hash($contrasena, PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (Nombre, Email, Contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $hashContrasena);

    if ($stmt->execute()) {
        header("Location: Dashboard.php");
        exit();
    } else {
        $error = "Error al registrar usuario.";
    }

    $stmt->close();
}

$conexion->close();

if ($error) {
    echo $error;
}
?>
