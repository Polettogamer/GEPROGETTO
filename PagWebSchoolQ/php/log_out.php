<?php
session_start();

//Distruzione della sessione
session_unset();
session_destroy();

header("Location: ../index.html");
exit();
?>