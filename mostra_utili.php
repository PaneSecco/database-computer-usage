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

//aggiunta degli utili

echo "<br>";
echo "<br>";
echo "<h2> Modifiche e eliminazione sulla tabella: </h2>";
echo "<p> Schiacciare sulla riga della tabella per inserire i dati qua sopra </p>";
echo "<p> Se i dati non vengono inseriti schiacciando sulla tabella ricaricare la tabella dalla combobox</p>";
echo "<br>";


    //Aggiunta delle textbox per ogni colonna
    echo "<form id='1'>";
    $columns_result->data_seek(0); // Riporta l'indice del risultato della query dei nomi delle colonne all'inizio
    
    while($column = $columns_result->fetch_assoc()) {
        echo "<label for='".$column['Field']."'>".$column['Field'].":</label><br>";
        $aggiunt = ($column['Field'] == 'id') ? "disabled" : ""; // Imposta $aggiunt a "disabled" solo se il nome del label è "id"
        echo "<input type='text' id='".$column['Field']."' name='".$column['Field']."' $aggiunt><br>";
    }
    echo "</form>";


//aggiunta dei bottoni

echo "<br>";
echo "<button type='button' onclick='modifica();'>Modifica</button>";
echo "<button type='button' onclick='cancella();'>Elimina</button>";

//aggiunta delle scritte

echo "<br>";
echo "<br>";
echo "<h2> Filtri sulla tabella: </h2>";
echo "<p> Schiacciare fuori dalla textbox una volta che si ha scritto cosa si vuole cercare</p>";
echo "<br>";



// aggiunta delle textbox e delle checkbox
echo "<form id='2'>";
$columns_result->data_seek(0); // Riporta l'indice del risultato della query dei nomi delle colonne all'inizio

while($column = $columns_result->fetch_assoc()) {
    $fieldId = "filtro_" . $column['Field']; // Aggiunge "filtro" all'inizio dell'id
    echo "<label for='".$fieldId."'>".$column['Field'].":</label><br>";
    echo "<input type='text' id='".$fieldId."' name='".$column['Field']."' onchange=eseguiRicerca();>";
    // Aggiunta delle checkbox con lo stesso nome della textbox, ma con un suffisso "_checkbox"
    echo "<input type='checkbox' id='".$fieldId."_checkbox' name='".$column['Field']."_checkbox' checked='true'; onchange=eseguiRicerca();>";
    echo "<br>";
}
echo "</form>";


echo "<br>";
echo "<br>";
echo "<h2> Aggiunta sulla tabella: </h2>";
echo "<p> L'id è auto-increment quindi non serve inserirlo (è mostrato comunque per questioni di continuità) </p>";
echo "<br>";


    //Aggiunta delle textbox per ogni colonna
    echo "<form id='3'>";
    $columns_result->data_seek(0); // Riporta l'indice del risultato della query dei nomi delle colonne all'inizio
    
    while($column = $columns_result->fetch_assoc()) {
        echo "<label for='".$column['Field']."'>".$column['Field'].":</label><br>";
        $aggiunt = ($column['Field'] == 'id') ? "disabled" : ""; // Imposta $aggiunt a "disabled" solo se il nome del label è "id"
        echo "<input type='text' id='".$column['Field']."' name='".$column['Field']."' $aggiunt><br>";
    }
    echo "</form>";

    echo "<br>";
    echo "<button type='button' onclick='aggiungi(); scuotiCaselleDiTesto();'>Aggiungi</button>";


// Chiudi la connessione al database
$conn->close();
?>