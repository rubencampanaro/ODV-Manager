<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

require_once "./functions_benemerenze.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <title>ODV Manager</title>
  <meta charset="utf-8" />
  <?php require_once "../scripts/head.php"; ?>
  <script type="text/javascript">
  function gestioneBenemerenze(element, opzione, dati) {
    if (opzione=='inserisci')
    {
      event.preventDefault();
      dati += document.getElementById('nome_benemerenza').value+"|"+document.getElementById('descrizione').value;
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
          document.getElementById('benemerenze').innerHTML = this.responseText;
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
    httpRequest.open("POST", "./app.php?n=functions_benemerenze.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
  }
</script>
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-success">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-award fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Personalizza - Benemerenze</h1>
    </div>
  </div>
  <div class="container my-4 p-4 bg-white rounded shadow">
  <h4 class="fw-bold mt-1">Benemerenze:</h4>
  <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered align-middle mb-0 mt-4">
      <thead class="table-grey">
        <tr><th>Nome benemerenza</th><th>Descrizione</th><th>Opzione</th></tr>
      </thead>
      <tbody id="benemerenze">
        <?php echo compilaBenemerenze(); ?>
      </tbody>
    </table>
  </div>
</div>
<?php bodyEnd(); ?>
</body>
</html>
