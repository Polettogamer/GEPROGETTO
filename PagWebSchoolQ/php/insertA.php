<?php
session_start();


// Configurazione della connessione al database
$servername = "localhost"; // Cambia se necessario
$username = "root"; // Il tuo username del database
$password = ""; // La tua password del database
$dbname = "schoolq"; // Nome del database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

try {
    // Recupero dati dal form
    $testo = $conn->real_escape_string($_POST['risposta']); 
    $domanda = ($_POST['QuestionID']);
    $userID = $_SESSION['userID']; 
    $dataPubblicazione = date('Y-m-d H:i:s');

    // Query per inserire la domanda con Prepared Statements
    $sql = "INSERT INTO risposte (dataPubbl, testoRisposta, nLike, QuestionID, userID) 
            VALUES (?, ?, 0, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Errore nella preparazione della query: " . $conn->error);
    }

    // Associare i parametri alla query
    $stmt->bind_param("ssii", $dataPubblicazione, $testo, $domanda, $userID);

    // Esegui la query
    if ($stmt->execute()) {
        header("Location: ../php_front/risposta.php?id=$domanda&success=insert_success");
        exit();
    } else {
        throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
    }

} catch (Exception $e) {
    // Controlla il codice errore MySQL per gestire errori specifici
    switch ($stmt->errno) {
        case 1452: // ER_NO_REFERENCED_ROW_2 (errore di chiave esterna)
            header("Location: ../php_front/risposta.php?id=$domanda&error=invalid_foreign_key");
            break;
        case 1048: // ER_BAD_NULL_ERROR (campo obbligatorio nullo)
            header("Location: ../php_front/risposta.php?id=$domanda&error=null_value");
            break;
        default:
            header("Location: ../php_front/risposta.php?id=$domanda&error=db_error&");
    }
    exit();
} finally {
    // Chiudere la connessione
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}

?>