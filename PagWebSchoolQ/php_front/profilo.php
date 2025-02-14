<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Profilo - SchoolQ</title>
  <!-- Include il CSS del menu e quello specifico per il profilo -->
  <link rel="stylesheet" href="../CSS/menuCSS.css">
  <link rel="stylesheet" href="../CSS/profiloCSS.css">
  <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- TOP NAVBAR -->
  <header class="top-navbar">
    <div class="nav-container">
      <div class="logo">
        <img src="../Immagini/mondo01.png" alt="SchoolQ Logo">
      </div>
      <ul class="nav-links">
        <li><a href="menu.html">Home</a></li>
        <li><a href="profilo.html" class="active">Profilo</a></li>
        <li><a href="logout.html" class="button">Logout</a></li>
      </ul>
    </div>
  </header>
  
  <!-- MAIN CONTENT: Gestione Profilo -->
  <div id="main-content" class="main-content">
    <div class="profile-container">
      <h2>Profilo utente</h2>
      <div class="profile-card">
        <!-- Sezione immagine del profilo -->
        <div class="profile-image">
          <img src="../Immagini/profilo5.png" alt="Immagine Profilo" id="profilePic">
          <!-- La label agisce come bottone per selezionare un nuovo file -->
          <label for="profileImageInput" class="custom-file-label">Cambia Immagine</label>
          <input type="file" id="profileImageInput" accept="image/*">
        </div>
        <!-- Sezione dati utente -->
        <div class="profile-details">
          <form id="profileForm" action="update_profile.php" method="post" enctype="multipart/form-data">
            <!-- Campo: Nome Utente (sola lettura) -->
            <div class="form-group">
              <label for="username">Nome utente</label>
              <input type="text" id="username" name="username" value="Mario Rossi" readonly>
            </div>
            <!-- Campo: Classe -->
            <div class="form-group">
              <label for="class">Classe</label>
              <input type="text" id="class" name="class" placeholder="Es. 1A, 2B..." required>
            </div>
            <!-- Campo: Indirizzo Scolastico come scelta multipla -->
            <div class="form-group">
              <label for="schoolAddress">Indirizzo scolastico</label>
              <select id="schoolAddress" name="schoolAddress" required>
                <option value="Nessuno">Nessuno</option>
                <option value="Informatica">Informatica</option>
                <option value="Elettrotecnica">Elettrotecnica</option>
              </select>
            </div>
            <!-- Campo: Email (sola lettura) -->
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="mario.rossi@iisvittorioveneto.it" readonly>
            </div>
            <!-- Campo: Descrizione (bio) -->
            <div class="form-group">
              <label for="bio">Descrizione</label>
              <textarea id="bio" name="bio" rows="4" placeholder="Scrivi qualcosa di te..."></textarea>
            </div>
            <!-- Bottone per salvare le modifiche -->
            <div class="form-group">
              <button type="submit" class="button" disabled>Salva modifiche</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- FOOTER (stesso stile della home) -->
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
  
  <!-- Script per l'anteprima dell'immagine selezionata -->
  <script>
    document.getElementById('profileImageInput').addEventListener('change', function(event) {
      var output = document.getElementById('profilePic');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src); // libera memoria
      }
    });
  </script>
</body>
</html>
