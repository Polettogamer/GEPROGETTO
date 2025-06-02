<?php
// Configurazione della connessione al database
$servername = "srv1342.hstgr.io"; // Cambia se necessario
$username = "u482179263_schoolq"; // Il tuo username del database
$password = "&L]ygs!N94f"; // La tua password del database
$dbname = "u482179263_schoolq"; // Nome del database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>