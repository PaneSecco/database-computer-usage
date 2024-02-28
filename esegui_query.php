<?php
$servername = "localhost";
$username = "BonnieTyler";
$password = "12345";
$dbname = "allaboutpc";

// Recupera la query di inserimento dalla richiesta POST
$Query = $_POST['Query'];

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Esegui la query di inserimento
if ($conn->query($Query) === TRUE) {
    echo "Nuova riga inserita con successo";
} else {
    echo "Errore durante la query: " . $conn->error;
}

// Chiudi la connessione al database
$conn->close();
?>
