<html>
<body>
<?php
session_start();

$n=$_REQUEST["username"];
$p=$_REQUEST["password"];

$servername = "localhost";
$username = "BonnieTyler";
$password = "12345";
$dbname = "allaboutpc";

$conn = new mysqli($servername, $username, $password, $dbname);

/*
ChingChong
KequingMain

Desanta88
SonicTheHedgehog

FataEnchantix
WinxSupewmacy

MontagnoloMentale
Serenella

RomanianGirl69
SeggPazz

*/

$sql = "SELECT username, Password FROM utenti WHERE username = '$n' AND password = '$p'";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    // L'utente è autenticato, impostalo nella sessione e reindirizzalo alla pagina protetta
    $_SESSION["UTENTE"] = $n;
    header("location:protetta.php");
    exit();
} else {
    // L'utente non è autenticato, pulisci la sessione e mostra un messaggio di errore
    unset($_SESSION["UTENTE"]);
    echo "Non autenticato";
}

$conn->close();
?>
</body>
</html>