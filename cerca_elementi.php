<?php
// Connessione al database
$servername = "localhost"; 
$username = "BonnieTyler";
$password = "12345"; 
$dbname = "allaboutpc"; 

$Query = $_POST['query'];

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Eseguire la query
$sql = $Query;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output dei dati in una tabella HTML
    echo "<table border='1'><tr>";
    
    // Stampa il nome delle colonne
    $row = $result->fetch_assoc();
    foreach ($row as $key => $value) {
        echo "<th>$key</th>";
    }
    echo "</tr>";
    
    // Stampa le righe del risultato
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 risultati";
}
$conn->close();
?>
