<?php
session_start(); // Avvia la sessione per mantenere l'utente connesso

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schoolq";

// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ricezione dati dal form
$email = trim($_POST['email']);
$password = $_POST['password'];

// Query per ottenere la password hashata dell'utente
$sql = "SELECT userID, nome, cognome, password FROM utenti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Controllo se l'utente esiste
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $nome, $cognome, $hashed_password);
    $stmt->fetch();

    // Verifica della password
    if (password_verify($password, $hashed_password)) {
        // Login riuscito: Salva i dati dell'utente nella sessione
        $_SESSION['userID'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['cognome'] = $cognome;
        $_SESSION['email'] = $email;

        header("Location: ../php_front/dashboard.php?"); // Reindirizza alla pagina principale
        exit();
    } else {
        // Password errata
        header("Location: ../php_front/log_in.php?error=wrong_password");
        exit();
    }
} else {
    // Email non trovata
    header("Location: ../php_front/log_in.php?error=email_not_found");
    exit();
}

// Chiudi connessioni
$stmt->close();
$conn->close();
?>
