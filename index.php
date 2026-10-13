 
<?php
session_start();
if (!isset($_GET['topic'])) {
    $_SESSION['tema'] = 'null';
} else {
    $_SESSION['tema'] = $_GET['topic'];
}

if (!isset($_GET['subtopic'])) {
    $_SESSION['subtema'] = 'null';
} else {
    $_SESSION['subtema'] = $_GET['subtopic'];
}

require_once './definitions.php';
require_once './functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrl de asistencia</title>
    <link rel="stylesheet" href="style.css">
     <!-- Import Victorian-style serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=IM+Fell+English&display=swap" rel="stylesheet">
   
</head>
<body>

    <header>
        <div class="logo">
            <h1>Control de asistencia</h1>
        </div> 
    </header>
    <?php echo render_steampunk_menu($menu_data); ?>
    <footer>
       <!-- <p>&copy; <?php echo date('Y'); ?> My Website. All rights reserved.</p> -->
    </footer>
</body>
</html>
