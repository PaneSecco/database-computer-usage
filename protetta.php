<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    /* Stile generale */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 20px; /* Aggiunto padding al body */
        background-color: #f5f5f5;
        color: #333;
    }

    .container {
        max-width: 800px;
        margin: 0 auto; /* Centrato il container */
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #444;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Stile per il testo in corsivo */
    .italic {
        font-style: italic;
    }

    /* Stile dei bottoni */
    button[type='button'] {
        background-color: #4e8cff; /* Colore di sfondo azzurrino */
        color: white; /* Testo bianco */
        padding: 10px 20px; /* Padding interno */
        font-size: 14px; /* Dimensione del font */
        border: none; /* Nessun bordo */
        border-radius: 4px; /* Angoli arrotondati */
        cursor: pointer; /* Cambia il cursore al passaggio del mouse */
        transition: background-color 0.3s ease; /* Transizione del colore di sfondo */
    }

    /* Stile dei bottoni al passaggio del mouse */
    button[type='button']:hover {
        background-color: #357ae8; /* Colore di sfondo azzurrino più scuro al passaggio del mouse */
    }

    /* Stile delle caselle di testo */
    input[type='text'] {
        width: 30%; /* Larghezza del 100% per adattarsi al contenitore */
        padding: 8px; /* Padding interno ridotto */
        font-size: 14px; /* Dimensione del font ridotta */
        margin-bottom: 10px; /* Spazio inferiore tra le caselle di testo */
    }

    input[type="text"]:focus {
        border-color: #4CAF50;
    }

    /* Stile per le etichette */
    label {
        font-weight: bold;
    }

    /* Stile per gli avvisi */
    .alert {
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #dff0d8;
        border: 1px solid #d6e9c6;
        color: #3c763d;
    }

    .alert-danger {
        background-color: #f2dede;
        border: 1px solid #ebccd1;
        color: #a94442;
    }

    .scuoti {
    border-color: red; /* Cambia il colore del bordo per indicare che la casella di testo è scossa */
    animation: shake 0.5s; /* Aggiungi un'animazione di scuotimento */
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        20% { transform: translateX(-10px); }
        40% { transform: translateX(10px); }
        60% { transform: translateX(-10px); }
        80% { transform: translateX(10px); }
        100% { transform: translateX(0); }
    }

</style>
</head>
<body>
    <h1> Accesso eseguito con successo al database <span class="italic">allaboutpc</span> </h1>
<script>
    // Funzione per creare un oggetto XMLHttpRequest
    function createXHR() {
        if (window.XMLHttpRequest) {
            // Codice per browser moderni
            return new XMLHttpRequest();
        } else {
            // Codice per browser legacy
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    function stampatabella(){
        console.log("Funzione stampatabella() chiamata.");
        var selectElement = document.getElementById("select");
        console.log("Valore selezionato:", selectElement.value);
        var tableName = selectElement.value;

        // Effettua la richiesta xhr con il nome della tabella come parametro
        var xhr = createXHR();
        xhr.open("GET", "mostra_tabella.php?table_name=" + tableName, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Ricevi la risposta e aggiungi il contenuto alla pagina
                document.getElementById("tabella").innerHTML = xhr.responseText;

                // Dopo aver ottenuto il contenuto della tabella, aggiunge i listener agli eventi di click sulle righe
                var rows = document.getElementById("myTable").getElementsByTagName("tr");
                for (var i = 0; i < rows.length; i++) {
                    var currentRow = rows[i];
                    currentRow.addEventListener("click", function() {
                        var cells = this.getElementsByTagName("td");
                        var inputFields = document.getElementsByTagName("input");
                        for (var j = 0; j < cells.length; j++) {
                            inputFields[j].value = cells[j].innerText;
                        }
                    });
                }
            }
        };
        xhr.send();
    }


    // Funzione per eseguire la query di ricerca
    function eseguiRicerca() {

        // Ottieni il valore selezionato dalla combobox
        var tabella = document.getElementById("select").value;

        // Inizializza la stringa della query di ricerca
        var query = "SELECT ";

        // Inizializza un array per memorizzare i nomi delle colonne selezionate
        var colonneSelezionate = [];

        // Seleziona tutte le checkbox di filtro
        var checkboxes = document.querySelectorAll("[id^='filtro_']");

        // Cicla attraverso tutte le checkbox
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                // Ottieni il nome della colonna dalla checkbox
                var colonna = checkbox.id.replace("filtro_", "").replace("_checkbox", "");
                // Aggiungi la colonna agli array delle colonne selezionate e della query
                colonneSelezionate.push(colonna);
            }
        });

        if(colonneSelezionate.length==0){
            document.getElementById("tabella").innerHTML = "<p> tabella vuota </p>";
        }else{

        // Aggiungi le colonne selezionate alla query
        query += colonneSelezionate.join(", ");
        query += " FROM " + tabella;

        // Seleziona tutti gli elementi di input di tipo text all'interno della form con id "2"
        var textBoxes = document.getElementById("2").getElementsByTagName('input');

        // Inizializza un array per memorizzare le condizioni di ricerca
        var condizioni = [];

        // Cicla attraverso tutte le textbox
        for (var i = 0; i < textBoxes.length; i++) {
            var textBox = textBoxes[i];
            if (textBox.type === 'text' && textBox.value!=="") {
                var id = textBox.id.replace("filtro_", "");
                console.log("id: "+id);
                var value = textBox.value;
                condizioni.push(id + " LIKE '%" + value + "%'");
            }
        }

        if(condizioni.length>0){
            query += " WHERE ";
        }

        // Aggiungi le condizioni alla query
        query += condizioni.join(" AND ");

        // Esegui qui la query con query
        console.log("Query di ricerca:", query);

        var xhr = createXHR();
        xhr.open("POST", "cerca_elementi.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log("Richiesta completata con successo");
                    console.log("Risposta dal server:", xhr.responseText);
                    document.getElementById("tabella").innerHTML = xhr.responseText;
                                    
                    // Dopo aver ottenuto il contenuto della tabella, aggiunge i listener agli eventi di click sulle righe
                    var rows = document.getElementById("select").getElementsByTagName("tr");
                    for (var i = 0; i < rows.length; i++) {
                        var currentRow = rows[i];
                        currentRow.addEventListener("click", function() {
                            var cells = this.getElementsByTagName("td");
                            // Cicla attraverso tutte le colonne della riga selezionata
                            for (var j = 0; j < cells.length; j++) {
                                // Ottieni l'ID della textbox corrispondente alla colonna
                                var textBoxId = "filtro_" + j;
                                var textBox = document.getElementById(textBoxId);
                                if (textBox) {
                                    // Popola la textbox solo se esiste
                                    textBox.value = cells[j].innerText;
                                }
                            }
                        });
                    }


                } else {
                    console.error("Si è verificato un errore durante la richiesta:", xhr.status);
                }
            }
        };

        xhr.send("query=" + encodeURIComponent(query));
        }
    }


    function stampautili(){
        var selectElement = document.getElementById("select");
        var tableName = selectElement.value;

        // Effettua la richiesta xhhr con il nome della tabella come parametro
        var xhr = createXHR();
        xhr.open("GET", "mostra_utili.php?table_name=" + tableName, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Ricevi la risposta e aggiungi il contenuto alla pagina
                document.getElementById("utili").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    function continua() {
        var risposta = prompt("Vuoi continuare? (sì/no)").toLowerCase().trim();
        if (risposta === "sì" || risposta === "si") {
            return true;
        } else if (risposta === "no") {
            return false;
        } else {
            alert("Risposta non valida. Per favore, rispondi con 'sì' o 'no'.");
            return continua();
        }
    }

    function controllaCampi(formid) {
            // Controlla i campi del form con id formid
            var form = document.getElementById(formid);
            var campiForm = form.querySelectorAll("input[type='text']");
            var campiCompilatiForm = true;

            campiForm.forEach(function(campo) {
                if (campo.id !== "id" && campo.value === "") {
                    campiCompilatiForm = false;
                }
            });

            // Se almeno un campo in uno dei due form non è compilato, blocca la funzione
            if (!campiCompilatiForm ) {
                alert("Per favore compila tutti i campi prima di procedere.");
                scuotiCaselleDiTesto(formid);
                return false; // Blocca la funzione
            }

            // Altrimenti, se tutti i campi sono compilati, procedi con l'azione desiderata
            // Esempio: Invio del modulo
            return true; // Consente l'esecuzione della funzione
        }

    function svuotaCaselle() {
        // Svuota le caselle di testo nel modulo con id uguale a 1
        svuotaCaselleModulo('1');
        
        // Svuota le caselle di testo nel modulo con id uguale a 3
        svuotaCaselleModulo('3');
    }

    function svuotaCaselleModulo(idModulo) {
        // Seleziona il modulo con l'id specificato
        var modulo = document.getElementById(idModulo);

        // Se il modulo esiste
        if (modulo) {
            // Seleziona tutte le caselle di testo all'interno del modulo
            var caselleDiTesto = modulo.querySelectorAll('input[type="text"]');

            // Itera su tutte le caselle di testo e svuotale
            caselleDiTesto.forEach(function(casellaDiTesto) {
                casellaDiTesto.value = ''; // Svuota il valore della casella di testo
            });
        }
    }

    function scuotiCaselleDiTesto(formid) {
        // Seleziona il modulo con id uguale a formid
        var modulo = document.getElementById(formid);

        // Se il modulo esiste
        if (modulo) {
            // Seleziona tutte le caselle di testo all'interno del modulo
            var caselleDiTesto = modulo.querySelectorAll('input[type="text"]');

            // Controlla se ci sono caselle di testo vuote
            var ciSonoCaselleVuote = false;
            caselleDiTesto.forEach(function(casellaDiTesto) {
                if (casellaDiTesto.value.trim() === '') {
                    ciSonoCaselleVuote = true;
                    casellaDiTesto.classList.add('scuoti');
                }
            });

            // Rimuovi la classe di scuotimento dopo un po' di tempo
            if (ciSonoCaselleVuote) {
                setTimeout(function() {
                    caselleDiTesto.forEach(function(casellaDiTesto) {
                        casellaDiTesto.classList.remove('scuoti');
                    });
                }, 1000); // Tempo in millisecondi dopo il quale rimuovere la classe di scuotimento (es. 1000ms = 1 secondo)
            }
        }
    }
</script>

<?php
// Configurazione della connessione al database
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

// Query per ottenere i nomi delle tabelle nel database
$sql = "SHOW TABLES";
$result = $conn->query($sql);

// Verifica se ci sono tabelle nel database
if ($result->num_rows > 0) {
    echo "<label for='table_name'>Seleziona una tabella da visualizzare: </label>";
    echo "<select name='table_name' id='select' onchange='stampatabella(); stampautili();'>";
    // Output delle opzioni della combobox
    while($row = $result->fetch_row()) {
        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
    }
    echo "</select>";
    echo "<br>";
    echo "<br>";
} else {
    echo "Nessuna tabella trovata nel database.";
}

// Chiudi la connessione al database
$conn->close();
?>

<div id="tabella">
    <!-- qui verranno visualizzati i risultati filtrati dal database-->
  </div>

  <div id="utili">
    <!-- qui verranno visualizzati i risultati filtrati dal database-->
  </div>

<script>
function modifica() {
    stampatabella();
    var formId = "1";
    if (!controllaCampi(formId)) {
        // Se i campi non sono compilati, interrompi l'esecuzione della funzione aggiungi()
        return;
    }
    if (continua()) {
            console.log("Continuiamo...");
        } else {
            console.log("Fine.");
            return;
        }
    console.log("modifica");
    var formId="1";
    var selectBox = document.getElementById("select");
    var selectedValue = selectBox.value;
    var form = document.getElementById(formId);
    var inputs = form.getElementsByTagName('input');
    var valuesToUpdate = [];

    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        if (input.type === 'text') {
            var id = input.id;
            var value = input.value;
            valuesToUpdate.push({ id: id, value: value });
        }
    }

    var Query = "UPDATE " + selectedValue + " SET ";
    for (var j = 0; j < valuesToUpdate.length; j++) {
        var pair = valuesToUpdate[j];
        Query += pair.id + " = '" + pair.value + "'";
        if (j < valuesToUpdate.length - 1) {
            Query += ", ";
        }
    }

    var selectText = document.getElementById("id");
    var val = selectText.value;

    Query += " WHERE id =" + val;

    // Esegui qui la query con updateQuery
    console.log("Query di aggiornamento:", Query);


    var xhr = createXHR();
    xhr.open("POST", "esegui_query.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Richiesta completata con successo");
                console.log("Risposta dal server:", xhr.responseText);
                // Gestisci la risposta dal server se necessario
            } else {
                console.error("Si è verificato un errore durante la richiesta:", xhr.status);
            }
        }
    };
    xhr.send("Query=" + encodeURIComponent(Query));

    eseguiRicerca();
    svuotaCaselle();
}

