<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

require_once "./scripts/functions.php";

if(isSet($_POST['login']))
{
  $email = checkInput($_POST['email']);
  $password = checkInput($_POST['password']);
  $email = str_replace(' ', '', $email);
  $password = str_replace(' ', '', $password);
  if (!empty($email) || !empty($password))
  {
    $codice_errore=0;
    if($_POST['tipo'] == 'amministrazione')
    {
      $query = "SELECT AM.codice, AM.password, AM.ruolo, RL.descrizione FROM amministrazione AS AM, ruoli AS RL WHERE AM.email = '$email' AND AM.ruolo = RL.codice;";
      $risultato = connectDB($query);
      if(mysqli_num_rows($risultato) == 1)
      {
        while ($riga = mysqli_fetch_assoc($risultato))
        {
          if (password_verify($password, $riga['password']))
          {
            $_SESSION['ruolo'] = $riga['ruolo'];
            $_SESSION['codice'] = $riga['codice'];
            $_SESSION['tabella'] = $_POST['tipo'];
            header("location: ./".strtolower($riga['descrizione'])."/index.php");
          }
          else
          $codice_errore=1;
        }
        mysqli_free_result($risultato);
      }
      else
      $codice_errore=2;
    }
    else
    {
      $query = "SELECT codice, password, ruolo FROM volontari AS VL WHERE email = '$email';";
      $risultato = connectDB($query);
      if(mysqli_num_rows($risultato) == 1)
      {
        while ($riga = mysqli_fetch_assoc($risultato))
        {
          if (password_verify($password, $riga['password']))
          {
            $_SESSION['ruolo'] = $riga['ruolo'];
            $_SESSION['codice'] = $riga['codice'];
            $_SESSION['tabella'] = $_POST['tipo'];
            header("location: ./volontario/index.php");
          }
          else
          $codice_errore=1;
        }
        mysqli_free_result($risultato);
      }
      else
      $codice_errore=2;
    }
  }
  else
  $codice_errore=3;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="./css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="./css/style.css" type="text/css" rel="stylesheet" />
  <link href="./img/icon.png" type="image/png" rel="icon" />
</head>
<body class="d-flex align-items-center">
  <main class="login">
    <form action="#" method="post">
      <div class="text-center">
        <img class="mb-4 rounded" src="./img/logo.png" alt="" width="120" height="68">
        <h1>ODV Manager</h1>
        <hr />
        <h3 class="fw-bold">Login</h1>
        </div>
        <?php
        if (isSet($codice_errore) && $codice_errore != 0)
        {
          $errore= '<div class="container mt-4 p-0">
          <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">';
          switch ($codice_errore) {
            case 1:
            $errore.= "<b>Attenzione</b> - Credenziali errate";
            break;
            case 2:
            $errore.= "<b>Attenzione</b> - Nessun utente trovato";
            break;
            case 3:
            $errore.= "<b>Errore</b> - Credenziali mancanti";
            break;
            default:
            break;
          }
          $errore.= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          </div>';
          echo $errore;
        }
        ?>
        <div class="my-4">
          <div class="mb-3">
            <label class="fw-bold" for="email">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="fw-bold" for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="fw-bold">Tipologia accesso:</label>
            <div>
              <div class="form-check form-check-inline">
                <input type="radio" name="tipo" id="amm" class="form-check-input" value="amministrazione" required />
                <label class="form-check-label" for="amm">Amministrazione</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" name="tipo" id="vol" class="form-check-input" value="volontari" required />
                <label class="form-check-label" for="vol">Volontario</label>
              </div>
            </div>
          </div>
        </div>
        <input type="submit" name="login" class="w-100 btn btn-lg btn-primary mb-3" value="Login" />
        <input type="reset" name="reset" class="w-100 btn btn-lg btn-secondary" value="Reset" />
      </form>
    </main>
    <script src="./scripts/bootstrap.bundle.min.js"></script>
  </body>
  </html>
