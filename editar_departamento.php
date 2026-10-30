<?php
require_once './funciones_generales.php';
// Initialize variables for feedback message
$text_iddep = '';
$text_desdep = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // SI LA PAGINA SE LLAMA A SI MISMA
    // Capture and sanitize inputs
    $text_iddep = htmlspecialchars(trim($_POST['text_iddep'] ?? ''));
    $text_desdep = htmlspecialchars(trim($_POST['text_desdep'] ?? ''));
    // Validate fields
    $message = '';
    $message .= valida_campo($text_desdep, 'texto', 'Descripción');
    if (empty($message)) {
        $url = 'graba_edicion_departamento.php?text_iddep=' . $_POST['text_iddep'];
        $url .= '&text_desdep=' . $_POST['text_desdep'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $text_iddep = strtoupper(trim($_REQUEST['text_iddep']));
        $text_desdep = strtoupper(trim($_REQUEST['text_desdep']));
    }
} else {  // SI LA PAGINA SE LLAMA DESDE OTRA PAGINA
    $iddep = strtoupper(trim($_GET['iddep'] ?? ''));
    // --------------------------------------------------------
    // Database configuration
    $host = 'localhost';
    $dbname = 'Ejemplos';
    $user = 'postgres';
    $password = 'harryh';

    $row = null;
    $error = null;

    try {
        // Connect to PostgreSQL using PDO
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Prepare and execute the query safely using a named parameter
        $stmt = $pdo->prepare('SELECT iddep, desdep FROM public."Departamentos" WHERE iddep = :iddep');
        $stmt->execute(['iddep' => $iddep]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = 'Database connection or query failed: ' . $e->getMessage();
    }

    // -------------------------------------------------------------------------------------------
    if ($row) {
        $text_iddep = strtoupper(trim($row['iddep']));
        $text_desdep = strtoupper(trim($row['desdep']));
    } else {  // REGISTRO NO EXISTE
        $url = 'departamentos.php?mensaje=En el departamento ' . $iddep . ' ! hay inconsitencia de datos, llamar al encargado de sistemas. !';;
        $url .= '&color=green';
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    }

    if (isset($_REQUEST['mensaje'])) {
        $message = $_REQUEST['mensaje'];
    } else {
        $message = '';
    }
}
// --------------------------------------------------------

?>
<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de asistencia</title>
    <script type="text/javascript" src="./js/funciones.js"></script>
    <link rel="stylesheet" href="./css/style_captura.css">
    <!-- Import Victorian-style serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=IM+Fell+English&display=swap" rel="stylesheet"> 
  </head>

  <body>
    <h1>Editar departamento</h1>
    <div class="steampunk-ledger">
        <form name='fsucursal' method="POST" action=''>               
         
            <div class="form-group">
                <label for="text_iddep">ID</label>
                 <!-- Standard text field -->
                <input type="text" id="text_iddep" name="text_iddep" maxlength="20" readonly value="<?php echo htmlspecialchars($text_iddep); ?>" >
            </div>
            <div class="form-group">
                <label for="text_desdep">Descripción</label>
                <!-- Standard text field -->
                <input type="text" id="text_desdep" name="text_desdep" maxlength="40" autocomplete="off" value="<?php echo htmlspecialchars($text_desdep); ?>" >
            </div>            
                 <div style="display: flex; gap: 10px;">
                  <input value='Cancelar' onclick="regresar('departamento')" type='button' class="steampunk-btn"> 
                  <button type="submit" class="steampunk-btn" >Grabar</button> 
            </div>
        </form>
<!--     Mensaje de validación al pie de la página si existe -->
        <?php if (!empty($message)): ?>
            <div class="ledger-response">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
    </body>
</html>