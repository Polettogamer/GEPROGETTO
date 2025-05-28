<!DOCTYPE html>
<html lang="it">
    <head>
    <meta charset="UTF-8">
    <title>FAQ - SchoolQ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/menuCSS.css">
    <link rel="stylesheet" href="../CSS/faqCSS.css">
    <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php 
        require_once "../libs/navbar.html";
    ?>
    
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="faq-container">
        <h1>Domande Frequenti (FAQ)</h1>
        <div class="faq-item">
            <h2>Come posso registrarmi su SchoolQ?</h2>
            <p>Per registrarti, clicca sul pulsante "Registrati" nella pagina principale e compila il modulo con le tue informazioni personali. Una volta completata la registrazione, potrai accedere al tuo profilo e iniziare a utilizzare la piattaforma.</p>
        </div>
        <div class="faq-item">
            <h2>Come posso pubblicare una domanda?</h2>
            <p>Accedi al tuo profilo, seleziona la materia di interesse e clicca su "Pubblica Domanda". Inserisci il testo della tua domanda, scegli una categoria e invia. La tua domanda sarà visibile alla community.</p>
        </div>
        <div class="faq-item">
            <h2>Come posso rispondere a una domanda?</h2>
            <p>Vai alla domanda a cui vuoi rispondere, inserisci la tua risposta nel campo dedicato e clicca su "Invia". La tua risposta sarà visibile a tutti gli utenti.</p>
        </div>
        <div class="faq-item">
            <h2>Come posso modificare il mio profilo?</h2>
            <p>Accedi al tuo profilo e clicca su "Modifica Profilo". Qui potrai aggiornare le tue informazioni personali, cambiare la tua foto profilo e personalizzare il tuo account.</p>
        </div>
        <div class="faq-item">
            <h2>Chi posso contattare per supporto?</h2>
            <p>Se hai bisogno di aiuto, puoi contattare il nostro team di supporto tramite la pagina "Contattaci" o inviando un'email a support@schoolq.com.</p>
        </div>
        </div>
    </div>
    
    <?php 
        require_once "../libs/footer.html";
    ?>
    </body>
</html>