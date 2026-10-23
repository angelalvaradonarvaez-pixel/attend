<?php
// Initialize variables for feedback message

$text_idsuc = '';
$text_dessuc = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize inputs
    $text_idsuc = htmlspecialchars(trim($_POST['text_idsuc'] ?? ''));
    $text_dessuc = htmlspecialchars(trim($_POST['text_dessuc'] ?? ''));

    // echo "ID, " . htmlspecialchars($text_idsuc) . "!";
    $Continuar = 'si';

    //   if ($Continuar == 'si') {
    if ($text_idsuc == '') {
        $message = 'Especifique el ID.';
        $Continuar = 'no';
    }
    //   }

    //   if ($Continuar == 'si') {
    if ($text_dessuc == '') {
        $message .= '<br>' . 'Especifique la descripción.';
        $Continuar = 'no';
    }
    //   }

    if ($Continuar == 'si') {
        $url = 'graba_sucursal.php?text_idsuc=' . $_POST['text_idsuc'];
        $url .= '&text_dessuc=' . $_POST['text_dessuc'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else
        $text_idsuc = strtoupper(trim($_REQUEST['text_idsuc']));
    $text_dessuc = strtoupper(trim($_REQUEST['text_dessuc']));
} else {
    $text_idsuc = strtoupper(trim($_REQUEST['text_idsuc'] ?? ''));
    $text_dessuc = strtoupper(trim($_REQUEST['text_dessuc'] ?? ''));
    if (isset($_REQUEST['mensaje'])) {
        $message = $_REQUEST['mensaje'];
    } else {
        $menssage = '';
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

    <h1>Agregar sucursal</h1>

    <div class="steampunk-ledger">
        <!-- "<form name='fcargada' method='post' enctype='multipart/form-data' action='graba_cargada.php' >"; -->
        <form name='fsucursal' method="POST" action=''>
            
            <div class="form-group">
                <label for="text_idsuc">ID</label>
                 <!-- Standard text field -->
                <input type="text" id="text_idsuc" name="text_idsuc" maxlength="20" autocomplete="off" value="<?php echo $text_idsuc; ?>" >
            </div>
            <div class="form-group">
                <label for="text_dessuc">Descripción</label>
                <!-- Standard text field -->
                <input type="text" id="text_dessuc" name="text_dessuc" maxlength="40" autocomplete="off" value="<?php echo $text_dessuc; ?>" >
            </div>
            <div style="display: flex; gap: 10px;">

                  <input value='Cancelar' onclick="regresar('sucursal')" type='button' class="steampunk-btn"> 
                  <button type="submit" class="steampunk-btn" >Grabar</button> 
            </div>
        </form>


        <?php if (!empty($message)): ?>
            <div class="ledger-response">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>


</body>

</html>