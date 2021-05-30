<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

require_once "./functions_azioni_volontariato.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
  <script type="text/javascript">
  function gestioneAzioni(element, opzione, dati) {
    if (opzione=='inserisci')
    {
      event.preventDefault();
      dati += document.getElementById('nome_azione').value+"|"+document.getElementById('descrizione').value;
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
          document.getElementById('azioni').innerHTML = this.responseText;
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
    httpRequest.open("POST", "./app.php?n=functions_azioni_volontariato.php", true);
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
        <i class="fas fa-thumbtack fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Personalizza - Azioni di volontariato</h1>
    </div>
  </div>
  <div class="container my-4 p-4 bg-white rounded shadow">
    <h4 class="fw-bold mt-1">Azioni:</h4>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0 mt-4">
        <thead class="table-grey">
          <tr><th>Nome azione</th><th>Descrizione</th><th>Opzione</th></tr>
        </thead>
        <tbody id="azioni">
          <?php echo compilaAzioni(); ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
