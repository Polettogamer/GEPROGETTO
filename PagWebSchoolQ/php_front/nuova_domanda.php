<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schoolq";

// 1. Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// 2. Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoriaID = intval($_POST["categoria"]);
    $testoDomanda = trim($_POST["domanda"]);
    $userID = 1; // ID dell'utente (dovrai modificarlo con l'ID dell'utente loggato)
    
    if (!empty($testoDomanda) && $categoriaID > 0) {
        $stmt = $conn->prepare("INSERT INTO domande (categoriaID, userID, QuestionText, dataPubbl, nLike) VALUES (?, ?, ?, NOW(), 0)");
        $stmt->bind_param("iis", $categoriaID, $userID, $testoDomanda);

        if ($stmt->execute()) {
            echo "<p>Domanda inserita con successo!</p>";
        } else {
            echo "<p>Errore: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Compila tutti i campi.</p>";
    }
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
                <li><a class="button">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="main-content">
        <h2>Fai una nuova domanda</h2>
        
        <form method="POST" action="nuova_domanda.php">
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
        <p>&copy; 2025 SchoolQ. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
