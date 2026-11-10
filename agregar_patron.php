<?php
require_once './funciones_generales.php';
// Initialize variables for feedback message
$text_idpat = '';
$text_razsoc = '';
$text_contra = '';
$lst_tipo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // POST request, process form submission
    // Capture and sanitize inputs
    $text_idpat = htmlspecialchars(trim($_POST['text_idpat'] ?? ''));
    $text_razsoc = htmlspecialchars(trim($_POST['text_razsoc'] ?? ''));
    $text_contra = htmlspecialchars(trim($_POST['text_contra'] ?? ''));
    $lst_tipo = htmlspecialchars(trim($_POST['lsttipo'] ?? ''));
    // Validate fields
    $message = '';
    $message .= valida_campo($text_idpat, 'alfanumerico', 'ID', 'El');
    $message .= valida_campo($text_razsoc, 'texto', 'Razón Social', 'La');
    $message .= valida_campo($text_contra, 'password', 'Contraseña', 'La');
    $message .= valida_campo($lst_tipo, 'seleccionado', 'Tipo de usuario', 'El');

    if (empty($message)) {
        $url = 'graba_patron.php?text_idpat=' . $_POST['text_idpat'];
        $url .= '&text_razsoc=' . $_POST['text_razsoc'];
        $url .= '&text_contra=' . $_POST['text_contra'];
        $url .= '&lsttipo=' . $_POST['lsttipo'];
        echo "<SCRIPT>window.location='$url';</SCRIPT>";
    } else {
        $text_idpat = strtoupper(trim($_REQUEST['text_idpat']));
        $text_razsoc = strtoupper(trim($_REQUEST['text_razsoc']));
        $text_contra = $_REQUEST['text_contra'];
        $lst_tipo = $_REQUEST['lsttipo'] ?? '';
    }
} else {  // GET request, initialize form fields with request parameters if available
    $text_idpat = strtoupper(trim($_REQUEST['text_idpat'] ?? ''));
    $text_razsoc = strtoupper(trim($_REQUEST['text_razsoc'] ?? ''));
    $text_contra = trim($_REQUEST['text_contra'] ?? '');
    $lst_tipo = $_REQUEST['lsttipo'] ?? '';

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
    <!-- Include FontAwesome for the eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>

  <body>
    <h1>Agregar patrón</h1>
    <div class="steampunk-ledger">
        <form name='fsucursal' method="POST" action=''>            
            <div class="form-group">
                <label for="text_idpat">ID</label>
                 <!-- Standard text field -->
                <input type="text" id="text_idpat" name="text_idpat" maxlength="10" autocomplete="off" value="<?php echo $text_idpat; ?>" >
            </div>
           
            <div class="form-group">
            <label for="text_contra">Contraseña:</label>
               <div  class="password-wrapper">
                <input type="password" id="text_contra" name="text_contra" maxlength="15" autocomplete="off" value="<?php echo $text_contra; ?>" >
                <i id="togglePass" class="fa-solid fa-eye" onclick="togglePasswordVisibility()"></i>
               </div>
            </div>

            <div class="form-group">
                <label for="lsttipo">Tipo de usuario:</label>
                <select id="lsttipo" name="lsttipo">
                    <option value="" disabled <?php echo ($lst_tipo == '') ? 'selected' : ''; ?>>-- Seleccione una opción --</option>
                    <option value="administrador" <?php echo ($lst_tipo == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="capturista" <?php echo ($lst_tipo == 'capturista') ? 'selected' : ''; ?>>Capturista</option>                    
               </select>
            </div>       
       
            <div class="form-group">
                <label for="text_razsoc">Razón Social</label>
                <!-- Standard text field -->
                <input type="text" id="text_razsoc" name="text_razsoc" maxlength="40" autocomplete="off" value="<?php echo $text_razsoc; ?>" >
            </div>

            <div style="display: flex; gap: 10px;">
                  <input value='Cancelar' onclick="regresar('usuario')" type='button' class="steampunk-btn"> 
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