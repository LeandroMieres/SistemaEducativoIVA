<?php
include("config/conexion.php");

session_start();
session_regenerate_id();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit();
}

$id_usuarioo = $_SESSION["usuario_id"];

$Comprobante = $_POST['Comprobante'] ?? null;
$Tipo_Comprobante = $_POST['Tipo_Comprobante'] ?? null;
$Numero = $_POST['Numero'] ?? null;
$Fecha = $_POST['Fecha'] ?? null;
$Id_Contribuyente = $_POST['Id_Contribuyente'] ?? null;
$Neto_21 = $_POST['Neto_21'] ?? null;
$Neto_10_5 = $_POST['Neto_10'] ?? null;
$Neto_27 = $_POST['Neto_27'] ?? null;
$Iva_21 = $_POST['Iva_21'] ?? null;
$Iva_10_5 = $_POST['Iva_10'] ?? null;
$Iva_27 = $_POST['Iva_27'] ?? null;
$Exento = $_POST['Exento'] ?? null;
$No_Gravado = $_POST['No_Gravado'] ?? null;
$Impuestos = $_POST['Impuestos'] ?? null;
$Percepciones = $_POST['Percepciones'] ?? null;
$Retenciones = $_POST['Retenciones'] ?? null;
$Gastos = $_POST['Gastos'] ?? null;
$Total = $_POST['Total'] ?? null;
$Periodo = $_POST['Periodo'] ?? null;
$Signo = $_POST['Signo'] ?? null;
$id_usuario = $_POST['id_usuario'] ?? null;

if ($Comprobante !== null && $Tipo_Comprobante !== null && $Numero !== null && $Fecha !== null && $Id_Contribuyente !== null && $Neto_21 !== null && $Neto_10_5 !== null && $Neto_27 !== null && $Iva_21 !== null && $Iva_10_5 !== null && $Iva_27 !== null && $Exento !== null && $No_Gravado !== null && $Impuestos !== null && $Percepciones !== null && $Retenciones !== null && $Gastos !== null && $Total !== null && $Periodo !== null && $Signo !== null && $id_usuario !== null) {
    $sql = "INSERT INTO compras (Comprobante, Tipo_Comprobante, Numero, Fecha, Id_Contribuyente, Neto_21, Neto_10, Neto_27, Iva_21, Iva_10, Iva_27, Exento, No_Gravado, Impuestos, Percepciones, Retenciones, Gastos, Total, Periodo, Signo, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssdddddssssssssssss", $Comprobante, $Tipo_Comprobante, $Numero, $Fecha, $Id_Contribuyente, $Neto_21, $Neto_10_5, $Neto_27, $Iva_21, $Iva_10_5, $Iva_27, $Exento, $No_Gravado, $Impuestos, $Percepciones, $Retenciones, $Gastos, $Total, $Periodo, $Signo, $id_usuario);

        if ($stmt->execute()) {
            header("Location: FacturasListado.php"); // Redirige a una página de éxito
            exit();
        } else {
            echo "Error en la inserción: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta:" . $conexion->error;
    }

    $conexion->close();
} /* else {
    echo "Faltan datos obligatorios para la inserción.";
} */
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
        <div class="content">
            <h2>Factura Ventas</h2>
            <form action="FacturasVentas.php" method="post" id="facturaForm">
            <label for="Comprobante">Comprobante:</label>
                <select name="Comprobante" id="Comprobante" required onchange="updateSigno()">
                    <option value="" disabled selected>Seleccione un comprobante</option>
                    <option value="FC">Factura</option>
                    <option value="RC">Recibo</option>
                    <option value="NC">Nota de Crédito</option>
                    <option value="ND">Nota de Debito</option>
                </select><br>

                <label for="Tipo_Comprobante">Tipo Comprobante:</label>
                <input type="text" name="Tipo_Comprobante" id="Tipo_Comprobante" pattern="^([A-Z]{1})$" placeholder="Ejemplo: A, B, C" required><br>

                <label for="Numero">Número de Comprobante:</label>
                <input type="text" name="Numero" id="Numero" pattern="^([0-9]{5})-([0-9]{8})$" placeholder="Ejemplo: 00000-12345678" required><br>

                <label for="Fecha">Fecha:</label>
                <input type="date" name="Fecha" id="Fecha" pattern="^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$" required><br>

                <label for="Id_Contribuyente">ID de Contribuyente:</label>
                <input type="number" name="Id_Contribuyente" id="Id_Contribuyente" pattern="^(20|23|27|30|33)-[0-9]{8}-([0-9]{1})$" placeholder="Ejemplo: 20-12345678-1" required><br>

                <label for="Neto_21">Neto 21%:</label>
                <input type="number" name="Neto_21" id="Neto" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Neto_10_5">Neto 10,5%:</label>
                <input type="number" name="Neto_10" id="Neto" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Neto_27">Neto 27%:</label>
                <input type="number" name="Neto_27" id="Neto" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Iva_21">IVA 21%:</label>
                <input type="number" name="Iva_21" id="Iva" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Iva_10_5">IVA 10,5%:</label>
                <input type="number" name="Iva_10" id="Iva" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Iva_27">IVA 27%:</label>
                <input type="number" name="Iva_27" id="Iva" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Exento">Exento:</label>
                <input type="number" name="Exento" id="Exento" step="0.01" placeholder="Ejemplo: 2.50" required><br>

                <label for="No_Gravado">No Gravado:</label>
                <input type="number" name="No_Gravado" id="No_Gravado" step="0.01" placeholder="Ejemplo: 2.50C" required><br>

                <label for="Impuestos">Impuestos:</label>
                <input type="number" name="Impuestos" id="Impuestos" step="0.01" placeholder="Ejemplo: 2.50" required><br>

                <label for="Percepciones">Percepciones:</label>
                <input type="number" name="Percepciones" id="Percepciones" step="0.01" placeholder="Ejemplo: 2.50" required><br>

                <label for="Retenciones">Retenciones:</label>
                <input type="number" name="Retenciones" id="Retenciones" step="0.01" placeholder="Ejemplo: 2.50" required><br>

                <label for="Gastos">Gastos:</label>
                <input type="number" name="Gastos" id="Gastos" step="0.01" placeholder="Ejemplo: 2.50" required><br>

                <label for="Total">Total:</label>
                <input type="number" name="Total" id="Total" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ejemplo: 2.50" required><br>

                <label for="Periodo">Período (mes/año):</label>
                <input type="text" name="Periodo" id="Periodo" pattern="^(0[1-9]|1[0-2])(\d{2})$" placeholder="Ejemplo: 1123" required><br>

                <input type="hidden" name="Signo" id="Signo" pattern="^(1|-1)$" placeholder="Ejemplo: 1 |-1" required><br>

                <input type="hidden" name="id_usuario" id="id_usuario" value='<?php echo  htmlspecialchars($id_usuario); ?>' placeholder="Ejemplo: 1" required><br>

                <input type="submit" name="submit" value="Insertar">
            </form>
            <script>
                function updateSigno() {
                    var comprobante = document.getElementById('Comprobante').value;
                    var signoInput = document.getElementById('Signo');

                    // Si el comprobante es Factura, Recibo o Nota de Crédito, establecer automáticamente el valor del Signo a 1
                    if (comprobante === 'FC' || comprobante === 'RC' || comprobante === 'NC') {
                        signoInput.value = '1';
                    } else {
                        // Si es otro tipo de comprobante, permitir que el usuario ingrese el valor manualmente
                        signoInput.value = '-1';
                    }
                }
                updateSigno();
            </script>
        </div>
    </div>
</body>

</html>