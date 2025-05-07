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

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domande Utente</title>
    <link rel="stylesheet" href="../CSS/domandeUtenteCSS.css"> <!-- Link al file CSS -->
</head>
<body>
<?php
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

    if ($stmt->rowCount() > 0) {
        echo "<table>";
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
    } else {
        echo "<p class='center'>L'utente deve ancora fare una domanda.</p>";
    }

    // Aggiungi i bottoni per tornare alla lista utenti e alla home
    echo "<div class='center' style='margin-top: 20px;'>";
    echo "<a href='utentiLista.php' class='button' style='margin-right: 10px;'>Torna alla Lista Utenti</a>";
    echo "<a href='../php_front/dashboard.php' class='button' style='margin-left: 10px;'>Torna alla Home</a>";
    echo "</div>";
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
}
?>
</body>
</html>