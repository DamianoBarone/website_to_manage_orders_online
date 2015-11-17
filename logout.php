
<?php
session_start();

// cancello sessioni variabili
$_SESSION = array();

header("location:terrazzo_azzurro_prenotazione.php");
session_destroy();
?>
