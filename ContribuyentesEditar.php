<?php
include("config/conexion.php");

$contribuyente = array();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $contribuyente_id = $_GET['id'];

    $sql = "SELECT * FROM contribuyentes WHERE Id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $contribuyente_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $contribuyente = $result->fetch_assoc();
    } else {
        echo "Contribuyente no encontrado.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contribuyentes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos para el mensaje emergente */
        .popup {
            display: none;
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #f44336;
        }
    </style>
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
        <div class="content">
            <h1>Editar Contribuyente</h1>
            <form id="editForm" method="POST" action="ContribuyentesEditar.php">
                <input type="hidden" name="id" value="<?php echo isset($contribuyente['Id']) ? $contribuyente['Id'] : ''; ?>">
                <label for="cuil">CUIL:</label>
                <input type="text" name="cuil" id="cuil" value="<?php echo isset($contribuyente['Cuil']) ? $contribuyente['Cuil'] : ''; ?>" required>
                <br>
                <label for="ape_nom">Apellido y Nombre:</label>
                <input type="text" name="ape_nom" id="ape_nom" value="<?php echo isset($contribuyente['Ape_Nom']) ? $contribuyente['Ape_Nom'] : ''; ?>" required>
                <br>
                <label for="resp_iva">Responsabilidad IVA:</label>
                <input type="text" name="resp_iva" id="resp_iva" value="<?php echo isset($contribuyente['Resp_Iva']) ? $contribuyente['Resp_Iva'] : ''; ?>" required>
                <br>
                <label for="domicilio">Domicilio:</label>
                <input type="text" name="domicilio" id="domicilio" value="<?php echo isset($contribuyente['Domicilio']) ? $contribuyente['Domicilio'] : ''; ?>" required>
                <br>
                <label for="localidad">Localidad:</label>
                <input type="text" name="localidad" id="localidad" value="<?php echo isset($contribuyente['Localidad']) ? $contribuyente['Localidad'] : ''; ?>" required>
                <br>
                <input type="submit" value="Guardar Cambios">
            </form>
            <!-- Mensaje emergente -->
            <div id="popup" class="popup"></div>

            <script>
                // Función para mostrar el mensaje emergente
                function showPopup(message, type) {
                    var popup = document.getElementById("popup");
                    popup.innerHTML = message;
                    popup.className = "popup " + type;
                    popup.style.display = "block";

                    // Ocultar el mensaje después de 3 segundos
                    setTimeout(function() {
                        popup.style.display = "none";
                    }, 3000);
                }

                var editForm = document.getElementById("editForm");
                editForm.addEventListener("submit", function(event) {
                    event.preventDefault(); // Evita la acción predeterminada del formulario

                    // Puedes realizar validaciones adicionales aquí si es necesario

                    // Envía el formulario mediante AJAX o deja que se envíe normalmente
                    editForm.submit();
                });

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['id'], $_POST['cuil'], $_POST['ape_nom'], $_POST['resp_iva'], $_POST['domicilio'], $_POST['localidad'])) {

                        // Validaciones y sanitización (muestra solo un ejemplo, personalízalo según tus necesidades)
                        $contribuyente_id = $_POST['id'];
                        $cuil = htmlspecialchars($_POST['cuil']);
                        $ape_nom = htmlspecialchars($_POST['ape_nom']);
                        $resp_iva = htmlspecialchars($_POST['resp_iva']);
                        $domicilio = htmlspecialchars($_POST['domicilio']);
                        $localidad = htmlspecialchars($_POST['localidad']);

                        $sql = "UPDATE contribuyentes SET Cuil=?, Ape_Nom=?, Resp_Iva=?, Domicilio=?, Localidad=? WHERE Id=?";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("sssssi", $cuil, $ape_nom, $resp_iva, $domicilio, $localidad, $contribuyente_id);

                        if ($stmt->execute()) {
                            echo "showPopup('Datos actualizados correctamente.', 'success');";
                        } else {
                            echo "showPopup('Error al actualizar los datos.', 'error');";
                        }

                        $stmt->close();
                    } else {
                        echo "showPopup('Todos los campos del formulario son obligatorios.', 'error');";
                    }
                }
                $conexion->close();
                ?>
            </script>
        </div>
    </div>
</body>

</html>