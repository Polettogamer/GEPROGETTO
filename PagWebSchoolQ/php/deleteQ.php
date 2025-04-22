<?php
session_start();

if (!isset($_SESSION['userID'])) {
    die("Accesso non autorizzato.");
}

$iddomanda = isset($_GET['id']) ? intval($_GET['id']) : 0;

require_once "connection.php";

try {
    // Prima cancella le risposte
    $stmt1 = $sql->prepare("DELETE FROM risposte WHERE questionID = ?");
    $stmt1->bind_param("i", $iddomanda);
    $stmt1->execute();

    // Poi cancella la domanda
    $stmt2 = $sql->prepare("DELETE FROM domande WHERE questionID = ?");
    $stmt2->bind_param("i", $iddomanda);
    $stmt2->execute();

    // Reindirizza dopo l'eliminazione
    header("Location: ../php_front/dashboard.php");
    exit;
} catch (Exception $e) {
    echo "Errore durante l'eliminazione: " . $e->getMessage();
    header("Location: ../php_front/dashboard.php");
    exit;
}
?>
