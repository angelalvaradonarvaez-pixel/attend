<?php
require_once './funciones_generales.php';
// Initialize variables for feedback message
$text_iddep = '';
$text_desdep = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // POST request, process form submission
    // Capture and sanitize inputs
    $text_iddep = htmlspecialchars(trim($_POST['text_iddep'] ?? ''));
    // Validate fields
    $message = '';
    $message .= valida_campo($text_iddep, 'alfanumerico', 'ID');
    //  $message .= valida_campo($text_dessuc, 'texto', 'Descripción');
    if (empty($message)) {  // TODOS LOS CAMPOS SON VALIDOS
        $url = 'busca_departamento.php?text_iddep=' . $_POST['text_iddep'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $text_iddep = strtoupper(trim($_REQUEST['text_iddep']));
    }
} else {  // GET request, initialize form fields with request parameters if available
    $text_iddep = strtoupper(trim($_REQUEST['text_iddep'] ?? ''));
    if (isset($_REQUEST['mensaje'])) {
        $message = $_REQUEST['mensaje'];
    } else {
        $message = '';
    }
}
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
    <h1>Buscar departamento</h1>
    <div class="steampunk-ledger">
        <form name='fsucursal' method="POST" action=''>            
            <div class="form-group">
                <label for="text_iddep">ID</label>
                 <!-- Standard text field -->
                <input type="text" id="text_iddep" name="text_iddep" maxlength="20" autocomplete="off" value="<?php echo $text_iddep; ?>" >
            </div>
            <div style="display: flex; gap: 10px;">
                  <input value='Cancelar' onclick="regresar('departamento')" type='button' class="steampunk-btn"> 
                  <button type="submit" class="steampunk-btn" >Buscar</button> 
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