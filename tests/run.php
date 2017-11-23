<?php

  require './class/Instagram.php';
  require './class/Check.php';

  $delim = "|"; 
  $mailpass = file_get_contents($argv[1], FILE_APPEND);
  $line= explode("\r\n", $mailpass);
  
  foreach ($line as $leni){
    $pisah = explode($delim, $leni);
    check($pisah[0],$pisah[1]);
    echo "\n";
  }

?>
