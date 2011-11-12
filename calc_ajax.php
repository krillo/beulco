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
if (isset($_POST["debug"])) {
  $debug = $_POST["debug"];
} else {
  $debug = 0;
}


$expansionskarl = $bc->mainCalcExpansion($vs, $pst, $psak, $tmax, $glykol, $glykoltyp);
echo '<div id="result-text" class="clear">';

//dubbla kärl
if ($expansionskarl['antal'] != 0) {
  $text = 'Eftersom volymen överstiger 800 l föreslår vi att ni använder 2 st expansionskärl med artikelnummer %s och RSK-nummer %s.  <a href="http://www.beulco.se/index.php?option=com_webcatalog&view=productlist&Itemid=56&pid=20092&gid=20007&menuid=20007" target="_top">Till produktsidan</a>';
  printf($text, $expansionskarl['Artnr'], $expansionskarl['RSKnummer']);
  if($expansionskarl['öppetkärl'] != null){
    //öppet kärl också
    $text2 = '<br/>Alternativt får ni välja ett öppet kärl med artikelnummer %s och RSK-nummer %s.  <a href="http://www.beulco.se/index.php?option=com_webcatalog&view=productlist&Itemid=56&pid=20092&gid=20007&menuid=20007" target="_top">Till produktsidan</a>';
    printf($text2, $expansionskarl['öppetkärl']['Artnr'], $expansionskarl['öppetkärl']['RSKnummer']);
  }
} else {
//enkelt kärl
  $text = 'Vi föreslår expansionskärl med artikelnummer %s och RSK-nummer %s.  <a href="http://www.beulco.se/index.php?option=com_webcatalog&view=productlist&Itemid=56&pid=20092&gid=20007&menuid=20007" target="_top">Till produktsidan</a>';
  printf($text, $expansionskarl['Artnr'], $expansionskarl['RSKnummer']);
}
echo '</div><div class="clear"></div>';



//if debug is enabled print all debug data
if ($debug == 1) {
  $bc->toString();
}
