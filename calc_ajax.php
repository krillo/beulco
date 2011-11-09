<?php
/*
foreach ($_POST as $name => $value) {
  echo $name . " " . $value . '<br>';
}
*/

require_once("BeulcoCalc.php");
$bc = new BeulcoCalc();
$vs = $_POST["vs"];
$pst = $_POST["pst"];
$psak = $_POST["psak"];
$tmax = $_POST["tmax"];
$glykol = $_POST["glykol"];
$glykoltype = $_POST["glykoltype"];
if(isset ($_POST["debug"])){
  $debug = $_POST["debug"];
} else {
  $debug = 0;
}


$expansionskarl = $bc->mainCalcExpansion($vs,$pst,$psak,$tmax,$glykol,$glykoltype,$debug);
print_r($expansionskarl);
?>