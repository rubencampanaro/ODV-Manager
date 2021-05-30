<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

function elencoAzioni($giornata) {
  $query = "SELECT VA.codice, AV.nome, date_format(VA.data_inizio,'%d/%m/%Y') AS data_inizio , date_format(VA.data_fine,'%d/%m/%Y') AS data_fine, VA.ora_inizio, VA.ora_fine
  FROM volontari_azioni as VA, azioni_volontariato as AV
  WHERE VA.azione_volontariato = AV.codice AND (VA.data_inizio <= '$giornata' AND VA.data_fine >= '$giornata') AND VA.tabella = 'volontari';";
  $risultato = connectDB($query);
  $output = "";
  while ($riga = mysqli_fetch_assoc($risultato)) {
    $output .= "<tr>";
    foreach ($riga as $campo => $valore)
    {
      if (empty($valore) || (strpos($valore, '00/00/0000') !== false))
      $output .= "<td>Vuoto</td>";
      else
      $output .= "<td>$valore</td>";
    }
    $output .= '<td><button type="button" class="btn btn-success btn-sm mb-1 mb-lg-0" data-bs-toggle="modal" data-bs-target="#dettagli" onclick="'."opzioneAzione(this, 'dettagli', ".$riga['codice'].")".'">Dettagli</button></td>';
    $output .= "</tr>";
  }
  if (empty($output))
  $output = '<tr><td class="text-center" colspan="100%">Nessuna azione di volontariato registrata.</td></tr>';
  mysqli_free_result($risultato);
  return $output;
}

if(isSet($_POST['opzione']) && isSet($_POST['dati']))
{
  switch ($_POST['opzione']) {
    case "visualizza_giornata":
    echo elencoAzioni($_POST['dati']);
    break;

    case "form_dettagli":
      $query = "SELECT descrizione FROM azioni_volontariato WHERE codice = ".$_POST['dati'];
      $risultato = connectDB($query);
      $riga = mysqli_fetch_assoc($risultato);
      $output = "<p>".$riga['descrizione']."</p>";
      mysqli_free_result($risultato);
      $query = "SELECT codice, nome FROM campi_azioni_volontariato WHERE azione_volontariato = ".$_POST['dati'];
      $risultato = connectDB($query);
      $output .= "<form action='#' method='post'>
      <div class='row row-cols-1 row-cols-lg-2 g-4'>";
      while ($riga = mysqli_fetch_assoc($risultato))
      {
        $valore = str_replace('_', ' ', $riga['nome']);
        $valore = ucfirst($valore);
        $output .= "<div class='col'>
        <label class='fw-bold'>$valore</label>
        <input type='text' name='".$riga['codice']."' placeholder='inserisci' class='form-control' required />
        </div>";
      }
      mysqli_free_result($risultato);
      $output .= "<div class='col'>
      <label class='fw-bold'>Data</label>
      <div class='row mt-2 mt-sm-0'>
      <div class='col-1 my-auto'>
      <label>Inizio:</label>
      </div>
      <div class='col-sm-5 ps-3'>
      <input type='date' name='data_inizio' class='form-control' required />
      </div>
      <div class='col-1 my-auto'>
      <label>Fine:</label>
      </div>
      <div class='col-sm-5 ps-3'>
      <input type='date' name='data_fine'  class='form-control' required />
      </div>
      </div>
      </div>
      <div class='col'>
      <label class='fw-bold'>Ora</label>
      <div class='row mt-2 mt-sm-0'>
      <div class='col-1 my-auto'>
      <label>Inizio:</label>
      </div>
      <div class='col-sm-5 ps-3'>
      <input type='time' name='ora_inizio' required class='form-control' />
      </div>
      <div class='col-1 my-auto'>
      <label>Fine:</label>
      </div>
      <div class='col-sm-5 ps-3'>
      <input type='time' name='ora_fine' required class='form-control' />
      </div>
      </div>
      </div>
      <input type='hidden' name='azione_volontariato' value='".$_POST['dati']."' />
      </div>
      <div class='mt-5 text-center'>
      <input class='btn btn-primary mb-0 me-5 w-25' type='submit' name='salva' value='Salva' />
      <input class='btn btn-secondary mb-0 w-25' type='reset' name='reset' value='Reset' />
      </div>
      </form>";
      echo $output;
      break;

      case "dettagli":
      $query1 = "SELECT VA.codice, AV.nome as nome_azione, AV.descrizione as descrizione_azione, VL.codice as codice_utente, VL.nome, VL.cognome, VL.codice_fiscale,
      VA.data_inizio, VA.data_fine, VA.ora_inizio, VA.ora_fine
      FROM volontari_azioni as VA, azioni_volontariato as AV, volontari as VL
      WHERE VA.codice = ".$_POST['dati']." AND VA.azione_volontariato = AV.codice AND VA.volontario = VL.codice;";
      $query2 = "SELECT CAV.nome, VAD.valore
      FROM volontari_azioni_dettagli AS VAD, campi_azioni_volontariato AS CAV
      WHERE VAD.azione_volontariato = ".$_POST['dati']." AND VAD.campo = CAV.codice;";
      $output='<div class="row row-cols-1 row-cols-lg-2 g-3">';
      $risultato=connectDB($query1);
      while($riga = mysqli_fetch_assoc($risultato))
      foreach ($riga as $campo => $valore)
      {
        if (empty($valore) || (strpos($valore, '0000-00-00') !== false))
        $valore="Vuoto";
        else
        if (strpos($campo,"data")!==false)
        {
          $data = strtotime($valore);
          $valore = date("d/m/Y", $data);
        }
        $campo = str_replace('_', ' ', $campo);
        $campo = ucfirst($campo);
        $output.="<div class='col'>
        <label class='fw-bold'>$campo</label>
        <input type='text' class='form-control mb-1' name='$campo' readonly value='$valore' />
        </div>";
      }
      mysqli_free_result($risultato);
      $risultato=connectDB($query2);
      while($riga = mysqli_fetch_assoc($risultato))
      {
        if (empty($valore))
        $valore="Vuoto";
        else
        $valore=$riga['valore'];
        $campo=$riga['nome'];
        $campo = ucfirst($campo);
        $output.="<div class='col'>
        <label class='fw-bold'>$campo</label>
        <input type='text' class='form-control mb-1' name='$campo' readonly value='$valore' />
        </div>";
      }
      $output.="</div>";
      mysqli_free_result($risultato);
      echo $output;
      break;
    }
  }
  ?>
