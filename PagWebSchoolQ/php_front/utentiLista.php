<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
    header("Location: ../index.html"); // Redirect alla login se non autenticato
    exit;
}

// Configurazione della connessione al database
require_once "../php/connection.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query per ottenere tutti gli utenti
    $query = "SELECT userID, nome, cognome, email FROM utenti"; // Modifica il nome della tabella
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Mostra la lista degli utenti
    echo "<h1>Lista Utenti</h1>";
    echo "<table border='1' cellpadding='10'>";
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
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
}
?>