<?php
    $categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

   
    $stmt = $conn->prepare("SELECT d.questionID, c.nome AS categoria, d.dataPubbl, d.QuestionText, d.nLike, u.nome, u.cognome, c.descrizione
                            FROM domande d
                            JOIN utenti u ON d.userID = u.userID
                            JOIN categorie c ON c.IDCategoria = d.categoriaID
                            WHERE categoriaID = ?
                            ORDER BY d.dataPubbl DESC");
    $stmt->bind_param("i", $categoria);
    $stmt->execute();
    $result = $stmt->get_result();

   
    
    if (!$result) {
        die("Errore nella query: " . $conn->error);
    }

   
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
        <li><a href="../index.html" class="button">Logout</a></li>
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
    <div class="questions">
      <h2><?php  
        // TITOLO CON DESCRIZIONE DELLA CATEGORIA
        $stmt = $conn->prepare("SELECT *
                                FROM  categorie 
                                WHERE IDcategoria = ?");
        $stmt->bind_param("i", $categoria);
        $stmt->execute();
        $titulo = $stmt->get_result();
        $arr = $titulo-> fetch_assoc();
        echo $arr['nome'] . " - " . $arr['descrizione'];
        ?></h2>
      
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo '<div class="question-item">';
              echo   '<div class="question-header">';
              echo     '<h3 class="question-title">' . htmlspecialchars($row["categoria"] ?? "Categoria non disponibile") . '</h3>';
              echo     '<div class="question-meta">Pubblicato alle ' . ($row["dataPubbl"] ?? "Data non disponibile") . ' - da <strong>' 
                       . htmlspecialchars(($row['nome'] ?? "Nome non disponibile") . ' ' . ($row['cognome'] ?? "Cognome non disponibile")) . '</strong></div>';
              echo   '</div>';

              echo   '<div class="question-body">';
              echo     '<p>' . nl2br(htmlspecialchars($row["QuestionText"] ?? "")) . '</p>';
              echo   '</div>';

              echo   '<div class="question-footer">';
              // Link alla pagina delle risposte
              echo     '<a href="risposta.php?id=' . $row["questionID"] . '" class="button">Vedi di più</a>';

              // Query per contare le risposte
              $questionID = intval($row["questionID"]);
              $countStmt = $conn->prepare("SELECT COUNT(*) as count FROM risposte WHERE QuestionID = ?");
              $countStmt->bind_param("i", $questionID);
              $countStmt->execute();
              $countResult = $countStmt->get_result();
            

              // Stampa delle statistiche
              echo     '<div class="question-stats">';
              if ($countResult && $countResult->num_rows > 0) {
                  $num = $countResult->fetch_assoc();
                  echo '<span>Risposte: ' . ($num["count"] ?? 0) . '</span>';
              } else {
                  echo '<span>Risposte: 0</span>';
              }
              echo '<span>Likes: ' . htmlspecialchars($row["nLike"] ?? "0") . '</span>';
              echo     '</div>';

              echo   '</div>'; // .question-footer
              echo '</div>';   // .question-item
          }
      } else {
          echo "<p>Nessuna domanda disponibile.</p>";
      }

      // Chiudi la connessione solo alla fine
      $conn->close();
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
