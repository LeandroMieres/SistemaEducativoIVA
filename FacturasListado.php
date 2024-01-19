<?php
include("config/conexion.php");

$periodo_inicio = isset($_POST['periodo_inicio']) ? $_POST['periodo_inicio'] : '';
$periodo_fin = isset($_POST['periodo_fin']) ? $_POST['periodo_fin'] : '';

$sql_ventas = "SELECT * FROM ventas";
$sql_compras = "SELECT * FROM compras";

if (!empty($periodo_inicio) && !empty($periodo_fin)) {
    $sql_ventas .= " WHERE Periodo BETWEEN ? AND ?";
    $sql_compras .= " WHERE Periodo BETWEEN ? AND ?";
}

$stmt_ventas = $conexion->prepare($sql_ventas);
$stmt_compras = $conexion->prepare($sql_compras);

if (!empty($periodo_inicio) && !empty($periodo_fin)) {
    $stmt_ventas->bind_param("ss", $periodo_inicio, $periodo_fin);
    $stmt_compras->bind_param("ss", $periodo_inicio, $periodo_fin);
}

$stmt_ventas->execute();
$stmt_compras->execute();

$result_ventas = $stmt_ventas->get_result();
$result_compras = $stmt_compras->get_result()
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
            <h2>Listado</h2>
            <form method='POST' action='Facturaslistado.php'>
                <label for='periodo_inicio'>Buscar por Periodo:</label>
                <input type='text' name='periodo_inicio' id='periodo_inicio' value='<?php echo $periodo_inicio; ?>'>
                <label for='periodo_fin'>Entre: </label>
                <input type='text' name='periodo_fin' id='periodo_fin' value='<?php echo $periodo_fin; ?>'>
                <input type='submit' value='Buscar'>
            </form>

            <h2>Factura Ventas</h2>
            <?php if ($result_ventas->num_rows > 0) : ?>
                <table>
                    <tr>
                        <th>Comprobante</th>
                        <th>Tipo Comprobante</th>
                        <th>Número de Comprobante</th>
                        <th>Fecha</th>
                        <th>ID de Contribuyente</th>
                        <th>Neto 21%</th>
                        <th>Neto 10,5%</th>
                        <th>Neto 27%</th>
                        <th>IVA 21%</th>
                        <th>IVA 10,5%</th>
                        <th>IVA 27%</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Impuestos</th>
                        <th>Percepciones</th>
                        <th>Retenciones</th>
                        <th>Total</th>
                        <th>Período</th>
                        <th>Signo</th>
                        <th>ID de Usuario</th>
                    </tr>
                    <?php while ($row = $result_ventas->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["Comprobante"]; ?></td>
                            <td><?php echo $row["Tipo_Comprobante"]; ?></td>
                            <td><?php echo $row["Numero"]; ?></td>
                            <td><?php echo $row["Fecha"]; ?></td>
                            <td><?php echo $row["Id_Contribuyente"]; ?></td>
                            <td><?php echo $row["Neto_21"]; ?></td>
                            <td><?php echo $row["Neto_10"]; ?></td>
                            <td><?php echo $row["Neto_27"]; ?></td>
                            <td><?php echo $row["Iva_21"]; ?></td>
                            <td><?php echo $row["Iva_10"]; ?></td>
                            <td><?php echo $row["Iva_27"]; ?></td>
                            <td><?php echo $row["Exento"]; ?></td>
                            <td><?php echo $row["No_Gravado"]; ?></td>
                            <td><?php echo $row["Impuestos"]; ?></td>
                            <td><?php echo $row["Percepciones"]; ?></td>
                            <td><?php echo $row["Retenciones"]; ?></td>
                            <td><?php echo $row["Gastos"]; ?></td>
                            <td><?php echo $row["Total"]; ?></td>
                            <td><?php echo $row["Signo"]; ?></td>
                            <td><?php echo $row["id_usuario"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else : ?>
                <p>No hay datos disponibles</p>
            <?php endif; ?>

            <h2>Factura Compras</h2>
            <?php if ($result_compras->num_rows > 0) : ?>
                <table>
                    <tr>
                        <th>Comprobante</th>
                        <th>Tipo Comprobante</th>
                        <th>Número de Comprobante</th>
                        <th>Fecha</th>
                        <th>ID de Contribuyente</th>
                        <th>Neto 21%</th>
                        <th>Neto 10,5%</th>
                        <th>Neto 27%</th>
                        <th>IVA 21%</th>
                        <th>IVA 10,5%</th>
                        <th>IVA 27%</th>
                        <th>Exento</th>
                        <th>No Gravado</th>
                        <th>Impuestos</th>
                        <th>Percepciones</th>
                        <th>Retenciones</th>
                        <th>Total</th>
                        <th>Período</th>
                        <th>Signo</th>
                        <th>ID de Usuario</th>
                    </tr>
                    <?php while ($row = $result_compras->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Comprobante"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Tipo_Comprobante"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Numero"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Fecha"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Id_Contribuyente"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Neto_21"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Neto_10,5"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Neto_27"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Iva_21"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Iva_10,5"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Iva_27"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Exento"]); ?></td>
                            <td><?php echo htmlspecialchars($row["No_Gravado"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Impuestos"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Percepciones"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Retenciones"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Gastos"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Total"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Signo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["id_usuario"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else : ?>
                <p>No hay datos disponibles</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>