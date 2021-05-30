<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaDettagli($codice_azione) {
  $query = "SELECT codice, nome FROM campi_azioni_volontariato WHERE azione_volontariato=$codice_azione;";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['nome']."</td>";
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneDettagliAzione(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    $output .= "</tr>";
  }
  $output .= '<tr>
  <form action="#" id="form_dettagli_azione"
  onsubmit="'."gestioneDettagliAzione(this, 'inserisci', '')".'"
  method="post"></form>
  <td><input type="text" form="form_dettagli_azione" required class="form-control" id="nome_dettaglio" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_dettagli_azione" class="btn btn-success btn-sm">Inserisci</button></td>
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
      echo compilaDettagli($_POST['dati']);
      break;
      case "inserisci":
      $dati = explode('|', $_POST['dati']);
      $query = "INSERT INTO campi_azioni_volontariato VALUES (0, '".$dati[0]."', 1, 1, '".$dati[1]."');";
      if (connectDB($query))
      echo compilaDettagli($dati[1]);
      break;
      case "elimina":
      $dati = explode('|', $_POST['dati']);
      $query = "DELETE FROM campi_azioni_volontariato WHERE codice=".$dati[0].";";
      if (connectDB($query))
      echo "elimina_true";
      break;
    }
  }
}
?>
