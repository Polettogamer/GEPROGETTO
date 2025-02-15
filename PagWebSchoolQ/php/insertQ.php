<?php
$id = isset($_GET['userID']) ? intval($_GET['userID']) : null;
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


// Controlla se i dati sono stati inviati via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {


        // Recupero e sanificazione dati dal form
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $testo = $conn->real_escape_string($_POST['domanda']);
        $userID = $id;
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
            header("Location: ../php_front/dashboard.php?success=insert_success&userID=$id");
            exit();
        } else {
            throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
        }

    } catch (Exception $e) {
        // Controlla il codice errore MySQL per gestire errori specifici
        switch ($stmt->errno) {
            case 1452: // ER_NO_REFERENCED_ROW_2 (errore di chiave esterna)
                header("Location: ../php_front/dashboard.php?error=invalid_foreign_key&userID=$id");
                break;
            case 1048: // ER_BAD_NULL_ERROR (campo obbligatorio nullo)
                header("Location: ../php_front/dashboard.php?error=null_value&userID=$id");
                break;
            default:
                header("Location: ../php_front/dashboard.php?error=db_error&userID=$id");
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
