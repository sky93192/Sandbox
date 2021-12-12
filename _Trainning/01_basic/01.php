<?php
$a = null;
$b = NULL;
$c = 0;
$d = 'null';

if($a){
  echo 'true ';
}else{
  echo 'false ';
}

if($b){
  echo 'true ';
}else{
  echo 'false ';
}

if($c){
  echo 'true ';
}else{
  echo 'false ';
}

if($d){
  echo 'true ';
}else{
  echo 'false ';
}

echo PHP_EOL; //換行

is_null($a);
is_null($b);
is_null($c);
is_null($d);

echo PHP_EOL; //換行

var_dump($a, $b, $c, $d);

?>