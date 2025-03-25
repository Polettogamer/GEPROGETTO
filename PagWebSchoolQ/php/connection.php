<?php
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
?>