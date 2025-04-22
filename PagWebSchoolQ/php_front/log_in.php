<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accedi</title>
        <link rel="stylesheet" href="../CSS/accediCSS.css">
        <link rel="icon" type="image/x-icon" href="Immagini/faviconf.png">
    </head>
    <body>
        <main class="main">
            <div class="login-wrapper">
                <div class="login-logo-left">
                    <header class="header-container">
                    </header>
                        <div class="center-text">
                            <h1 class="h1">Bentornato</h1>
                            <h2 class="h2">Chatta con altri studenti</h2>
<<<<<<< Updated upstream
                        </div>  
                        <!--eagergarg
                        <div class="semi-footer">
                            <hr>
                            <a href="#">www.SchoolQ.com</a>
                        </div>
                    -->
                    </div> 
=======
                        </div>
                    </div>
>>>>>>> Stashed changes
        
                    <div class="login-container-right">
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] === 'wrong_password') {
                                echo "<p style='font-weight: bold; text-align: center;'>⚠️ Password Errata!</p>";
                            } elseif ($_GET['error'] === 'email_not_found') {
                                echo "<p style='font-weight: bold; text-align: center;'>Email non trovata.</p>";
                            }
                        }
                    ?>
                    <h3 class="h3">Accedi</h3>
                        <form action="../php/log_in_back.php" method="post" class="input-container">
                            <label for="email">Email</label>
                            <input class="input-text" type="email" id="email" name="email" placeholder="Email Address" required 
                                autocomplete="email" pattern=".+@iisvittorioveneto\.it" title="Deve essere un'email @iisvittorioveneto.it">

                            <label for="password">Password</label>
                            <input class="input-pass" type="password" id="password" name="password" placeholder="Password" required 
                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                title="Deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola e un numero">
                                <button type="submit" id="link-continue" class="icon-flecha">ACCEDI</button>
                        </form>
                        <p>Sei senza account?  <a href="sign_up.php" >Registrati </a></p>
                    </div>
                </div>
        </main>
    </body>
</html>
