<?php
session_start();
$id_utente = $_SESSION["userID"];

// Funzione per aggiornare un campo nel database
function upload($conn, $dove, $dato, $id_utente) {
    $sql = "UPDATE utenti SET $dove = ? WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Errore nella preparazione della query: " . $conn->error);
        header("Location: ../php_front/profilo.php?error=db");
        exit;
    }

    // Associazione parametri e esecuzione
    $stmt->bind_param("si", $dato, $id_utente);
    if (!$stmt->execute()) {
        error_log("Errore durante l'aggiornamento: " . $stmt->error);
        header("Location: ../php_front/profilo.php?error=update");
        exit;
    }
    $stmt->close();
}

require_once "connection.php";
// Recupero dati dal form
$classe = $_POST["classe"];
$indirizzo = $_POST["schoolAddress"];
$descrizione = $_POST["bio"];

upload($conn, "bio", $descrizione, $id_utente);
upload($conn, "indirizzo", $indirizzo, $id_utente);
upload($conn, "classe", $classe, $id_utente);

// Gestione upload immagine
if (!empty($_FILES['immagine']['name'])) {
    $target_dir = "../imgprofilo/";
    $imageFileType = strtolower(pathinfo($_FILES['immagine']['name'], PATHINFO_EXTENSION));
    $newFileName = "img_" . $id_utente . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;

    // Verifica se il file è un'immagine
    $check = getimagesize($_FILES['immagine']['tmp_name']);
    if ($check === false) {
        header("Location: ../php_front/profilo.php?error=file");
        exit;
    }

    // Spostamento del file nella cartella imgprofilo
    if (!move_uploaded_file($_FILES['immagine']['tmp_name'], $target_file)) {
        header("Location: ../php_front/profilo.php?error=upload");
        exit;
    }

    // Aggiornamento del database con il nuovo nome del file
    $stmt = $conn->prepare("UPDATE utenti SET immagine = ? WHERE userID = ?");
    if (!$stmt) {
        error_log("Errore nella preparazione della query: " . $conn->error);
        header("Location: ../php_front/profilo.php?error=db");
        exit;
    }
    
    $stmt->bind_param("si", $newFileName, $id_utente);
    
    if (!$stmt->execute()) {
        error_log("Errore durante l'aggiornamento dell'immagine: " . $stmt->error);
        header("Location: ../php_front/profilo.php?error=update");
        exit;
    }

    $stmt->close();
    header("Location: ../php_front/profilo.php?success=1");
} else {
    // Nessun file caricato, reindirizza semplicemente al profilo
    header("Location: ../php_front/profilo.php");
}

$conn->close();
header("Location: ../php_front/profilo.php?success=1");
exit;
?>
