<?php
function connectDB($query) {
  $connessione = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($connessione, "odv-manager");
  $risultato = mysqli_query ($connessione, $query);
  mysqli_close ($connessione);
  return $risultato;
}

function connectDBMulti($query) {
  $connessione = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($connessione, "odv-manager");
  $risultato = mysqli_multi_query($connessione, $query);
  mysqli_close ($connessione);
  return $risultato;
}

function checkInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function randomPassword() {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array();
  $alphaLength = strlen($alphabet) - 1;
  for ($i = 0; $i < 8; $i++) {
    $n = rand(0, $alphaLength);
    $pass[] = $alphabet[$n];
  }
  $password = implode($pass);
  return $password."|".password_hash($password, PASSWORD_DEFAULT);
}

function sendEmail($to, $subject, $message) {
  $from = 'odv@example.com';
  $body="<html><body><h1>ODV</h1><br><p>".$message."</p></body></html>";
  $headers = "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\nFrom:".$from;
  return mail($to,$subject,$body,$headers);
}
?>
