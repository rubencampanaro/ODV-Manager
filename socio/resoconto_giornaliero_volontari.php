<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

require_once ".././socio/functions_resoconto_giornaliero_volontari.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
  <script type="text/javascript">
  function opzioneAzione(element, opzione, dati) {
    var data = "opzione=" + opzione + "&dati=" + dati;
    if (window.XMLHttpRequest) {
      httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function(){
      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        if (this.responseText != "")
        switch(opzione) {
          case 'visualizza_giornata':
          document.getElementById('azioni').innerHTML = this.responseText;
          break;
          case 'dettagli':
          document.getElementById('dettagli_body').innerHTML = this.responseText;
          break;
        }
      }
    };
    httpRequest.open("POST", "./app.php?n=functions_resoconto_giornaliero_volontari.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
  }
</script>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-yellow">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-chart-line fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Resoconto giornaliero - Volontari</h1>
    </div>
  </div>
  <div class="container-md my-4 p-4 bg-white rounded shadow">
    <label class="fw-bold">Giornata di attività</label>
    <div class="row align-items-center g-2">
      <div class="col-10">
        <input type="date" id="giornata" class="form-select" required onchange="opzioneAzione(this, 'visualizza_giornata', this.value)" value="<?php echo date("Y-m-d"); ?>" />
      </div>
      <div class="col-2 text-center">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('giornata').value='<?php echo date("Y-m-d"); ?>'; opzioneAzione(this, 'visualizza_giornata', '<?php echo date("Y-m-d"); ?>');">Reset</button>
      </div>
    </div>
    <h4 class="fw-bold mt-4">Azioni di volontariato:</h4>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0 mt-4">
        <thead class="table-grey">
          <tr>
            <th>Codice</th><th>Nome Azione</th><th>Data inizio</th><th>Data fine</th><th>Ora inizio</th><th>Ora fine</th><th>Opzione</th>
          </tr>
        </thead>
        <tbody id="azioni">
          <?php echo elencoAzioni(date("Y-m-d")); ?>
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
