<?php
require_once "connection.php";
session_start();

$email = trim($_POST['tmpemail']);



// Ricevi i dati dal form
$email = trim($_POST['email']);
$codice_inserito = trim($_POST['codice_verifica']);

// Recupera il codice di verifica dalla sessione
$codice_verifica = isset($_SESSION['codice_verifica']) ? $_SESSION['codice_verifica'] : null;

// Verifica se il codice inserito è corretto
if ($codice_inserito === $codice_verifica) {
    // Codice corretto, prosegui con la registrazione dell'utente
    // Qui dovresti fare la logica per completare la registrazione, come l'inserimento nel database
    // Controllo se l'email esiste già nel database
    $email = $_SESSION['tmpemail'];
    $hashed_password = $_SESSION['tmppw'] ;
    // Estrazione parte locale e dominio
    list($localPart, $domain) = explode('@', $email);
    
    // Inizializzo nome e cognome
    $nome     = '';
    $cognome  = '';
    
    // Se il dominio è quello atteso e nella parte locale c’è un punto
    if ($domain === 'iisvittorioveneto.it' && strpos($localPart, '.') !== false) {
        // Divido la parte locale in due (nome e cognome)
        list($first, $last) = explode('.', $localPart);
        // Normalizzo tutto in minuscolo e poi metto in maiuscolo la prima lettera
        $nome     = ucfirst(strtolower($first));
        $cognome  = ucfirst(strtolower($last));
    } else {
        // Qui puoi gestire il caso di formato non valido (es. mostrare errore)
        header("Location: ../php_front/sign_up.php?error=invalid_email_format");
        exit();
    }

    $check_email->close();
    try {
        

        // Prepariamo l'SQL per l'inserimento
        $sql = "INSERT INTO utenti (nome, cognome, email, password, privilegio) VALUES (?, ?, ?, ?, 'USER')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $cognome, $email, $hashed_password);

        $stmt->execute();

        // Se l'operazione è andata a buon fine, reindirizza al login
        header("Location: ../php_front/log_in.php?success=registered");
        $stmt->close();
        $conn->close();
        exit();


    } catch (mysqli_sql_exception $e) {
        if ($conn->errno == 1062) { // 1062 = ER_DUP_ENTRY (email duplicata)
            header("Location: ../php_front/sign_up.php?error=email_exists");
        } else {
            header("Location: ../php_front/sign_up.php?error=db_error");
        }
        exit();
    }

// Chiudi connessioni
} else {
    // Codice errato, reindirizza con un errore
    header("Location: ../php_front/verifica_codice.php?error=codice_invalid&email=" . urlencode($email));
    exit();
}



// Controllo se l'email esiste già nel database
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


$check_email->close();
try {
    // Hash della password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepariamo l'SQL per l'inserimento
    $sql = "INSERT INTO utenti (nome, cognome, email, password, privilegio) VALUES (?, ?, ?, ?, 'USER')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cognome, $email, $hashed_password);
    
    $stmt->execute();

    // Se l'operazione è andata a buon fine, reindirizza al login
    header("Location: ../php_front/log_in.php?success=registered");
    $stmt->close();
    $conn->close();
    exit();
    

} catch (mysqli_sql_exception $e) {
    if ($conn->errno == 1062) { // 1062 = ER_DUP_ENTRY (email duplicata)
        header("Location: ../php_front/sign_up.php?error=email_exists");
    } else {
        header("Location: ../php_front/sign_up.php?error=db_error");
    }
    exit();
}

// Chiudi connessioni




?>