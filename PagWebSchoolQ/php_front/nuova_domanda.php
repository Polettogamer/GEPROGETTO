<?php
session_start();
require_once "../php/connection.php";




// 3. Recupera le categorie per il menu a tendina
$sqlCategorie = "SELECT IDCategoria, nome FROM categorie ORDER BY nome";
$resultCategorie = $conn->query($sqlCategorie);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuova Domanda - SchoolQ</title>
    <link rel="stylesheet" href="../CSS/menuCSS.css">
    <link rel="stylesheet" href="../CSS/nuova_domandaCSS.css">
</head>
<body>
    <header class="top-navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="dashboard.php"><img src="../Immagini/mondo01.png" alt="SchoolQ Logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="profilo.php">Profilo</a></li>
                <li><a href="../php/log_out.php" class="button">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="main-content">
        <h2>Fai una nuova domanda</h2>
        
        <form method="POST" action="../php/insertQ.php">
            <label for="categoria">Seleziona la categoria:</label>
            <select name="categoria" id="categoria" required>
                <option value="">-- Seleziona una materia --</option>
                <?php
                if ($resultCategorie->num_rows > 0) {
                    while ($row = $resultCategorie->fetch_assoc()) {
                        echo '<option value="' . $row["IDCategoria"] . '">' . htmlspecialchars($row["nome"]) . '</option>';
                    }
                }
                ?>
            </select>

            <label for="domanda">Testo della domanda:</label>
            <textarea name="domanda" id="domanda" rows="4" required></textarea>

            <button type="submit">Invia domanda</button>
        </form>
    </div>

    <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h4>Informazioni</h4>
        <ul>
          <li><a href="../fileFooter/chisiamo.html">Chi Siamo</a></li>
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

<?php
$conn->close();
?>
