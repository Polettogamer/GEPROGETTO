<?php
require_once "connection.php";


session_start();

try {
    // Ricezione dei dati dal form
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validazione dell'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../php_front/sign_up.php?error=email_invalid");
        exit();
    }

    // Controllo se l'email esiste già
    $check_email = $conn->prepare("SELECT email FROM utenti WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        header("Location: ../php_front/sign_up.php?error=email_exists");
        $check_email->close();
        $conn->close();
        exit();
    }
    $check_email->close();

    // Hash della password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Memorizza l'email e la password hashata nella sessione
    $_SESSION['tmpemail'] = $email;
    $_SESSION['tmppw'] = $hashed_password;

    // Generazione di un codice di verifica random
    $codice_verifica = strval(random_int(100000, 999999));
    $_SESSION['codice_verifica'] = $codice_verifica;

    // Componi l'email
    $to = $email;
    $subject = "Codice di verifica per la registrazione";
    $message = "Ciao,\n\nIl tuo codice di verifica è: $codice_verifica\n\nInseriscilo nel form per completare la registrazione.";
    $headers = "From: schoolq.autenticate@gmail.com\r\n";

    // Invia l'email
    if (mail($to, $subject, $message, $headers)) {
        header("Location: ../php_front/verifica_codice.php");
        exit();
    } else {
        header("Location: ../php_front/sign_up.php?error=email_send_failed");
        exit();
    }
} catch (Exception $e) {
    error_log("Errore: " . $e->getMessage());
    header("Location: ../php_front/sign_up.php?error=unexpected_error");
    exit();
}
?>
