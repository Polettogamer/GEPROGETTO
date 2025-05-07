<?php
// filepath: d:\Users\zeno.buogo\Desktop\xampp\htdocs\Github\GEPROGETTO\PagWebSchoolQ\php_front\domandeUtente.php

session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
    header("Location: ../index.html"); // Redirect alla login se non autenticato
    exit;
}

// Configurazione della connessione al database
$host = '127.0.0.1'; // Host del database
$dbname = 'schoolq'; // Nome del database
$username = 'root'; // Username del database
$password = ''; // Password del database (lascia vuoto se non c'è)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica che l'ID dell'utente sia passato come parametro GET
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ID utente non specificato.";
        exit;
    }

    $userID = intval($_GET['id']); // Sanitizza l'input

    // Query per ottenere le domande dell'utente
    $query = "SELECT questionID, dataPubbl, QuestionText, nLike 
              FROM domande 
              WHERE userID = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Mostra le domande dell'utente
    echo "<h1>Domande dell'Utente</h1>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID Domanda</th><th>Data Pubblicazione</th><th>Testo Domanda</th><th>Like</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['questionID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dataPubbl']) . "</td>";
        echo "<td>" . htmlspecialchars($row['QuestionText']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nLike']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
}
?>