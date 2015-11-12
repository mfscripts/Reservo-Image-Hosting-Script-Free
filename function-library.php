<?php

function randomfilename() {
  $salt = "0123456789abcdefghijklmnopqrstuvwxyz"; 
  srand((double)microtime()*1000000); 
      $i = 0; 
      while ($i <= 25) { 
            $num = rand() % 33; 
            $tmp = substr($salt, $num, 1); 
            $nname = $nname . $tmp; 
            $i++; 
      } 
      return $nname; 
}

function preparedata($string) {
  $string = trim($string);
  $string = strip_tags($string);
  $string = mysql_real_escape_string($string);
  return $string;
}

?>