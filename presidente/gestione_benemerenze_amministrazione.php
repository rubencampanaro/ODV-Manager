<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaUtentiAmministrazione() {
  $query = "SELECT codice, CONCAT(nome, ' ', cognome), codice_fiscale FROM amministrazione;";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<option value='".$riga['codice']."'>";
    foreach ($riga as $campo => $valore)
    if (empty($valore) || $valore == " ")
    $output .= "Vuoto - ";
    else
    $output .= "$valore - ";
    $output = substr($output, 0, -3);
    $output .= "</option>";
  }
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
  function gestioneBenemerenze(element, opzione, dati) {
    if (opzione=='inserisci')
    {
      event.preventDefault();
      dati += "|"+document.getElementById('benemerenza').value+"|"+document.getElementById('data').value;
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
    httpRequest.open("POST", "./app.php?n=functions_benemerenze_amministrazione.php", true);
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
      <h1 class="text-white fw-bold text-shadow">Gestione benemerenze - Amministrazione</h1>
    </div>
  </div>
  <div class="container my-4 p-4 bg-white rounded shadow">
    <label class="fw-bold">Utente amministrazione</label>
    <select id="utente_amministrazione" class="form-select" required onchange="gestioneBenemerenze(this, 'visualizza', this.value)">
      <option disabled selected value>Seleziona...</option>
      <?php echo compilaUtentiAmministrazione(); ?>
    </select>
    <h4 class="fw-bold mt-4">Benemerenze:</h4>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0 mt-4">
        <thead class="table-grey">
          <tr><th>Nome</th><th>Descrizione</th><th>Data conferimento</th><th>Opzione</th></tr>
        </thead>
        <tbody id="benemerenze">
          <tr><td class="text-center" colspan="100%">Nessun utente selezionato.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
