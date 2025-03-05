<?php
session_start();
// Configurazione della connessione al database
$servername = "localhost"; // Cambia se necessario
$username = "root"; // Il tuo username del database
$password = ""; // La tua password del database
$dbname = "schoolq"; // Nome del database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Recupero dati dal form
$classe = $_POST["classe"];


$target_dir = "../Immagini";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
?>