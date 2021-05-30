<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

require_once ".././volontario/functions_azione_volontariato.php";
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
    httpRequest.open("POST", "./app.php?n=functions_azione_volontariato.php", true);
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
        <i class="fas fa-tasks fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Gestione Azioni di Volontariato</h1>
    </div>
  </div>
  <div class="container-md my-4 p-4 bg-white rounded shadow">
    <label class="fw-bold">Giornata di attività</label>
    <div class="row align-items-center g-2">
      <div class="col-10">
        <input type="date" id="giornata" class="form-select" required onchange="opzioneAzione(this, 'visualizza_giornata', this.value)" />
      </div>
      <div class="col-2 text-center">
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('giornata').value=''; opzioneAzione(this, 'visualizza_giornata', '');">Reset</button>
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
          <?php echo elencoAzioni(null); ?>
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
