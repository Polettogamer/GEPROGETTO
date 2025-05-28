<?php
    session_start();
    $categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

    require_once "../php/connection.php";

   // Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
  header("Location: ../index.php"); // Redirect alla login se non autenticato
  exit;
}
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
  
  
</head>
<body>
  <?php require_once "../libs/navbar.html";?>
  
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
  
  <?php require_once "../libs/footer.html";?>

</body>
</html>
