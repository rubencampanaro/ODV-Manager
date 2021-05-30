<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaRuolo() {
  $query = "SELECT codice, descrizione FROM ruoli";
  $query .= " WHERE codice >= 4";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato))
  $output .= "<option value='".$riga['codice']."'>".$riga['descrizione']."</option>";
  mysqli_free_result($risultato);
  return $output;
}

function compilaStato() {
  $query = "SELECT codice, descrizione FROM stati;";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato))
  $output .= "<option value='".$riga['codice']."'>".$riga['descrizione']."</option>";
  mysqli_free_result($risultato);
  return $output;
}

function formExtra() {
  $query = "SELECT campo FROM campi_dati_utenti WHERE tabella = 'volontari' AND predefinito = FALSE;";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato))
  {
    $valore = str_replace('_', ' ', $riga['campo']);
    $valore = ucfirst($valore);
    $output .= "\n<div class='col'><label class='fw-bold' for='".$riga['campo']."'>$valore</label>
    <input type='text' class='form-control' name='".$riga['campo']."' id='".$riga['campo']."' placeholder='inserisci' /></div>";
  }
  mysqli_free_result($risultato);
  return $output;
}

function campoObbligatorio() {
  $query = "SELECT campo FROM campi_dati_utenti WHERE tabella = 'volontari' AND obbligatorio = 1 AND campo <> 'codice';";
  $risultato = connectDB($query);
  while($riga = mysqli_fetch_assoc($risultato))
  $risultati[] = $riga['campo'];
  mysqli_free_result($risultato);
  return $risultati;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-primary">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-user-plus fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Registra utente - Volontario</h1>
    </div>
  </div>
  <?php
  if(isSet($_POST['salva']))
  {
    $insert = "INSERT INTO volontari (";
      $values = "VALUES (";
        $verificato = true;
        $campi = campoObbligatorio();
        foreach ($_POST as $campo => $valore) {
        if ($campo != "salva")
        {
        if (empty($valore) && in_array($campo, $campi))
        {
        $verificato = false;
        break;
        }
        if (!empty($valore))
        {
        $insert .= "$campo, ";
        $values .= "'$valore', ";
        }
        }
        }
        if ($verificato)
        {
        $insert .= "password)\n";
        $password = randomPassword();
        $values .= "'".$password."');";
        $query = $insert . $values;
        if (connectDB($query))
        {
          $email=$_POST['email'];
          $subject="Registrazione Account - ODV";
          $message="Dati autenticazione | Account ODV\n
          \nUtente volontario - Ruolo: <i>".$_POST['ruolo']."</i>
          \nEmail: <b>$email</b>
          \nPassword: <b>$password</b>";
          sendEmail($email, $subject, $message);
          echo '<div class="container mt-4">
          <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
          <b>Informazione</b> - Utente inserito, email registrazione inviata.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          </div>';
        }
        else
        $verificato = false;
      }
      if (!$verificato)
      echo '<div class="container mt-4">
      <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
      <b>Errore</b> - Utente non inserito.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      </div>';
    }
    ?>
    <div class="container my-4 p-4 bg-white rounded shadow">
      <form action='#' method='post'>
        <div class="row row-cols-1 row-cols-md-2 g-4">
          <div class="col">
            <label class="fw-bold" for='cognome'>Cognome</label>
            <input type='text' class="form-control" name='cognome' id='cognome' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='nome'>Nome</label>
            <input type='text' class="form-control" name='nome' id='nome' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='luogo_nascita'>Luogo nascita</label>
            <input type='text' class="form-control" name='luogo_nascita' id='luogo_nascita' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='data_nascita'>Data nascita</label>
            <input type='date' class="form-control" required name='data_nascita' id='data_nascita' />
          </div>
          <div class="col">
            <label class="fw-bold" for='sesso'>Sesso</label>
            <select class="form-select" name='sesso' id='sesso' required>
              <option disabled selected value>Seleziona...</option>
              <option value='M'>Maschio</option>
              <option value='F'>Femmina</option>
              <option value='A'>Altro</option>
            </select>
          </div>
          <div class="col">
            <label class="fw-bold" for='codice_fiscale'>Codice fiscale</label>
            <input type='text' class="form-control" name='codice_fiscale' id='codice_fiscale' pattern="[A-Z0-9]{16}" required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='residenza'>Residenza</label>
            <input type='text' class="form-control" name='residenza' id='residenza' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='telefono_abitazione'>Telefono abitazione</label>
            <input type='text' class="form-control" name='telefono_abitazione' id='telefono_abitazione' placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='cellulare'>Cellulare</label>
            <input type='text' class="form-control" name='cellulare' id='cellulare' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='email'>E-mail</label>
            <input type='email' class="form-control" name='email' id='email' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='ruolo'>Ruolo</label>
            <select name='ruolo' id='ruolo' class='form-select' required>
              <option disabled selected value>Seleziona...</option>
              <?php echo compilaRuolo(); ?>
            </select>
          </div>
          <div class="col">
            <label class="fw-bold" for='stato'>Stato</label>
            <select name='stato' id='stato' class='form-select' required>
              <option disabled selected value>Seleziona...</option>
              <?php echo compilaStato(); ?>
            </select>
          </div>
          <div class="col">
            <label class="fw-bold" for='data_iscrizione'>Data iscrizione</label>
            <input type='date' class="form-control" name='data_iscrizione' id='data_iscrizione' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='note'>Note</label>
            <input type='text' class="form-control" name='note' id='note' required placeholder='inserisci' />
          </div>
          <div class="col">
            <label class="fw-bold" for='tessera'>Tessera</label>
            <input type='text' class="form-control" name='tessera' id='tessera' required placeholder='inserisci' />
          </div>
          <?php echo formExtra(); ?>
        </div>
        <div class="mt-5 text-center">
          <input class="btn btn-primary mb-0 me-5 w-25" type='submit' name='salva' value='Salva' />
          <input class="btn btn-secondary mb-0 w-25" type='reset' name='reset' value='Reset' />
        </div>
      </form>
    </div>
    <?php bodyEnd(); ?>
  </body>
  </html>
