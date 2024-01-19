<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuil = $_POST['cuil'];
    $ape_nom = $_POST['ape_nom'];
    $resp_iva = $_POST['resp_iva'];
    $domicilio = $_POST['domicilio'];
    $localidad = $_POST['localidad'];

    /* new */$cuil = $ape_nom = $resp_iva = $domicilio = $localidad = "";
    $errors = array();

    if (!preg_match("/^\d{11}$/", $cuil)) {
        $errors['cuil'] = "El CUIL debe contener 11 dígitos numéricos.";
    }

    if (!preg_match("/^[\p{L} .'-]+$/u", $ape_nom)) {
        $errors['ape_nom'] = "Ingrese un nombre y apellido válido.";
    }

    if (!preg_match("/^[A-Z]{2}$/", $resp_iva)) {
        $errors['resp_iva'] = "La responsabilidad IVA debe contener 2 letras mayúsculas.";
    }

    if (empty($domicilio)) {
        $errors['domicilio'] = "Ingrese un domicilio válido.";
    }

    if (empty($localidad)) {
        $errors['localidad'] = "Ingrese una localidad válida.";
    }

    if (empty($errors)) {

        include("config/conexion.php");

        $stmt = $conexion->prepare("INSERT INTO contribuyentes (Cuil, Ape_Nom, Resp_Iva, Domicilio, Localidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $cuil, $ape_nom, $resp_iva, $domicilio, $localidad);
        $stmt->execute();

        // Redirige a la página de listado o muestra un mensaje de éxito
        header("Location: ContribuyentesListado.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Contribuyente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>SISTEMA IVA</h2>
            <a href="facturas.html" class="menu-item"><i class="fas fa-file-invoice"></i> Facturas</a>
            <a href="contribuyenteslistado.php" class="menu-item"><i class="fas fa-users"></i> Contribuyentes</a>
            <a href="Perfil.html" class="menu-item"><i class="fas fa-user"></i> Perfil</a>
            <a href="CerrarSesión.html" class="menu-item"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
        <div class="content">
            <h1>Agregar Contribuyente</h1>
            <form method="POST" action="">

                <label for="cuil">CUIL:</label>
                <input type="text" name="cuil" id="cuil" required>
                <?php if (isset($errors['cuil'])) {
                    echo "<p>{$errors['cuil']}</p>";
                } ?>

                <label for="ape_nom">Apellido y Nombre:</label>
                <input type="text" name="ape_nom" id="ape_nom" required>
                <?php if (isset($errors['ape_nom'])) {
                    echo "<p>{$errors['ape_nom']}</p>";
                } ?>

                <label for="resp_iva">Responsabilidad IVA:</label>
                <input type="text" name="resp_iva" id="resp_iva" required>
                <?php if (isset($errors['resp_iva'])) {
                    echo "<p>{$errors['resp_iva']}</p>";
                } ?>

                <label for="domicilio">Domicilio:</label>
                <input type="text" name="domicilio" id="domicilio" required>
                <?php if (isset($errors['domicilio'])) {
                    echo "<p>{$errors['domicilio']}</p>";
                } ?>

                <label for="localidad">Localidad:</label>
                <input type="text" name="localidad" id="localidad" required>
                <?php if (isset($errors['localidad'])) {
                    echo "<p>{$errors['localidad']}</p>";
                } ?>

                <input type="submit" value="Agregar">

            </form>
        </div>
    </div>
</body>

</html>