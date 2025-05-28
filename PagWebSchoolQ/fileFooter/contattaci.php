<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Contattaci - SchoolQ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/menuCSS.css">
  <link rel="stylesheet" href="../CSS/contattaciCSS.css">
  <link rel="icon" type="image/x-icon" href="../Immagini/faviconf.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php 
    require_once "../libs/navbar.html";
  ?>
  
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="contattaci-container">
      <h1>Contattaci</h1>
      <p>Hai bisogno di aiuto o vuoi inviarci un feedback? Compila il modulo sottostante e ti risponderemo il prima possibile.</p>
      <form action="processa_contatto.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="support@schoolq.com" readonly>
        
        <label for="messaggio">Messaggio:</label>
        <textarea id="messaggio" name="messaggio" rows="5" required></textarea>
        
        <button type="submit" class="button">Invia</button>
      </form>
    </div>
  </div>
  
  <?php 
    require_once "../libs/footer.html";
  ?>
</body>
</html>