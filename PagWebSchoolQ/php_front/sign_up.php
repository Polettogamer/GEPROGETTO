
<?php
$message = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == "email_invalid") {
        $message = "<p class='error-message'>⚠️ L'email deve terminare con @iisvittorioveneto.it!</p>";
    } elseif ($_GET['error'] == "email_exists") {
        $message = "<p class='error-message'>⚠️ Questa email è già registrata!</p>";
    } elseif ($_GET['error'] == "db_error") {
        $message = "<p class='error-message'>⚠️ Errore nel database. Riprova più tardi!</p>";
    }
} elseif (isset($_GET['success']) && $_GET['success'] == "registered") {
    $message = "<p class='success-message'>✅ Registrazione avvenuta con successo! Ora puoi accedere.</p>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrati</title>
        <link rel="stylesheet" href="../CSS/sign_upCSS.css">
        <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
    </head>
    <body>
        <main class="main">
            <div class="login-wrapper">
                <div class="login-logo-left">
                    <header class="header-container">
                </header>
                        <div class="center-text">
                            <h1 class="h1">Benvenuto</h1>
                            <h2 class="h2">Registrati per aver accesso a SchoolQ<br>e confrontarti con altri studenti.</h2>
                        </div>
                        <!--
                        <div class="semi-footer">
                            <hr>
                            <a href="#">www.SchoolQ.com</a>
                        </div>
                        -->
                    </div>
        
                    <div class="login-container-right">
        
                        <h3 class="h3">Registrati</h3>

                        <?php if (!empty($message)): ?>
                            <div class="message-container">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="../php/autenticate.php" method="post" class="input-container">
                            
                            <label for="email">Email</label>
                            <input class="input-text" type="email" id="email" name="email" placeholder="Email Address" required 
                            autocomplete="email" pattern=".+@iisvittorioveneto\.it" title="Deve essere un'email @iisvittorioveneto.it">

                            <label for="password">Password</label>
                            <input class="input-pass" type="password" id="password" name="password" placeholder="Password" required 
                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                title="Deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola e un numero" 
                                autocomplete="new-password">
                            
                            <button type="submit" id="link-continue" class="icon-flecha">REGISTRATI</button>
                        </form>
                        <p>Hai già una mail?  <a href="log_in.php" >Accedi </a></p>
                        
                    </div>
        
        
                </div>
        </main>
    </body>
</html>
