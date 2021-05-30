<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaAzioni() {
  $query = "SELECT codice, nome FROM azioni_volontariato;";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato))
  {
    if (isSet($_POST['azione_volontariato']) && $_POST['azione_volontariato'] == $riga['codice'])
    $output .= "<option selected value='".$riga['codice']."'>";
    else
    $output .= "<option value='".$riga['codice']."'>";
    $output .= ucfirst($riga['nome'])."</option>";
  }
  mysqli_free_result($risultato);
  return $output;
}

function campoObbligatorio($codice) {
  $query = "SELECT codice FROM campi_azioni_volontariato WHERE azione_volontariato = $codice AND obbligatorio = 1;";
  $risultato = connectDB($query);
  $risultati[] = "";
  while($riga = mysqli_fetch_assoc($risultato))
  $risultati[] = $riga['codice'];
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
  <script type="text/javascript">
  function dettagliAzione(codice) {
    var data = "opzione=form_dettagli" + "&dati=" + codice;
    if (window.XMLHttpRequest) {
      httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function(){
      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        document.getElementById('dettagli').innerHTML = this.responseText;
      }
    };
    httpRequest.open("POST", "./app.php?n=functions_azione_volontariato.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
  }

  document.addEventListener("DOMContentLoaded", function(){
    select_azione = document.getElementById("azione");
    if (select_azione.value != "")
    dettagliAzione(select_azione.value);
  });
  </script>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 bg-primary text-center">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-thumbtack fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Registra Azione di Volontariato</h1>
    </div>
  </div>
  <?php
  if(isSet($_POST['salva']))
  {
    $verificato = true;
    $query1 = "INSERT INTO volontari_azioni (volontario, tabella, azione_volontariato, data_inizio, data_fine, ora_inizio,ora_fine)
    VALUES ('".$_SESSION['codice']."', '".$_SESSION['tabella']."', '".$_POST['azione_volontariato']."', '".$_POST['data_inizio']."', '".$_POST['data_fine']."', '".$_POST['ora_inizio']."', '".$_POST['ora_fine']."');";
    $query2 = "INSERT INTO volontari_azioni_dettagli VALUES";
    $campi = campoObbligatorio($_POST['azione_volontariato']);
    foreach ($_POST as $campo => $valore) {
      if ($campo != "salva")
      {
        if (empty($valore) && in_array($campo, $campi))
        {
          $verificato = false;
          break;
        }
        if (!empty($valore))
        $query2 .= " (LAST_INSERT_ID(), '$campo', '$valore'),";
      }
    }
    if ($verificato)
    {
      $query2 = substr($query2, 0, -1);
      $query2 .= ";";
      $query = $query1 . " " . $query2;
      if (connectDBMulti($query))
      echo '<div class="container mt-4">
      <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
      <b>Informazione</b> - Azione di volontariato inserita.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      </div>';
      else
      $verificato = false;
    }
    if (!$verificato)
    echo '<div class="container mt-4">
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    <b>Errore</b> - Azione di volontariato non inserita.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    </div>';
  }
  ?>
  <div class="container my-4 p-4 bg-white rounded shadow">
    <label class="fw-bold">Azione di Volontariato</label>
    <select id="azione" class="form-select" required onchange="dettagliAzione(this.value)">
      <option disabled selected value>Seleziona...</option>
      <?php echo compilaAzioni(); ?>
    </select>
  </div>
  <div class="container my-4 p-4 bg-white rounded shadow">
    <h4 class="fw-bold mb-3">Dettagli</h4>
    <div id="dettagli">
      <p>Nessuna azione selezionata.</p>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
