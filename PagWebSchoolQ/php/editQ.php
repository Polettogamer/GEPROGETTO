<?php
session_start();
require_once "connection.php";

// Controlla se i dati sono stati inviati via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {


        // Recupero e sanificazione dati dal form
        $testo = trim($_POST['domanda']);
        $qID = $_GET["id"];
        
        
        $dataPubblicazione = date('Y-m-d H:i:s');

        
        
        

        // Query per inserire la domanda con Prepared Statements
        $sql = "UPDATE domande SET QuestionText = ? WHERE questionID = $qID";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Errore nella preparazione della query: " . $conn->error);
        }

        // Associare i parametri alla query
        $stmt->bind_param("s", $testo);

        // Esegui la query
        if ($stmt->execute()) {
            header("Location: ../php_front/risposta.php?id=$qID&success=edit_success");
            exit();
        } else {
            throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
        }

    } catch (Exception $e) {
        // Controlla il codice errore MySQL per gestire errori specifici
        switch ($stmt->errno) {
            case 1452: // ER_NO_REFERENCED_ROW_2 (errore di chiave esterna)
                header("Location: ../php_front/dashboard.php?id=$qID&error=invalid_foreign_key");
                break;
            case 1048: // ER_BAD_NULL_ERROR (campo obbligatorio nullo)
                header("Location: ../php_front/dashboard.php?id=$qID&error=null_value");
                break;
            default:
                header("Location: ../php_front/dashboard.php?id=$qID&error=db_error");
        }
        exit();
    } finally {
        // Chiudere la connessione
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
}
?>
