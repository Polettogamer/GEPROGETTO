<?php 
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
    header("Location: ../index.html"); // Redirect alla login se non autenticato
    exit;
}

// Configurazione della connessione al database
require_once "../php/connection.php";

// Query sicura con prepared statement
$id_utente = $_SESSION["userID"];
$stmt = $conn->prepare("SELECT * FROM utenti WHERE userID = ?");
$stmt->bind_param("i", $id_utente);
$stmt->execute();
$dati = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Profilo - SchoolQ</title>
  <link rel="stylesheet" href="../CSS/menuCSS.css">
  <link rel="stylesheet" href="../CSS/profiloCSS.css">
  <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once "../libs/navbar.html";?>


<div id="main-content" class="main-content">
  <div class="profile-container">
    <h2>Profilo utente</h2>
    <div class="profile-card">
      <form method="post" action="../php/editProfilo.php" enctype="multipart/form-data">

        <!-- Sezione immagine del profilo -->
        <div class="profile-image">
          <img src="<?= $dati["immagine"] ? "../imgprofilo/" . $dati["immagine"] : "../Immagini/default-profile.png" ?>" 
               alt="Immagine Profilo" id="profilePic">
          <label for="profileImageInput" class="custom-file-label">Cambia Immagine</label>
          <input type="file" name="immagine" id="profileImageInput" accept="image/*">
        </div>

        <!-- Sezione dati utente -->
        <div class="profile-details">
          <div class="form-group">
            <label for="username">Nome utente</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($dati["nome"] . " " . $dati["cognome"]) ?>" readonly>
          </div>
          
          <div class="form-group">
            <label for="class">Classe</label>
            <input type="text" id="class" name="classe" value="<?= htmlspecialchars($dati["classe"]) ?>" required>
          </div>
          
          <div class="form-group">
            <label for="schoolAddress">Indirizzo scolastico</label>
            <select id="schoolAddress" name="schoolAddress" required>
              <option value="nessuno" <?= $dati["indirizzo"] == "nessuno" ? "selected" : "" ?>>Nessuno</option>
              <option value="informatica" <?= $dati["indirizzo"] == "informatica" ? "selected" : "" ?>>Informatica</option>
              <option value="elettrotecnica" <?= $dati["indirizzo"] == "elettrotecnica" ? "selected" : "" ?>>Elettrotecnica</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($dati["email"]) ?>" readonly>
          </div>
          
          <div class="form-group">
            <label for="bio">Descrizione</label>
            <textarea id="bio" name="bio" rows="4" placeholder="Dicci qualcosa di te"><?= htmlspecialchars($dati["bio"]) ?></textarea>
          </div>
        </div>
        
        <div class="form-group">
          <button type="submit" class="button">Salva modifiche</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<?php require_once "../libs/footer.html";?>

<script>
  document.getElementById('profileImageInput').addEventListener('change', function(event) {
    var output = document.getElementById('profilePic');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src);
    }
  });
</script>

</body>
</html>
