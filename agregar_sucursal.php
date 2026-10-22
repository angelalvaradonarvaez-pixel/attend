<?php
// Initialize variables for feedback message
$message = "";
$text_idsuc= "";
$text_dessuc = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize inputs
     $text_idsuc = htmlspecialchars(trim($_POST['text_idsuc'] ?? ''));
     $text_dessuc = htmlspecialchars(trim($_POST['text_dessuc'] ?? ''));

   // echo "ID, " . htmlspecialchars($text_idsuc) . "!";

    
    if ($text_idsuc !== '' && $text_dessuc !== '') {
        $message = "Transmission Received! ID: <strong>{$text_idsuc}</strong> | Descripción: <strong>{$text_dessuc}</strong>";
    } else {
        $message = "Error: Please fill out all fields of the ledger.";
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
        <form name='fsucursal' method="POST" action="graba_sucursal.php">
            
            <div class="form-group">
                <label for="text_idsuc">ID</label>
                 <!-- Standard text field -->
                <input type="text" id="text_idsuc" name="text_idsuc" maxlength="20" autocomplete="off" value="<?php echo $text_idsuc; ?>" required>
            </div>

            <div class="form-group">
                <label for="text_dessuc">Descripción</label>
                <!-- Standard text field -->
                <input type="text" id="text_dessuc" name="text_dessuc" maxlength="40" autocomplete="off" value="<?php echo $text_dessuc; ?>" required>
            </div>
            <div style="display: flex; gap: 10px;">

            <input value='Cancelar' onclick='javascript:history.go(-1)' type='button' class="steampunk-btn">
            <input value='Grabar' onclick='valida_alta_sucursal()' type='button' class="steampunk-btn">
             <!--<button type="submit" class="steampunk-btn" onclick='valida_alta_cargada()' >Cancelar</button>-->
             <!--<button type="submit" class="steampunk-btn" onclick='valida_alta_cargada()' >Grabar</button>-->
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