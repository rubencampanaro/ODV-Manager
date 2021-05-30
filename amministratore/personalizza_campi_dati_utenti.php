<?php
require_once "./session.php";

require_once ".././scripts/functions.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
  <script type="text/javascript">
  function gestioneCampi(element, opzione, dati) {
    if (opzione=='inserisci' || opzione=='elimina')
    {
      event.preventDefault();
      dati += "|"+document.getElementById('tipo').value;
    }
    var data = "dati=" + dati + "&opzione=" + opzione;
    if (window.XMLHttpRequest) {
      httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function(){
      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        if (this.responseText != "")
        switch(opzione) {
          case 'visualizza':
          case 'inserisci':
          document.getElementById('campi').innerHTML = this.responseText;
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
    httpRequest.open("POST", "./app.php?n=functions_campi_dati_utenti.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
  }
</script>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-primary">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-user-shield fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Personalizza - Campi dati utenti</h1>
    </div>
  </div>
  <div class="container my-4 p-4 bg-white rounded shadow">
    <label class="fw-bold">Tipo di utente:</label><br />
    <select id="tipo" class="form-select" required onchange="gestioneCampi(this, 'visualizza', this.value)">
      <option disabled selected value>Seleziona...</option>
      <option value="amministrazione">Amministrazione</option>
      <option value="volontari">Volontario</option>
    </select>
    <h4 class="fw-bold mt-4">Campi:</h4>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0 mt-4">
        <thead class="table-grey">
          <tr><th>Nome campo</th><th>Opzione</th></tr>
        </thead>
        <tbody id="campi">
          <tr><td class="text-center" colspan="100%">Nessuna tipologia di utente selezionata.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
