<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Method Example</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .box { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .get { background-color: #e7f3fe; border-left: 6px solid #2196F3; }
        .post { background-color: #d4edda; border-left: 6px solid #28a745; }
    </style>
</head>
<body>

    <h2>PHP $_SERVER["REQUEST_METHOD"] Example</h2>

    <?php
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data sent via the form
        $name = htmlspecialchars($_POST["username"]);
        echo '<div class="box post">';
        echo "<h3>Form Submitted via POST!</h3>";
        echo "Hello, <strong>" . $name . "</strong>. Your data was processed securely.";
        echo '</div>';
    } 
    // Check if the request method is GET
    elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        echo '<div class="box get">';
        echo "<h3>Page Loaded via GET</h3>";
        echo "You are viewing this page normally or through a link.";
        echo '</div>';
    }
    ?>

    <hr>

    <!-- Simple Form that submits back to this same page using POST -->
    <form method="POST" action="">
        <label for="username">Enter your name:</label><br><br>
        <input type="text" id="username" name="username" required>
        <button type="submit">Submit Data</button>
    </form>

</body>
</html>