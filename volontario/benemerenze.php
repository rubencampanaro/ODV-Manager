<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaElenco() {
  $query = "SELECT BN.nome, BN.descrizione, date_format(VB.data_conferimento,'%d/%m/%Y') AS data_conferimento
  FROM volontari_benemerenze as VB, benemerenze as BN
  WHERE VB.benemerenza = BN.codice AND VB.volontario = ".$_SESSION['codice']." AND tabella = '".$_SESSION['tabella']."';";;
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato)) {
    $output .= "<tr>";
    foreach ($riga as $campo => $valore)
    {
      if (empty($valore) || (strpos($valore, '00/00/0000') !== false))
      $output .= "<td>Vuoto</td>";
      else
      $output .= "<td>".ucfirst($valore)."</td>";
    }
    $output .= "</tr>";
  }
  if (empty($output))
  $output = '<tr><td class="text-center" colspan="100%">Nessuna benemerenza collezionata.</td></tr>';
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
</head>
<body>
  <?php require_once "../scripts/body.php"; bodyStart(); ?>
  <div class="py-5 text-center bg-success">
    <div class="d-flex align-items-center justify-content-center">
      <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x text-white"></i>
        <i class="fas fa-award fa-stack-1x text-body"></i>
      </span>
      <h1 class="text-white fw-bold text-shadow">Benemerenze</h1>
    </div>
  </div>
  <div class="container-md my-4 p-4 bg-white rounded shadow">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle mb-0">
        <thead class="table-grey">
          <tr>
            <th>Nome</th><th>Descrizione</th><th>Data conferimento</th>
          </tr>
        </thead>
        <tbody>
          <?php echo compilaElenco(); ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php bodyEnd(); ?>
</body>
</html>