function cancella(){
    stampatabella();
    var formId = "1";
    if (!controllaCampi(formId)) {
        // Se i campi non sono compilati, interrompi l'esecuzione della funzione aggiungi()
        return;
    }
    if (continua()) {
            console.log("Continuiamo...");
        } else {
            console.log("Fine.");
            return;
        }
    var id = document.getElementById("id").value; // Ottieni il valore dall'input con id "id"
    console.log(id);
    var selectElement = document.getElementById("select");
    var tableName = selectElement.value;
    var Query="DELETE FROM " + tableName + " WHERE id =" + id;
    var xhr = createXHR();
    xhr.open("POST", "esegui_query.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Richiesta completata con successo");
                console.log("Risposta dal server:", xhr.responseText);
                // Gestisci la risposta dal server se necessario
            } else {
                console.error("Si è verificato un errore durante la richiesta:", xhr.status);
            }
        }
    };
    xhr.send("Query=" + encodeURIComponent(Query));
    eseguiRicerca();
    svuotaCaselle();
}

function aggiungi(){
    stampatabella();
    var formId = "3";
    if (!controllaCampi(formId)) {
        // Se i campi non sono compilati, interrompi l'esecuzione della funzione aggiungi()
        return;
    }
    if (continua()) {
            console.log("Continuiamo...");
        } else {
            console.log("Fine.");
            return;
        }
    var selectBox = document.getElementById("select");
    var selectedValue = selectBox.value;
    var form = document.getElementById(formId);
    var inputs = form.getElementsByTagName('input');
    var colonne = [];
    var valori = [];

for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    if (input.type === 'text') {
        var id = input.id;
        var value = input.value;
        // Escludi l'id "id" dalla lista delle colonne
        if (id !== "id") {
            colonne.push(id);
            valori.push("'" + value + "'");
        }
    }
}

var Query = "INSERT INTO " + selectedValue + " (";
Query += colonne.join(", ") + ") VALUES (";
Query += valori.join(", ") + ");";

// Esegui qui la query con insertQuery
console.log("Query di inserimento:", Query);

var xhr = createXHR();
xhr.open("POST", "esegui_query.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            console.log("Richiesta completata con successo");
            console.log("Risposta dal server:", xhr.responseText);
            // Gestisci la risposta dal server se necessario
        } else {
            console.error("Si è verificato un errore durante la richiesta:", xhr.status);
        }
    }
};
xhr.send("Query=" + encodeURIComponent(Query));

eseguiRicerca();
svuotaCaselle();
}
</script>

</body>
</html>