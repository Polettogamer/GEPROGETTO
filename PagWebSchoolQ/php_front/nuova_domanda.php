<?php
session_start();
require_once "../php/connection.php";
// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
  header("Location: ../index.php"); // Redirect alla login se non autenticato
  exit;
}



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
    <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
</head>
<body>
    <?php require_once "../libs/navbar.html";?>
    
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

    <?php require_once "../libs/footer.html";?>

</body>
</html>

<?php
$conn->close();
?>
