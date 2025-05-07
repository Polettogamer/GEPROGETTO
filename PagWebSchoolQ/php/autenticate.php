<?php
require_once "connection.php";
session_start();

// Ricezione dei dati dal form
$email = trim($_POST['email']);
$password = $_POST['password'];

$check_email = $conn->prepare("SELECT email FROM utenti WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_email->num_rows > 0) {

    header("Location: ../php_front/sign_up.php?error=email_exists");
    $conn->close();
    $check_email->close();
    exit();
}

// Validazione dell'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../php_front/sign_up.php?error=email_invalid");
    exit();
}

// Hash della password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Memorizza l'email e la password hashata nella sessione
$_SESSION['tmpemail'] = $email;
$_SESSION['tmppw'] = $hashed_password;

// Generazione di un codice di verifica random
$codice_verifica = strval(random_int(100000, 999999));

// Salvataggio del codice di verifica nella sessione
$_SESSION['codice_verifica'] = $codice_verifica;

// Componi l'email
$subject = "Codice di verifica per la registrazione";
$message = "Ciao,\n\nIl tuo codice di verifica è: $codice_verifica\n\nInseriscilo nel form per completare la registrazione.";
$headers = "From: schoolQ.autenticate@gmail.com";

// Invia l'email
if (mail($email, $subject, $message, $headers)) {
    // Se l'email è inviata correttamente, reindirizza l'utente alla pagina di verifica
    header("Location: ../php_front/verifica_codice.php?email=" . urlencode($email));
    exit();
} else {
    // Se c'è stato un errore nell'invio della mail
    header("Location: ../php_front/sign_up.php?error=email_send_failed");
    exit();
}
?>
