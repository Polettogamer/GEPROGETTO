<?php
// recover_password.php
session_start();
$showForm = true;
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Qui dovresti verificare se l'email esiste nel database
        // Esempio fittizio:
        // $userExists = checkUserEmail($email);

        $userExists = true; // Sostituisci con la tua logica

        if ($userExists) {
            // Genera un token sicuro
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Salva il token e la scadenza nel database associati all'utente
            // savePasswordResetToken($email, $token, $expires);

            // Invia email con link di reset (qui solo esempio)
            $resetLink = "http://localhost/GitHub/GEPROGETTO/PagWebSchoolQ/php_front/reset_password.php?token=$token";
            // mail($email, "Recupero password", "Clicca qui per reimpostare la password: $resetLink");

            $success = true;
            $showForm = false;
        } else {
            $error = "Indirizzo email non trovato.";
        }
    } else {
        $error = "Inserisci un indirizzo email valido.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Recupero Password</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
        .error { color: #c00; margin-bottom: 10px; }
        .success { color: #080; margin-bottom: 10px; }
        label, input { display: block; width: 100%; }
        input[type="email"] { margin-bottom: 15px; padding: 8px; }
        button { padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h2>Recupero Password</h2>
    <?php if ($success): ?>
        <div class="success">
            Se l'email inserita è corretta, riceverai un link per reimpostare la password.
        </div>
    <?php endif; ?>
    <?php if ($showForm): ?>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="email">Inserisci la tua email:</label>
            <input type="email" id="email" name="email" required autofocus>
            <button type="submit">Invia link di recupero</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html></div>