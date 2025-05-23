<?php
session_start();
require_once "connection.php";

// Controlla se i dati sono stati inviati via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {


        // Recupero e sanificazione dati dal form
        $categoria = filter_var($_POST['categoria'], FILTER_VALIDATE_INT);
        $testo = trim($_POST['domanda']);
        $userID = $_SESSION['userID'];
        
        if (!$categoria || empty($testo) || !$userID) {
            header("Location: ../php_front/dashboard.php?error=invalid_input");
            exit();
        }
        
        $dataPubblicazione = date('Y-m-d H:i:s');

        
        
        

        // Query per inserire la domanda con Prepared Statements
        $sql = "INSERT INTO domande (dataPubbl, QuestionText, nLike, categoriaID, userID) 
                VALUES (?, ?, 0, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Errore nella preparazione della query: " . $conn->error);
        }

        // Associare i parametri alla query
        $stmt->bind_param("ssii", $dataPubblicazione, $testo, $categoria, $userID);

        // Esegui la query
        if ($stmt->execute()) {
            header("Location: ../php_front/dashboard.php?success=insert_success");
            exit();
        } else {
            throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
        }

    } catch (Exception $e) {
        // Controlla il codice errore MySQL per gestire errori specifici
        switch ($stmt->errno) {
            case 1452: // ER_NO_REFERENCED_ROW_2 (errore di chiave esterna)
                header("Location: ../php_front/dashboard.php?error=invalid_foreign_key");
                break;
            case 1048: // ER_BAD_NULL_ERROR (campo obbligatorio nullo)
                header("Location: ../php_front/dashboard.php?error=null_value");
                break;
            default:
                header("Location: ../php_front/dashboard.php?error=db_error");
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
