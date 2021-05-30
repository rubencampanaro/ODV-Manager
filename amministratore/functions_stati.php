<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaStati() {
  $query = "SELECT * FROM stati;";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['descrizione']."</td>";
    if (!$riga['predefinito'])
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneStati(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    else
    $output .= '<td class="fw-bold">Predefinito</td>';
    $output .= "</tr>";
  }
  $output .= '<tr>
  <form action="#" id="form_stati"
  onsubmit="'."gestioneStati(this, 'inserisci', '')".'"
  method="post"></form>
  <td><input type="text" type="text" form="form_stati" required class="form-control" id="nome_stato" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_stati" class="btn btn-success btn-sm">Inserisci</button></td>
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
      echo compilaStati();
      break;
      case "inserisci":
      $query = "INSERT INTO stati VALUES (0, '".$_POST['dati']."', 0);";
      if (connectDB($query))
      echo compilaStati();
      break;
      case "elimina":
      $query = "SELECT predefinito FROM stati WHERE codice=".$_POST['dati'].";";
      $risultato = connectDB($query);
      $riga = mysqli_fetch_assoc($risultato);
      if (!$riga['predefinito'])
      {
        $query = "DELETE FROM stati WHERE codice=".$_POST['dati'].";";
        if (connectDB($query))
        echo "elimina_true";
      }
      mysqli_free_result($risultato);
      break;
    }
  }
}
?>
