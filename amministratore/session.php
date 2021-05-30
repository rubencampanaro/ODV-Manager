<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

if(isSet($_SESSION["ruolo"]))
{
  if ($_SESSION["ruolo"] != 1)
  header("location: .././avviso.php?code=1");
}
else
header("location: .././avviso.php?code=2");
?>
