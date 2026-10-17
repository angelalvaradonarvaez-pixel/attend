<?php
$host     = "127.0.0.1";
$port     = "5432";
$dbname   = "Ejemplos";     // 1. Specify the 'examples' database here
$user     = "postgres";
$password = "harryh";

// Build the connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Connect to the 'examples' database
$dbconn = @pg_connect($conn_string);

if (!$dbconn) {
    echo "Connection failed: " . htmlspecialchars(pg_last_error());
} else {
    echo "Connected to the 'Ejemplos' database successfully!<br><br>";

    // 2. Query the 'sucursales' table 
    // (Optional: prefix with 'public.' if it lives in the default public schema)
    $query = "SELECT * FROM public.\"Sucursales\";";
    $result = pg_query($dbconn, $query);

    if (!$result) {
        echo "Query failed: " . htmlspecialchars(pg_last_error());
    } else {
        // Fetch and display the rows from 'sucursales'
        echo "<h3>Sucursales List:</h3>";
        while ($row = pg_fetch_assoc($result)) {
            // Adjust 'id' and 'nombre' to match your actual column names
            echo "ID: " . htmlspecialchars($row['idsuc']) . " | Name: " . htmlspecialchars($row['dessuc']) . "<br>";
        }
    }

    // Close the connection
    pg_close($dbconn);
}
?>