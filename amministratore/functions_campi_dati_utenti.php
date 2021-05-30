<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaCampi($tipo) {
  $query = "SELECT codice, campo, predefinito FROM campi_dati_utenti WHERE tabella='$tipo';";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['campo']."</td>";
    if (!$riga['predefinito'])
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneCampi(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    else
    $output .= '<td class="fw-bold">Predefinito</td>';
    $output .= "</tr>";
  }
  $output .= '<tr>
  <form action="#" id="form_campi"
  onsubmit="'."gestioneCampi(this, 'inserisci', document.getElementById('nome_campo').value)".'"
  method="post"></form>
  <td><input type="text" form="form_campi" required class="form-control" id="nome_campo" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_campi" class="btn btn-success btn-sm">Inserisci</button></td>
  </tr>';
  mysqli_free_result($risultato);
  return $output;
}

if(isSet($_POST['opzione']))
{
  if(isSet($_POST['dati']))
  {
    switch ($_POST['opzione']) {
      case "visualizza":
      echo compilaCampi($_POST['dati']);
      break;
      case "inserisci":
      $dati = explode('|', $_POST['dati']);
      $dati[0] = str_replace(' ', '_', $dati[0]);
      $dati[0]=strtolower($dati[0]);
      $query1 = "INSERT INTO campi_dati_utenti VALUES (0, '".$dati[1]."', '".$dati[0]."', 0, 1);";
      $query2 = "ALTER TABLE ".$dati[1]." ADD ".$dati[0]." VARCHAR(255) NOT NULL;";
      $query = $query1 . " " . $query2;
      if (connectDBMulti($query))
      echo compilaCampi($dati[1]);
      break;
      case "elimina":
      $dati = explode('|', $_POST['dati']);
      $query = "SELECT campo, predefinito FROM campi_dati_utenti WHERE codice=".$dati[0].";";
      $risultato = connectDB($query);
      $riga = mysqli_fetch_assoc($risultato);
      if (!$riga['predefinito'])
      {
        $nome_campo = $riga['campo'];
        $query1 = "DELETE FROM campi_dati_utenti WHERE codice=".$dati[0].";";
        $query2 = "ALTER TABLE ".$dati[1]." DROP ".$nome_campo.";";
        $query = $query1 . " " . $query2;
        if (connectDBMulti($query))
        echo "elimina_true";
      }
      mysqli_free_result($risultato);
      break;
    }
  }
}
?>
