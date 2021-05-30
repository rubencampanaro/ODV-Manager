<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function compilaBenemerenze($codice_utente_amministrazione) {
  $query = "SELECT codice, nome
  FROM benemerenze
  WHERE codice <> ALL
  (SELECT benemerenza
    FROM volontari_benemerenze
    WHERE volontario = $codice_utente_amministrazione AND tabella = 'amministrazione');";
    $risultato = connectDB($query);
    $output = "<select id='benemerenza' form='form_benemerenza' required class='form-select' required>
    <option disabled selected value>Seleziona...</option>";
    while ($riga = mysqli_fetch_assoc($risultato))
    $output .= "<option value='".$riga['codice']."'>".$riga['nome']."</option>";
    $output .= "</select>";
    mysqli_free_result($risultato);
    return $output;
  }

  function visualizzaBenemerenze($codice_utente_amministrazione) {
    $query = "SELECT BN.nome, BN.descrizione, date_format(VB.data_conferimento,'%d/%m/%Y') AS data_conferimento, VB.codice
    FROM volontari_benemerenze AS VB, benemerenze AS BN
    WHERE VB.volontario = ".$codice_utente_amministrazione." AND VB.benemerenza = BN.codice AND tabella = 'amministrazione';";
    $risultato = connectDB($query);
    $output = "";
    while($riga = mysqli_fetch_assoc($risultato))
    {
      $output .= "<tr>";
      foreach ($riga as $campo => $valore)
      {
        if ($campo != "codice")
        {
          if (empty($valore) || (strpos($valore, '00/00/0000') !== false))
          $output .= "<td>Vuoto</td>";
          else
          $output .= "<td>".ucfirst($valore)."</td>";
        }
        else
        $codice_benemerenza = $valore;
      }
      $output .= '<td><button class="btn btn-danger btn-sm" onclick="'."gestioneBenemerenze(this, 'elimina', '".$codice_utente_amministrazione."|".$codice_benemerenza."')".'">Elimina</button></td>';
      $output .= "</tr>";
    }
    mysqli_free_result($risultato);
    $output .= '<tr>
    <form action="#" id="form_benemerenza"
    onsubmit="'."gestioneBenemerenze(this, 'inserisci', $codice_utente_amministrazione)".'"
    method="post"></form>
    <td class="text-center" colspan="2">'.compilaBenemerenze($codice_utente_amministrazione) . '</td>
    <td><input type="date" form="form_benemerenza" class="form-control" required id="data" /></td>
    <td><button type="submit" form="form_benemerenza" class="btn btn-success btn-sm">Inserisci</button></td>
    </tr>';
    return $output;
  }

  if(isSet($_POST['opzione']) && isSet($_POST['dati']))
  {
    switch ($_POST['opzione']) {
      case "visualizza":
      echo visualizzaBenemerenze($_POST['dati']);
      break;
      case "inserisci":
      $dati = explode('|', $_POST['dati']);
      $query = "INSERT INTO volontari_benemerenze VALUES (0, ".$dati[0].", 'amministrazione', ".$dati[1].", '".$dati[2]."');";
      if (connectDB($query))
      echo visualizzaBenemerenze($dati[0]);
      break;
      case "elimina":
      $dati = explode('|', $_POST['dati']);
      $query = "DELETE FROM volontari_benemerenze WHERE codice=".$dati[1];
      if (connectDB($query))
      echo "elimina_true";
      break;
    }
  }
  ?>
