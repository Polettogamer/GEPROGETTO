<?php
session_start();
require_once "../php/connection.php";

// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
  header("Location: ../index.php"); // Redirect alla login se non autenticato
  exit;
}
// 2. Query per ottenere le domande
$sql = "SELECT d.questionID, c.nome AS categoria, d.dataPubbl, d.QuestionText, d.nLike, u.nome, u.cognome, u.userID
        FROM domande d
        JOIN utenti u ON d.userID = u.userID
        JOIN categorie c ON c.IDCategoria = d.categoriaID
        ORDER BY d.dataPubbl DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Errore nella query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="it">
  <?php require_once "../libs/head.html";?>
<body>
  <?php require_once "../libs/navbar.html";?>

  <!-- MAIN CONTENT: DOMANDE PUBBLICATE RECENTEMENTE -->
  <div id="main-content" class="main-content">
    <div class="questions">
      <h2>Domande Pubblicate Recentemente</h2>
      <div class="new-question-container">
        <a href="nuova_domanda.php" class="button new-question-btn">&#43; Nuova Domanda</a>
      </div>

      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo '<div class="question-item">';
              echo   '<div class="question-header">';
              echo     '<h3 class="question-title">' . htmlspecialchars($row["categoria"] ?? "Categoria non disponibile") . '</h3>';
              /*echo     '<div class="question-meta">Pubblicato alle ' . ($row["dataPubbl"] ?? "Data non disponibile") . ' - da <strong>' 
                       . htmlspecialchars(($row['nome'] ?? "Nome non disponibile") . ' ' . ($row['cognome'] ?? "Cognome non disponibile")) . '</strong></div>';
              */
              $nome = htmlspecialchars($row['nome'] ?? "Nome");
              $cognome = htmlspecialchars($row['cognome'] ?? "Cognome");
              $userID = intval($row['userID'] ?? 0);
              echo '<div class="question-meta">Pubblicato alle ' . ($row["dataPubbl"] ?? "Data non disponibile") . ' - da <a href="profilo.php?id=' . $userID . '"><strong>'
              . $nome . ' ' . $cognome . '</strong></a></div>';




              echo   '</div>';

              echo   '<div class="question-body">';
              echo     '<p>' . nl2br(htmlspecialchars($row["QuestionText"] ?? "")) . '</p>';
              echo   '</div>';

              echo   '<div class="question-footer">';
              // Link alla pagina delle risposte
              echo     '<a href="risposta.php?id=' . $row["questionID"] . '" class="button">Vedi di più</a>';

              // Query per contare le risposte
              $questionID = intval($row["questionID"]);
              $countQuery = "SELECT COUNT(*) as count FROM risposte WHERE QuestionID = $questionID";
              $countResult = $conn->query($countQuery);

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
  
  <?php require_once "../libs/footer.html";?>
  
</body>
</html>
