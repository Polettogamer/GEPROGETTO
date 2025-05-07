<?php
// filepath: d:\Users\zeno.buogo\Desktop\xampp\htdocs\Github\GEPROGETTO\PagWebSchoolQ\php_front\utentiLista.php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
    header("Location: ../index.html"); // Redirect alla login se non autenticato
    exit;
}

// Configurazione della connessione al database
require_once "../php/connection.php";

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Utenti</title>
    <link rel="stylesheet" href="../CSS/utentiListaCSS.css"> <!-- Link al file CSS -->
</head>
<body>
<?php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query per ottenere tutti gli utenti
    $query = "SELECT userID, nome, cognome, email FROM utenti"; // Modifica il nome della tabella
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Mostra la lista degli utenti
    echo "<h1>Lista Utenti</h1>";
    echo "<table>";
    echo "<tr><th>Nome</th><th>Cognome</th><th>Email</th><th>Azioni</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cognome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='domandeUtente.php?id=" . urlencode($row['userID']) . "' class='button'>Visualizza Domande</a></td>";
        echo "</tr>";
    }

    echo "</table>";

    // Aggiungi il tasto per tornare alla home
    echo "<div class='center'>";
    echo "<a href='../php_front/dashboard.php' class='button'>Torna alla Home</a>";
    echo "</div>";
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
}
?>
</body>
</html>