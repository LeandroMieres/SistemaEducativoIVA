<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas - Sistema IVA</title>
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
            <h2>Facturas</h2>
            <div class="card-container">
                <div class="card">
                    <a href="FacturasCompras.php">
                        <h3>Compra</h3>
                    </a>
                </div>
                <div class="card">
                    <a href="Facturaslistado.php">
                        <h3>Listado</h3>
                    </a>
                </div>
                <div class="card">
                    <a href="FacturasVentas.php">
                        <h3>Ventas</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
