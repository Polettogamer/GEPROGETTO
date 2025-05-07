<?php
session_start();
require_once "../php/connection.php";
// Verifica se l'utente è loggato
if (!isset($_SESSION["userID"])) {
  header("Location: ../index.php"); // Redirect alla login se non autenticato
  exit;
}
$iddomanda = $_GET["id"];


// Recupera la domanda da modificare
$stmt_domanda = $conn->prepare("SELECT QuestionText FROM domande WHERE QuestionID = ?");
$stmt_domanda->bind_param("i", $iddomanda);
$stmt_domanda->execute();
$domanda = $stmt_domanda->get_result();
$domanda = $domanda->fetch_assoc();
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
    <?php require_once "../libs/navbar.html";?>
    
    <div class="main-content">
    
        <h2>Modifica la domanda</h2>
        
        <form method="POST" action="../php/editQ.php?id=<?=$iddomanda?>">
            
            

            <label for="domanda">Testo della domanda:</label>
            <textarea name="domanda" id="domanda" rows="4" required  ><?=$domanda["QuestionText"]?></textarea>

            <button type="submit">conferma Modifica</button>
        </form>
    </div>

    <?php require_once "../libs/footer.html";?>

</body>
</html>

<?php
$conn->close();
?>
