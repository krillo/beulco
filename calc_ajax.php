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
$glykoltyp = $_POST["glykoltyp"];


$expansionskarl = $bc->mainCalcExpansion($vs, $pst, $psak, $tmax, $glykol, $glykoltyp);

//if debug is enabled print all debug data
if (isset($_POST["debug"])) {
  $bc->toString();
} 
