<?php
require_once "./session.php";

require_once ".././scripts/functions.php";

if(isSet($_POST['opzione']) && isSet($_POST['codice_utente']))
{
  switch ($_POST['opzione']) {
    case "dettagli":
    $query = "SELECT AM.*, RL.descrizione AS ruolo, (SELECT COUNT(*) FROM volontari_azioni
    WHERE volontario=".$_POST['codice_utente']." AND tabella = 'amministrazione') AS numero_azioni_di_volontariato
    FROM amministrazione AS AM, ruoli AS RL
    WHERE AM.codice = ".$_POST['codice_utente']." AND AM.ruolo = RL.codice;";
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
    if ($_POST['codice_utente'] != 1)
    {
      $query = "DELETE FROM amministrazione WHERE codice=".$_POST['codice_utente'];
      if (connectDB($query))
      echo "elimina_true";
    }
    break;
  }
}
?>
