<?php

  require './class/Instagram.php';
  require './class/Check.php';

  $delim = "|"; //delim
  $mailpass = file_get_contents('mailpass.txt', FILE_APPEND); //mailpass.txt
  $line= explode("\r\n", $mailpass);
  
  foreach ($line as $leni){
    $pisah = explode($delim, $leni);
    check($pisah[0],$pisah[1]);
    echo "\n";
  }

?>
