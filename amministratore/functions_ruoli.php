<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaRuoli() {
  $query = "SELECT * FROM ruoli;";
  $risultato = connectDB($query);
  $output = "";
  while($riga = mysqli_fetch_assoc($risultato))
  {
    $output .= "<tr><td>".$riga['descrizione']."</td>";
    if (!$riga['predefinito'])
    $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneRuoli(this, 'elimina', '".$riga['codice']."')".'">Elimina</button></td>';
    else
    $output .= '<td class="fw-bold">Predefinito</td>';
    $output .= "</tr>";
  }
  $output .= '<tr>
  <form action="#" id="form_ruoli"
  onsubmit="'."gestioneRuoli(this, 'inserisci', '')".'"
  method="post"></form>
  <td><input type="text" form="form_ruoli" required class="form-control" id="nome_ruolo" placeholder="inserisci" /></td>
  <td><button type="submit" form="form_ruoli" class="btn btn-success btn-sm">Inserisci</button></td>
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
      echo compilaRuoli();
      break;
      case "inserisci":
      $query = "INSERT INTO ruoli VALUES (0, '".$_POST['dati']."', 0);";
      if (connectDB($query))
      echo compilaRuoli();
      break;
      case "elimina":
      $query = "SELECT predefinito FROM ruoli WHERE codice=".$_POST['dati'].";";
      $risultato = connectDB($query);
      $riga = mysqli_fetch_assoc($risultato);
      if (!$riga['predefinito'])
      {
        $query = "DELETE FROM ruoli WHERE codice=".$_POST['dati'].";";
        if (connectDB($query))
        echo "elimina_true";
      }
      mysqli_free_result($risultato);
      break;
    }
  }
}
?>
