<!DOCTYPE html>
<html lang="it">
    <head>
    <meta charset="UTF-8">
    <title>Supporto - SchoolQ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/menuCSS.css">
    <link rel="stylesheet" href="../CSS/supportoCSS.css">
    <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php 
        require_once "../libs/navbar.html";
    ?>
    
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="supporto-container">
        <h1>Supporto</h1>
        <p>Hai bisogno di assistenza? Consulta le nostre FAQ o contattaci per ricevere supporto personalizzato.</p>
        <h2>FAQ</h2>
        <p>Prima di contattarci, dai un'occhiata alla nostra <a href="faq.php">pagina delle FAQ</a>. Potresti trovare la risposta che cerchi!</p>
        <h2>Contattaci</h2>
        <p>Se hai bisogno di ulteriore aiuto, visita la nostra <a href="contattaci.php">pagina di contatto</a> e inviaci un messaggio.</p>
        <h2>Supporto Tecnico</h2>
        <p>Per problemi tecnici, puoi inviare un'email a <strong>support@schoolq.com</strong>.</p>
        </div>
    </div>
    
    <?php 
        require_once "../libs/footer.html";
    ?>
    </body>
</html>