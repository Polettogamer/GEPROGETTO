<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Chi Siamo - SchoolQ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/menuCSS.css">
  <link rel="stylesheet" href="../CSS/chisiamo.css">
  <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php 
  require_once "../libs.navbar.html";
  ?>
  
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="chisiamo-container">
      <h1>Chi Siamo</h1>
      <p>SchoolQ è una piattaforma dedicata a studenti e docenti, concepita per rendere l'apprendimento collaborativo più interattivo e accessibile. Qui, ogni domanda trova risposta e ogni discussione stimola la curiosità e l'innovazione.</p>
      <p>Realizzata da un gruppo di studenti dell'ITT Città della Vittoria, la nostra missione è creare uno spazio in cui conoscenza, confronto e supporto reciproco si fondono per favorire la crescita personale e accademica. Attraverso un design moderno, intuitivo e responsive, SchoolQ mette a disposizione una serie di strumenti per condividere idee, risolvere dubbi e approfondire ogni materia.</p>
      <p>Unisciti alla nostra community e scopri come ogni domanda può aprire nuove opportunità di apprendimento!</p>
      <p><strong>Il Team di SchoolQ</strong></p>
    </div>
  </div>
  
  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h4>Informazioni</h4>
        <ul>
          <li><a href="chisiamo.html">Chi Siamo</a></li>
          <li><a href="../fileFooter/comefunziona.html">Come Funziona</a></li>
          <li><a href="faq.html">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Legale</h4>
        <ul>
          <li><a href="privacy.html">Privacy Policy</a></li>
          <li><a href="termini.html">Termini e Condizioni</a></li>
          <li><a href="regolamento.html">Regolamento</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Contatti</h4>
        <ul>
          <li><a href="contact.html">Contattaci</a></li>
          <li><a href="supporto.html">Supporto</a></li>
        </ul>
      </div>
      <div class="footer-section social">
        <h4>Seguici</h4>
        <ul>
          <li><a href="https://facebook.com/tuoforum" target="_blank">Facebook</a></li>
          <li><a href="https://twitter.com/tuoforum" target="_blank">Twitter</a></li>
          <li><a href="https://instagram.com/tuoforum" target="_blank">Instagram</a></li>
        </ul>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 SchoolQ. Tutti i diritti riservati.</p>
      </div>
    </div>
  </footer>
</body>
</html>
