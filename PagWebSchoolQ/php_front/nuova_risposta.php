<?php
// Avvio della sessione per gestire l'autenticazione dell'utente
session_start();

// Verifica che l'utente sia loggato. Se non lo è, reindirizza alla pagina di login.
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// Recupera l'ID della domanda dalla query string (es. nuova_risposta.php?id=3)
$iddomanda = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($iddomanda <= 0) {
    die("ID domanda non valido.");
}

// Variabile per mostrare messaggi di feedback all'utente
$feedback = "";

// Dati per la connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schoolq";

// Creazione della connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Query per ottenere i dettagli della domanda
$stmt_domanda = $conn->prepare("SELECT d.*, u.nome, u.cognome, c.nome AS nomecat 
                                FROM domande d 
                                JOIN utenti u ON d.userID = u.userID
                                JOIN categorie c ON c.IDCategoria = d.categoriaID
                                WHERE d.QuestionID = ?");
$stmt_domanda->bind_param("i", $iddomanda);
$stmt_domanda->execute();
$domanda = $stmt_domanda->get_result();

// Controlla se la domanda esiste
if ($domanda->num_rows > 0) {
    $row_domanda = $domanda->fetch_assoc();
} else {
    die("Domanda non trovata.");
}
$stmt_domanda->close();

// Se il form viene inviato (metodo POST) allora si processa la risposta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera il testo della risposta e rimuove eventuali spazi superflui
    $testoRisposta = trim($_POST['risposta']);
    
    // Verifica che il testo della risposta non sia vuoto
    if (empty($testoRisposta)) {
        $feedback = "La risposta non può essere vuota.";
    } 
    // Verifica che la risposta non superi i 1000 caratteri
    elseif (strlen($testoRisposta) > 1000) {
        $feedback = "La risposta non può contenere più di 1000 caratteri.";
    } else {
        // Preparazione della query per inserire la nuova risposta
        $stmt = $conn->prepare("INSERT INTO risposte (questionID, userID, testoRisposta, dataPubbl, nLike) VALUES (?, ?, ?, NOW(), 0)");
        $userID = $_SESSION['userID']; // Recupera l'ID dell'utente dalla sessione
        $stmt->bind_param("iis", $iddomanda, $userID, $testoRisposta);
        
        // Esegue l'inserimento nel database
        if ($stmt->execute()) {
            // Se l'inserimento ha avuto successo, reindirizza alla pagina delle risposte
            header("Location: risposta.php?id=" . $iddomanda);
            exit;
        } else {
            // In caso di errore, memorizza il messaggio di feedback
            $feedback = "Errore durante l'invio della risposta: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuova Risposta</title>
    <link rel="stylesheet" href="../CSS/nuova_risposta.css">
    <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- TOP NAVBAR -->
    <header class="top-navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="../Immagini/mondo01.png" alt="SchoolQ Logo">
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="profilo.php">Profilo</a></li>
                <li><a href="../index.html" class="button">Logout</a></li>
            </ul>
        </div>
    </header>

    <!-- CONTENUTO PRINCIPALE -->
    <div class="main-content">
        <h2>Rispondi alla domanda</h2>

        <!-- Visualizza i dettagli della domanda -->
        <div class="question-preview">
            <h3>Stai rispondendo a:</h3>
            <div class="question-header">
                <h4 class="question-title"><?php echo htmlspecialchars($row_domanda["nomecat"]); ?></h4>
                <p class="question-meta">
                    Pubblicato il <?php echo $row_domanda["dataPubbl"]; ?> - 
                    da <strong><?php echo htmlspecialchars($row_domanda['nome'] . ' ' . $row_domanda['cognome']); ?></strong>
                </p>
            </div>
            <div class="question-body">
                <p><?php echo nl2br(htmlspecialchars($row_domanda["QuestionText"])); ?></p>
            </div>
        </div>
        <hr>

        <!-- Visualizza eventuali messaggi di feedback -->
        <?php
        if ($feedback != "") {
            echo '<p class="feedback">' . htmlspecialchars($feedback) . '</p>';
        }
        ?>

        <!-- Form per inviare la risposta -->
        <form action="nuova_risposta.php?id=<?php echo $iddomanda; ?>" method="post">
            <div class="form-group">
                <label for="risposta">Inserisci la tua risposta:</label>
                <textarea id="risposta" name="risposta" rows="6" required></textarea>
            </div>
            <button type="submit">Invia Risposta</button>
        </form>
        <br>
        <!-- Link per tornare manualmente alla pagina delle risposte -->
        <form action="risposta.php" method="GET">
            <input type="hidden" name="id" value="<?php echo $iddomanda; ?>">
            <button type="submit" class="button">Torna alla domanda</button>
        </form>
    </div>

    <!-- FOOTER -->
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
