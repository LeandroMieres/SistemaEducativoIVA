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
        <?php require_once("view/content/sidebar.php"); ?>
        <div class="content">
            <h2>Contribuyentes</h2>
            <div class="card-container">
                <div class="card">
                    <a href="ContribuyentesListado.php">
                        <h3>Listado de Contribuyentes</h3>
                    </a>
                </div>
                <div class="card">
                    <a href="ContribuyentesAltas.php">
                        <h3>Cargar Contribuyentes</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>