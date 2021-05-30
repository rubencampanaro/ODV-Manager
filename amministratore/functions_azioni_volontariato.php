<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaAzioni() {
  $query = "SELECT * FROM azioni_volontariato;";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['nome']."</td>";
    $output .= "<td>".$riga['descrizione']."</td>";
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneAzioni(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    $output .= "</tr>";
  }
  if (empty($output))
  $output = '<tr><td class="text-center" colspan="100%">Nessuna azione di volontariato inserita.</td></tr>';
  $output .= '<tr>
  <form action="#" id="form_azioni"
  onsubmit="'."gestioneAzioni(this, 'inserisci', '')".'"
  method="post"></form>
  <td><input type="text" form="form_azioni" required class="form-control" id="nome_azione" placeholder="inserisci" /></td>
  <td><input type="text" form="form_azioni" required class="form-control" id="descrizione" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_azioni" class="btn btn-success btn-sm">Inserisci</button></td></tr>';
  mysqli_free_result($risultato);
  return $output;
}

if(isSet($_POST['opzione']))
{
  if(isSet($_POST['dati']))
  {
    switch ($_POST['opzione']) {
      case "visualizza":
      echo compilaAzioni();
      break;
      case "inserisci":
      $dati = explode('|', $_POST['dati']);
      $query = 'INSERT INTO azioni_volontariato VALUES (0, "'.$dati[0].'", "'.$dati[1].'");';
      if (connectDB($query))
      echo compilaAzioni();
      break;
      case "elimina":
      $query1 = "DELETE FROM campi_azioni_volontariato WHERE azione_volontariato=".$_POST['dati'].";";
      $query2 = "DELETE FROM azioni_volontariato WHERE codice=".$_POST['dati'].";";
      $query = $query1 . " " . $query2;
      if (connectDBMulti($query))
      echo "elimina_true";
      break;
    }
  }
}
?>
