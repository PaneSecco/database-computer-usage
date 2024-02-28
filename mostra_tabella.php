<?php
$servername = "localhost"; 
$username = "BonnieTyler";
$password = "12345"; 
$dbname = "allaboutpc"; 

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// ottienne il nome della tabella dalla richiesta xhr
$table_name = $_GET['table_name'];

// Query per ottenere tutti i dati dalla tabella del database
$sql = "SELECT * FROM $table_name";
$result = $conn->query($sql);

// Query per ottenere i nomi delle colonne della tabella
$columns_sql = "SHOW COLUMNS FROM $table_name";
$columns_result = $conn->query($columns_sql);

//scrittura titolo

echo "<h2>Tabella: $table_name</h2>";

// costruzione della tabella html con i dati ottenuti dalla query
if ($result->num_rows > 0) {
    echo "<table border='1' id='myTable'>";
    echo "<tr>";
    // Output dei nomi delle colonne
    while($column = $columns_result->fetch_assoc()) {
        echo "<th>".$column['Field']."</th>";
    }
    echo "</tr>";
    // output dei dati per ogni riga
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>".$value."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "Nessun risultato trovato.";
}

// Chiudi la connessione al database
$conn->close();
?>
