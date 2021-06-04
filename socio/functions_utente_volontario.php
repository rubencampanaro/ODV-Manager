<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

if(isSet($_POST['opzione']) && isSet($_POST['codice_utente']))
{
    switch ($_POST['opzione']) {
      case "dettagli":
      $query = "SELECT VL.*, RL.descrizione AS ruolo, ST.descrizione AS stato, (SELECT COUNT(*) FROM volontari_azioni
      WHERE volontario=".$_POST['codice_utente']." AND tabella = 'volontari') AS numero_azioni_di_volontariato
      FROM volontari AS VL, ruoli AS RL, stati AS ST
      WHERE VL.codice = ".$_POST['codice_utente']." AND VL.ruolo = RL.codice AND VL.stato = ST.codice";
      $risultato = connectDB($query);
      $output='<div class="row row-cols-1 row-cols-lg-2 g-3">';
      while($riga = mysqli_fetch_assoc($risultato))
      foreach ($riga as $campo => $valore)
      {
        if ($campo != "password")
        {
          if (empty($valore) || (strpos($valore, '0000-00-00') !== false))
          $valore="Vuoto";
          else
          {
            if (strpos($campo,"data")!==false)
            {
              $data = strtotime($valore);
              $valore = date("d/m/Y", $data);
            }
            elseif ($campo == "sesso")
            {
              $sesso = array("M"=>"Maschio", "F"=>"Femmina", "A"=>"Altro");
              $valore = $sesso[$valore];
            }
          }
          $campo = str_replace('_', ' ', $campo);
          $campo = ucfirst($campo);
          $output.="<div class='col'>
          <label class='fw-bold'>$campo</label>
          <input type='text' class='form-control mb-1' name='$campo' readonly value=\"$valore\" />
          </div>";
        }
      }
      $output.="</div>";
      mysqli_free_result($risultato);
      echo $output;
      break;
      case "elimina":
      $query = "DELETE FROM volontari WHERE codice=".$_POST['codice_utente'];
      if (connectDB($query))
      echo "elimina_true";
      break;
    }
}
?>
