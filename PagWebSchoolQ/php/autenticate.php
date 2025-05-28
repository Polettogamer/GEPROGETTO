<?php
require_once "connection.php";
require '../vendor/autoload.php'; // Includi PHPMailer (se usi Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    // Configura PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurazione del server SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Server SMTP (esempio: Gmail)
        $mail->SMTPAuth = true;
        $mail->Username = 'schoolq.autenticate.com'; // Inserisci la tua email
        $mail->Password = 'cfzr fkyl inzy wwgq'; // Inserisci la tua password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Crittografia TLS
        $mail->Port = 587; // Porta SMTP

        // Mostra i dettagli del processo di invio
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html'; // Formatta il debug in HTML

        // Configura il mittente e il destinatario
        $mail->setFrom('your_email@gmail.com', 'SchoolQ'); // Mittente
        $mail->addAddress($email); // Destinatario

        // Contenuto dell'email
        $mail->isHTML(true);
        $mail->Subject = "Codice di verifica per la registrazione";
        $mail->Body = "Ciao,<br><br>Il tuo codice di verifica è: <b>$codice_verifica</b><br><br>Inseriscilo nel form per completare la registrazione.";

        // Timeout di 30 secondi
        $mail->Timeout = 30;

        // Invia l'email
        $mail->send();
        header("Location: ../php_front/verifica_codice.php");
        exit();
    } catch (Exception $e) {
        error_log("Errore nell'invio dell'email: " . $mail->ErrorInfo);
        header("Location: ../php_front/sign_up.php?error=email_send_failed&message=" . urlencode($mail->ErrorInfo));
        exit();
    }
} catch (Exception $e) {
    error_log("Errore: " . $e->getMessage());
    header("Location: ../php_front/sign_up.php?error=unexpected_error");
    exit();
}
?>
