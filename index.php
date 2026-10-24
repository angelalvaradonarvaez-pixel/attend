 
<?php

if (!isset($_GET['topic'])) {
    $tema = 'Menu';
} else {
    $tema = $_GET['topic'];
}

if (!isset($_GET['subtopic'])) {
    $subtema = 'null';
} else {
    $subtema = $_GET['subtopic'];
}
require_once './definitions.php';
require_once './menu_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrl de asistencia</title>
    <link rel="stylesheet" href="./css/style.css">
     <!-- Import Victorian-style serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=IM+Fell+English&display=swap" rel="stylesheet">
   
</head>
<body>

    <header>
        <div class="logo">
            <h1>Control de asistencia</h1>
        </div> 
    </header>

 <?php switch ($tema) {
    case 'Catalogos': ?>
        <?php switch ($subtema) {
            case 'Turnos': ?>
               <?php echo " <script>document.location.href= './turnos.php'; </script>"; ?>
          <?php break; ?> 
          <?php case 'Departamentos': ?>
               <?php echo " <script>document.location.href= './departamentos.php'; </script>"; ?>
          <?php break; ?> 
          <?php case 'Sucursales': ?>
                <?php echo " <script>document.location.href= './sucursales.php'; </script>"; ?>
         <?php break;
        } ?>    
    <?php break; ?>
   
    <?php } ?>
 
   
    <?php echo render_steampunk_menu($menu_data); ?>
    
     <footer>
      <!--     <p>&copy; <?php echo date('Y'); ?> My Website. All rights reserved.</p>  -->
    </footer>
  

</body>
</html>