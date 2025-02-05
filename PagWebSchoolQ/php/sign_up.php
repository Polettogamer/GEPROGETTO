<?php
    $servername="localhost";
	$username="root";
	$password="";
	$dbname="schoolq";
	
	//Creazione della connessione
	$conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
		die("Connessione fallita: " . $conn->connect_error);
	}
	
	echo "<script>alert('Connessione al database riuscita.');</script>";

    $nome = $_POST['nome'];
    $cognome  = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!str_ends_with($email, "@iisvittorioveneto.it")) {
         echo "<script>alert('L\'email non è valida!');</script>";
        exit();
    }
    // dobbiamo hashare la password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserimento dei dati nel database, evitando la SQL Injection
    $sql = "INSERT INTO utenti (nome, cognome, email, password, privilegio) 
            VALUES (?, ?, ?, ?, 'USER')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cognome, $email, $hashed_password);


    if ($stmt->execute()) {
        echo "<script>alert('Inserimento avvenuto con successo!');</script>";
    } else {
        echo "<script>alert('Errore: " . $stmt->error . "');</script>";
    }


    $stmt->close();
    $conn->close();

?>

//PROBLEMA: L'INSERIMENTO NON INSERISCE!!!
