<?php
    $categoria = 'italiano';
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Home - SchoolQ</title>
  <link rel="stylesheet" href="../CSS/menuCSS.css">
  <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  
  <script>
    // Funzione per mostrare/nascondere il sidebar (menu a tendina)
    function toggleSidebar() {
      var sidebar = document.getElementById("sidebar");
      var mainContent = document.getElementById("main-content");
      if (sidebar.classList.contains("active")) {
        sidebar.classList.remove("active");
        mainContent.classList.remove("shifted");
      } else {
        sidebar.classList.add("active");
        mainContent.classList.add("shifted");
      }
    }
  </script>
</head>
<body>
  <!-- TOP NAVBAR -->
  <header class="top-navbar">
    <div class="nav-container">
      <div class="logo">
        <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>
        <img src="Immagini/mondo01.png" alt="SchoolQ Logo">
      </div>
      <ul class="nav-links">
        <li><a href="user_dashboard.html">Home</a></li>
        <li><a href="../profilo.html">Profilo</a></li>
        <li><a href="logout.html" class="button">Logout</a></li>
      </ul>
    </div>
  </header>
  
  <!-- SIDEBAR: MENU A TENDINA CON LE MATERIE -->
  <div id="sidebar" class="sidebar">
    <h3>Materie</h3>
    <ul>
      <li><a href="Classe1.html">Italiano</a></li>
      <li><a href="Classe2.html">Storia</a></li>
      <li><a href="Classe5.html">Geografia</a></li>
      <li><a href="Classe3.html">Diritto ed economia</a></li>
      <li><a href="Classe4.html">Matematica</a></li>
      <li><a href="Classe5.html">Fisica</a></li>
      <li><a href="Classe5.html">Chimica</a></li>
      <li><a href="Classe5.html">Scienze della terra</a></li>
      <li><a href="Classe5.html">Informatica</a></li>
      <li><a href="Classe5.html">TRG</a></li>
      <li><a href="Classe5.html">Educazione fisica</a></li>
      <li><a><b>Indirizzo Informatica:</b></a></li>
      <li><a href="Classe5.html"> Informatica</a></li>
      <li><a href="Classe5.html"> Sistemi e reti</a></li>
      <li><a href="Classe5.html"> TPSIT</a></li>
      <li><a><b>Indirizzo Elettrotecnica:</b></a></li>
      <li><a href="Classe5.html"> Elettrotecnica</a></li>
      <li><a href="Classe5.html"> Sistemi</a></li>
      <li><a href="Classe5.html"> TPSE</a></li>
      <li><a> ciao</a></li>
    </ul>
  </div>

  <!-- MAIN CONTENT: DOMANDE PUBBLICATE RECENTEMENTE -->
  <div id="main-content" class="main-content">
    <div class="questions">
      <h2>Domande Pubblicate Recentemente</h2>
      
      
      <div class="question-item">
        <div class="question-header">
          <h3 class="question-title"><?php echo $categoria ?></h3>
          <div class="question-meta">Pubblicato alle 18:30 - da <strong>FrancescoVerdi</strong></div>
        </div>
        <div class="question-body">
          Domanda: Quali sono le principali caratteristiche geografiche dellAfrica e quali sono le sfide ambientali che affronta?
        </div>
        <div class="question-footer">
          <a href="conversation8.html" class="button">Vedi di più</a>
          <div class="question-stats">
            <span>Risposte: 4</span>
            <span>Likes: 7</span>
          </div>
        </div>
      </div>
      
    </div>
  </div>
      <footer class="footer">
      <div class="footer-container">
        <div class="footer-section">
          <h4>Informazioni</h4>
          <ul>
            <li><a href="chi-siamo.html">Chi Siamo</a></li>
            <li><a href="guida.html">Come Funziona</a></li>
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
