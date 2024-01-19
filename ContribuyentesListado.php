<?php
include("config/conexion.php");

$cuil_filter = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuil_filter = $_POST['cuil_filter'];
}

$sql = "SELECT * FROM contribuyentes";

if (!empty($cuil_filter)) {
    $sql .= " WHERE Cuil LIKE ?";
}

$stmt = $conexion->prepare($sql);

if (!empty($cuil_filter)) {
    $stmt->bind_param("s", "%$cuil_filter%");
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Contribuyentes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <<?php require_once("view/content/sidebar.php"); ?> <div class="content">
            <h2>Listado Contribuyentes</h2>
            <form method='POST' action='contribuyenteslistado.php'>
                <label for='cuil_filter'>Buscar por CUIL:</label>
                <input type='text' name='cuil_filter' id='cuil_filter' value='<?php echo $cuil_filter; ?>'>
                <input type='submit' value='Buscar'>
            </form>
            <table>
                <tr>
                    <th>CUIL</th>
                    <th>Apellido y Nombre</th>
                    <th>Responsabilidad IVA</th>
                    <th>Domicilio</th>
                    <th>Localidad</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["Cuil"]; ?></td>
                        <td><?php echo $row["Ape_Nom"]; ?></td>
                        <td><?php echo $row["Resp_Iva"]; ?></td>
                        <td><?php echo $row["Domicilio"]; ?></td>
                        <td><?php echo $row["Localidad"]; ?></td>
                        <td>
                            <a href='ContribuyentesEditar.php?id=<?php echo $row["Id"]; ?>'>Editar</a>
                            <a href='ContribuyentesEliminar.php?id=<?php echo $row["Id"]; ?>'>Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
    </div>
    </div>
</body>

</html>
<?php
if ($result->num_rows === 0) {
    echo "<td colspan='21'>No hay datos disponibles</td>";
}
$stmt->close();
$conexion->close()
?>