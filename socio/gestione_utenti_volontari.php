<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function elencoUtenti() {
  $query = "SELECT codice, nome, cognome, codice_fiscale, luogo_nascita, date_format(data_nascita,'%d/%m/%Y') AS data_nascita FROM volontari";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato)) {
    $output .= "<tr>";
    foreach ($riga as $campo => $valore)
    {
      if (empty($valore) || (strpos($valore, '00/00/0000') !== false))
      $output .= "<td>Vuoto</td>";
      else
      $output .= "<td>$valore</td>";
    }
    $output .= '<td><button type="button" class="btn btn-success btn-sm mb-1 mb-lg-0" data-bs-toggle="modal" data-bs-target="#dettagli" onclick="'."opzioneUtente(this, 'dettagli', ".$riga['codice'].")".'">Dettagli</button>
    <button type="button" class="btn btn-danger btn-sm" onclick="'."opzioneUtente(this, 'elimina', ".$riga['codice'].")".'">Elimina</button></td>';
    $output .= "</tr>";
  }
  if (empty($output))
  $output = '<tr><td class="text-center" colspan="100%">Nessun volontario registrato.</td></tr>';
  mysqli_free_result($risultato);
  return $output;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
  <script type="text/javascript">
  function opzioneUtente(element, opzione, codice) {
    var data = "opzione=" + opzione + "&codice_utente=" + codice;
    if (window.XMLHttpRequest) {
      httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function(){
      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        if (this.responseText != "")
        switch(opzione) {
          case 'dettagli':
          document.getElementById('dettagli_body').innerHTML = this.responseText;
          break;
          case 'elimina':
          if (this.responseText=='elimina_true')
          {
            var td = element.parentNode;
            var tr = td.parentNode;
            tr.parentNode.removeChild(tr);
          }
          break;
        }
      }
    };
    httpRequest.open("POST", "./app.php?n=functions_utente_volontario.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
  }
</script>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-danger">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-user-cog fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Gestione utenti - Volontari</h1>
    </div>
  </div>
  <div class="container-md my-4 p-4 bg-white rounded shadow">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0">
        <thead class="table-grey">
          <tr>
            <th>Codice</th><th>Nome</th><th>Cognome</th><th>Codice fiscale</th><th>Luogo nascita</th><th>Data nascita</th><th>Opzione</th>
          </tr>
        </thead>
        <tbody>
          <?php echo elencoUtenti(); ?>
        </tbody>
      </table>
    </div>
  </div>
  <div id="dettagli" class="modal fade" tabindex="-1" aria-labelledby="dettagli" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Dettagli</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="dettagli_body">
        </div>
      </div>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
