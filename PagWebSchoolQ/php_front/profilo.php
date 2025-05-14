<?php
session_start();

// 1) Verifica se l’utente è loggato
if (!isset($_SESSION["userID"])) {
    header("Location: ../index.php");
    exit;
}

// 2) Lettura e sanitizzazione di GET[id]
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id_visto = intval($_GET['id']);
} else {
    // se non c’è id o non è valido, mostro il mio profilo
    $id_visto = $_SESSION["userID"];
}

// 3) Connessione al database
require_once "../php/connection.php";

// 4) Recupero dati utente (proprio o altrui) con prepared statement
$stmt = $conn->prepare("SELECT userID, nome, cognome, classe, indirizzo, email, bio, immagine 
                        FROM utenti 
                        WHERE userID = ?");
$stmt->bind_param("i", $id_visto);
$stmt->execute();
$dati = $stmt->get_result()->fetch_assoc();
$stmt->close();


// 5) Flag per decidere se mostrare il form di modifica
$isMyProfile = ($id_visto === $_SESSION["userID"]);
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
  <?php require_once "../libs/navbar.html"; ?>

  <div id="main-content" class="main-content">
    <div class="profile-container">
      <h2>Profilo di 
        <?= htmlspecialchars($dati["nome"] . " " . $dati["cognome"]) ?>
      </h2>

      <?php if ($isMyProfile): ?>
        <!-- 6A) Form di modifica: solo per il proprio profilo -->
        <form method="post" action="../php/editProfilo.php?id=<?= $id_visto ?>"
              enctype="multipart/form-data" class="profile-card">
      <?php else: ?>
        <!-- 6B) Vista in sola lettura: per gli altri profili -->
        <div class="profile-card view-only-profile">
      <?php endif; ?>

        <!-- Immagine del profilo -->
        <div class="profile-image">
          <img src="<?= $dati["immagine"]
                       ? "../imgprofilo/" . htmlspecialchars($dati["immagine"])
                       : "../Immagini/default-profile.png" ?>"
               alt="Immagine Profilo" id="profilePic">
          <?php if ($isMyProfile): ?>
            <label for="profileImageInput" class="custom-file-label">Cambia Immagine</label>
            <input type="file" name="immagine" id="profileImageInput" accept="image/*">
          <?php endif; ?>
        </div>

        <!-- Dati utente -->
        <div class="profile-details">

          <!-- Nome utente (readonly) -->
          <div class="form-group">
            <label>Nome utente</label>
            <?php if ($isMyProfile): ?>
              <input type="text" name="username"
                     value="<?= htmlspecialchars($dati["nome"] . " " . $dati["cognome"]) ?>"
                     readonly>
            <?php else: ?>
              <p><?= htmlspecialchars($dati["nome"] . " " . $dati["cognome"]) ?></p>
            <?php endif; ?>
          </div>

          <!-- Classe -->
          <div class="form-group">
            <label for="class">Classe</label>
            <?php if ($isMyProfile): ?>
              <input type="text" id="class" name="classe"
                     value="<?= htmlspecialchars($dati["classe"]) ?>" required>
            <?php else: ?>
              <p><?= htmlspecialchars($dati["classe"]) ?></p>
            <?php endif; ?>
          </div>

          <!-- Indirizzo scolastico -->
          <div class="form-group">
            <label for="schoolAddress">Indirizzo scolastico</label>
            <?php if ($isMyProfile): ?>
              <select id="schoolAddress" name="schoolAddress" required>
                <option value="nessuno"     <?= $dati["indirizzo"]=="nessuno"     ? "selected":"" ?>>Nessuno</option>
                <option value="informatica" <?= $dati["indirizzo"]=="informatica" ? "selected":"" ?>>Informatica</option>
                <option value="elettrotecnica" <?= $dati["indirizzo"]=="elettrotecnica" ? "selected":"" ?>>Elettrotecnica</option>
              </select>
            <?php else: ?>
              <p><?= htmlspecialchars($dati["indirizzo"]) ?></p>
            <?php endif; ?>
          </div>

          <!-- Email (readonly) -->
          <div class="form-group">
            <label for="email">Email</label>
            <p><?= htmlspecialchars($dati["email"]) ?></p>
          </div>

          <!-- Bio -->
          <div class="form-group">
            <label for="bio">Descrizione</label>
            <?php if ($isMyProfile): ?>
              <textarea id="bio" name="bio" rows="4"
                        placeholder="Dicci qualcosa di te"><?= htmlspecialchars($dati["bio"]) ?></textarea>
            <?php else: ?>
              <p><?= nl2br(htmlspecialchars($dati["bio"])) ?></p>
            <?php endif; ?>
          </div>

        </div> <!-- .profile-details -->

        <?php if ($isMyProfile): ?>
          <!-- Pulsante salva solo sul proprio profilo -->
          <div class="form-group">
            <button type="submit" class="button">Salva modifiche</button>
          </div>
        <?php endif; ?>

      <?php if ($isMyProfile): ?>
        </form>
      <?php else: ?>
        </div>
      <?php endif; ?>

    </div> <!-- .profile-container -->
  </div>   <!-- #main-content -->

  <?php require_once "../libs/footer.html"; ?>

  <!-- Preview immagine quando scelgo un file -->
  <?php if ($isMyProfile): ?>
  <script>
    document.getElementById('profileImageInput').addEventListener('change', function(event) {
      var output = document.getElementById('profilePic');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src);
      }
    });
  </script>
  <?php endif; ?>
</body>
</html>
