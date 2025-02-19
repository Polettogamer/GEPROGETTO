<?php
    $iddomanda = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schoolq";
    
    // Creazione connessione
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");

    // Prepared statement per le risposte
    $stmt = $conn->prepare("SELECT r.*, u.nome, u.cognome FROM risposte r
                        JOIN utenti u ON r.userID = u.userID
                        WHERE r.questionID = ?");
    $stmt->bind_param("i", $iddomanda);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepared statement per la domanda
    $stmt_domanda = $conn->prepare("SELECT d.*, u.nome, u.cognome, c.nome AS nomecat FROM domande d 
                                    JOIN utenti u ON d.userID = u.userID
                                    JOIN categorie c ON c.IDCategoria = d.categoriaID
                                    WHERE QuestionID = ?");
    $stmt_domanda->bind_param("i", $iddomanda);
    $stmt_domanda->execute();
    $domanda = $stmt_domanda->get_result();

    if (!$result) {
        die("Errore nella query: " . $conn->error);
    }

    $conn->close();
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
        <img src="../Immagini/mondo01.png" alt="SchoolQ Logo">
      </div>
      <ul class="nav-links">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="profilo.php">Profilo</a></li>
        <li><a class="button">Logout</a></li>
      </ul>
    </div>
  </header>
  
  <!-- SIDEBAR: MENU A TENDINA CON LE MATERIE -->
  <div id="sidebar" class="sidebar">
    <h3>Materie</h3>
    <ul>
      <li><a href="categoria.php?id=1">Italiano</a></li>
      <li><a href="categoria.php?id=2">Storia</a></li>
      <li><a href="categoria.php?id=3">Geografia</a></li>
      <li><a href="categoria.php?id=4">Diritto ed economia</a></li>
      <li><a href="categoria.php?id=5">Matematica</a></li>
      <li><a href="categoria.php?id=6">Fisica</a></li>
      <li><a href="categoria.php?id=7">Chimica</a></li>
      <li><a href="categoria.php?id=8">Scienze della terra</a></li>
      <li><a href="categoria.php?id=9">Tecnologie Informatiche</a></li>
      <li><a href="categoria.php?id=10">TRG</a></li>
      <li><a href="categoria.php?id=11">Educazione fisica</a></li>
      <li><a href="categoria.php?id=12">Scienze e tecnologie applicate</a></li>
      <li><a><b>Indirizzo Informatica:</b></a></li>
      <li><a href="categoria.php?id=13"> Informatica</a></li>
      <li><a href="categoria.php?id=14"> Sistemi e reti</a></li>
      <li><a href="categoria.php?id=15"> TPSIT</a></li>
      <li><a href="categoria.php?id=16"> Telecomunicazioni</a></li>
      <li><a href="categoria.php?id=17"> GEPRO</a></li>
      <li><a><b>Indirizzo Elettrotecnica:</b></a></li>
      <li><a href="categoria.php?id=18"> Elettrotecnica</a></li>
      <li><a href="categoria.php?id=19"> Sistemi</a></li>
      <li><a href="categoria.php?id=20"> TPSEE</a></li>
      <li><a> ... </a></li>
    </ul>
  </div>
  
  <div id="main-content" class="main-content">
    <div id="domanda" class="domanda">
      <?php
      if ($domanda->num_rows > 0) {
          $row = $domanda->fetch_assoc();
          echo '<div class="question-item">';
          echo   '<div class="question-header">';
          echo     '<h3 class="question-title">' . htmlspecialchars($row["nomecat"]) . '</h3>';
          echo     '<div class="question-meta">Pubblicato alle ' . $row["dataPubbl"] . ' - da <strong>' . $row['nome'] . ' ' . $row['cognome'] . '</strong></div>';
          echo   '</div>';
          echo   '<div class="question-body">';
          echo     '<p>' . nl2br(htmlspecialchars($row["QuestionText"])) . '</p>';
          echo   '</div>';
          echo   '<div class="question-footer">';
          echo     '<div class="question-stats">';
          echo       '<span>Risposte: 4</span>';
          echo       '<span>Likes: ' . htmlspecialchars($row["nLike"]) . '</span>';
          echo     '</div>';
          echo   '</div>';
          echo '</div>';
      } else {
          echo "<p>Nessuna domanda disponibile.</p>";
      }
      ?>
    </div>
    <div class="risposte">
      <?php
      if ($result->num_rows > 0) {
          echo '<div class="question-item">';
          while($row = $result->fetch_assoc()){
              echo '<div class="question-header">';
              echo   '<div class="question-meta">Pubblicato alle ' . $row["dataPubbl"] . ' - da <strong>' . $row['nome'] . ' ' . $row['cognome'] . '</strong></div>';
              echo '</div>';
              echo '<div class="question-body">';
              echo   '<p>' . nl2br(htmlspecialchars($row["testoRisposta"])) . '</p>';
              echo '</div>';
              echo '<div class="question-footer">';
              echo   '<div class="question-stats">';
              echo     '<span>Likes: ' . htmlspecialchars($row["nLike"]) . '</span>';
              echo   '</div>';
              echo '</div>';
              echo '<hr>';
          }
          echo '</div>';
      } else {
          echo "<p>Nessuna risposta disponibile.</p>";
      }
      ?>
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
      <div class="footer-section">
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
