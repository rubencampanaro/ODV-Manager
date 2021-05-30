<?php
require_once "./session.php";

if(isSet($_GET['n']))
{
  $app = $_GET['n'];
  if (file_exists($app))
  require_once "./".$app;
  elseif (file_exists(".././volontario/".$app))
  require_once ".././volontario/".$app;
  else
  {
    $_GET['code'] = 3;
    require_once ".././avviso.php";
  }
}
else
{
  $_GET['code'] = 4;
  require_once ".././avviso.php";
}
?>
