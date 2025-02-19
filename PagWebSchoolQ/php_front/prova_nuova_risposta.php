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
    <title>Domanda - SchoolQ</title>
    <link rel="stylesheet" href="../CSS/menuCSS.css">
    <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <script>
        // Funzione per mostrare/nascondere l'area di risposta
        function toggleAnswerForm() {
            var form = document.getElementById("answer-form");
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
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

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <h3>Materie</h3>
        <ul>
            <li><a href="categoria.php?id=1">Italiano</a></li>
            <!-- Altri link di categorie -->
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
                echo     '<button class="response-button" onclick="toggleAnswerForm()">Rispondi</button>';
                echo     '<div id="answer-form" style="display:none;">';
                echo       '<form method="POST" action="rispondi.php">';
                echo         '<textarea name="response-text" placeholder="Scrivi la tua risposta..."></textarea>';
                echo         '<button type="submit" class="submit-answer">Invia Risposta</button>';
                echo       '</form>';
                echo     '</div>';
                echo   '</div>';
                echo '</div>';
            } else {
                echo "<p>Nessuna domanda disponibile.</p>";
            }
            ?>
            
            <hr>

            <h3 class="response-title">Risposte:</h3>
        </div>

        <div class="risposte">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="question-item">';
                    echo   '<div class="question-header">';
                    echo     '<div class="question-meta">Pubblicato alle ' . $row["dataPubbl"] . ' - da <strong>' . $row['nome'] . ' ' . $row['cognome'] . '</strong></div>';
                    echo   '</div>';
                    echo   '<div class="question-body">';
                    echo     '<p>' . nl2br(htmlspecialchars($row["testoRisposta"])) . '</p>';
                    echo   '</div>';
                    echo   '<div class="question-footer">';
                    echo     '<div class="question-stats">';
                    echo       '<span>Likes: ' . htmlspecialchars($row["nLike"]) . '</span>';
                    echo     '</div>';
                    echo   '</div>';
                    echo   '<hr>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nessuna risposta disponibile.</p>";
            }
            ?>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <!-- Contenuto footer -->
        </div>
    </footer>
</body>
</html>
