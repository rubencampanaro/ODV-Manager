<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaBenemerenze() {
  $query = "SELECT * FROM benemerenze;";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['nome']."</td>";
    $output .= "<td>".$riga['descrizione']."</td>";
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneBenemerenze(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    $output .= "</tr>";
  }
  if (empty($output))
  $output = '<tr><td class="text-center" colspan="100%">Nessuna benemerenza inserita.</td></tr>';
  $output .= '<tr>
  <form action="#" id="form_benemerenze"
  onsubmit="'."gestioneBenemerenze(this, 'inserisci', '')".'"
  method="post"></form>
  <td><input type="text" form="form_benemerenze" required class="form-control" id="nome_benemerenza" placeholder="inserisci" /></td>
  <td><input type="text" form="form_benemerenze" required class="form-control" id="descrizione" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_benemerenze" class="btn btn-success btn-sm">Inserisci</button></td></tr>';
  mysqli_free_result($risultato);
  return $output;
}

if(isSet($_POST['opzione']))
{
  if(isSet($_POST['dati']))
  {
    switch ($_POST['opzione']) {
      case "visualizza":
      echo compilaBenemerenze();
      break;
      case "inserisci":
      $dati = explode('|', $_POST['dati']);
      $query = "INSERT INTO benemerenze VALUES (0, '".$dati[0]."', '".$dati[1]."');";
      if (connectDB($query))
      echo compilaBenemerenze();
      break;
      case "elimina":
      $query = "DELETE FROM benemerenze WHERE codice=".$_POST['dati'].";";
      if (connectDB($query))
      echo "elimina_true";
      break;
    }
  }
}
?>
