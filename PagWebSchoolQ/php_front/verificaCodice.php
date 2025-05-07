<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Codice</title>
    <link rel="stylesheet" href="styles.css"> <!-- Puoi aggiungere il tuo CSS -->
</head>
<body>

    <div class="container">
        <h2>Inserisci il codice di verifica</h2>

        <!-- Form per l'inserimento del codice -->
        <form action="sign_up_back.php" method="POST">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo isset($_SESSION['tmpemail']) ? htmlspecialchars($_SESSION['tmpemail']) : ''; ?>" readonly>
            </div>

            <div>
                <label for="codice_verifica">Codice di verifica</label>
                <input type="text" name="codice_verifica" id="codice_verifica" required maxlength="6" placeholder="Inserisci il codice di 6 cifre">
            </div>

            <div>
                <button type="submit">Verifica Codice</button>
            </div>
        </form>

        <!-- Messaggi di errore -->
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'codice_invalid') {
                echo "<p style='color:red;'>Il codice di verifica è errato. Riprova.</p>";
            }
        }
        ?>

    </div>

</body>
</html>
