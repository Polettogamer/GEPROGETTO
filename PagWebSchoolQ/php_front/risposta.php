<?php
  session_start();
    $iddomanda = isset($_GET['id']) ? intval($_GET['id']) : 0;
  
    require_once "../php/connection.php";
    // Verifica se l'utente è loggato
    if (!isset($_SESSION["userID"])) {
      header("Location: ../index.php"); // Redirect alla login se non autenticato
      exit;
    }

    // Prepared statement per le risposte
    $stmt = $conn->prepare("SELECT r.*, u.nome, u.cognome FROM risposte r
                        JOIN utenti u ON r.userID = u.userID
                        WHERE r.questionID = ?");
    $stmt->bind_param("i", $iddomanda);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepared statement per la domanda
    $stmt_domanda = $conn->prepare("SELECT d.*, u.userID, u.nome, u.cognome, c.nome AS nomecat FROM domande d 
                                    JOIN utenti u ON d.userID = u.userID
                                    JOIN categorie c ON c.IDCategoria = d.categoriaID
                                    WHERE QuestionID = ?");
    $stmt_domanda->bind_param("i", $iddomanda);
    $stmt_domanda->execute();
    $domanda = $stmt_domanda->get_result();

    if (!$result) {
        die("Errore nella query: " . $conn->error);
    }
    if ($domanda->num_rows > 0) {
      $question = $domanda->fetch_assoc();
    }
    if($question["userID"] == $_SESSION["userID"] || $_SESSION["privilegio"] == 'MODER' || $_SESSION["privilegio"] == 'ADMIN'){
      $impdelete = "";
    }else{
      $impdelete = 'style="display:none"';
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
    


    function toggleNewAnswer() {
      var formdiv = document.getElementById("form");

      if (formdiv) {  // Controlla se l'elemento esiste
        if (formdiv.classList.contains("hidden")) {
          formdiv.classList.remove("hidden");  // Mostra il form
          formdiv.style.display = "block";      // Assicurati che venga visualizzato
        } else {
          formdiv.classList.add("hidden");     // Nascondi il form
          formdiv.style.display = "none";      // Rimuove il form dal layout
        }
      } else {
        console.error("Elemento con ID 'form' non trovato.");
      }
    }
  </script>
</head>
<body>
<?php require_once "../libs/navbar.html";?>
  
  
  <div id="main-content" class="main-content">
    <div id="domanda" class="domanda">
      <div class="question-item">
        <div class="question-header">
          <h3 class="question-title"><?= htmlspecialchars($question["nomecat"]) ?></h3>
          <div class="question-meta">Pubblicato alle<?=$question["dataPubbl"] ?>
            <strong><?= $question['nome']?> <?=$question['cognome']?></strong>
          </div>
        </div>
        <div class="question-body">
        <p><?=nl2br(htmlspecialchars($question["QuestionText"]))?></p>
        </div>
        <div class="question-footer">
        <button onclick="toggleNewAnswer()" class="response-button">Nuova Risposta </button>
          <div class="question-stats">
            <span>Risposte: 2</span>
            <span>Likes:<?=htmlspecialchars($question["nLike"])?></span>
            <div class="delete">
              <a href="../php/deleteQ.php?id=<?=$iddomanda?> " <?php echo $impdelete;?> >ELIMINA DOMANDA</a>
            </div>
          </div>
        </div>
        <div id="form" style="display:none" class="hidden">
            <h2>Rispondi alla domanda</h2>
            <!-- Form per inviare la risposta -->
            <form action="../php/insertA.php" method="post">
              <div class="form-group">
                <label for="risposta">Inserisci la tua risposta:</label>
                <textarea id="risposta" name="risposta" rows="8" required></textarea>
                <input type="hidden" id="QuestionID" name="QuestionID" value="<?=$iddomanda?>" readonly>
              </div>
              <button type="submit" class="response-button">Invia Risposta</button>
            </form>
            <br>
          </div>
      </div>
      <hr class="separator">
      <h3 class="response-title">Risposte:</h3>
    </div>
    <div class="risposte">
      <?php
      if ($result && $result->num_rows > 0) {
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
  
  <?php require_once "../libs/footer.html";?>

</body>
</html>
    
