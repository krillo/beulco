<?php

/**
 * Description of BeulcoCalc
 *
 * @author make
 */
class BeulcoCalc {

  private $debug;
  private $Vs;
  private $Pst;
  private $Psak;
  private $Tmax;
  private $glykol;
  private $glykoltype;
  private $e;
  private $Ve;
  private $Vwr;
  private $VexpDatatype;
  private $Vexp;
  private $VexpInt;
  private $VexpHalv;
  private $artData;
  private $expnsionskarl;

  public function __construct() {
    
  }

  /**
   * Huvudmetoden - räknar ut expansionskärlet
   * Returnerar nummret på kärlet
   */
  public function mainCalcExpansion($Vs, $Pst, $Psak, $Tmax, $glykol, $glykoltype, $debug) {
    $this->Vs = $Vs;
    $this->Pst = $Pst;
    $this->Psak = $Psak;
    $this->Tmax = $Tmax;
    $this->glykol = $glykol;
    $this->glykoltype = $glykoltype;

    //e = expansionsfaktor
    if ($glykol != 0) {
      $this->e = $this->getExpansionsfaktor($this->glykol, $this->glykoltype);
    } else {
      $this->e = 1;
    }

    //Ve = systemexpansion
    $this->Ve = $this->Vs * $this->e;

    //Reservvolym:
    //Vwr= Vs*0,005, ska dock vara minst 3 liter.
    $this->Vwr = $this->Vs * 0.005;
    if ($this->Vwr < 3.0) {
      $this->Vwr = 3;
    }

    //Minsta kärlstorlek:
    //Vexp=((Psäk*0,9)+1)/((Psäk*0,9)-(Pst/10))*(Ve+Vwr)
    $this->Vexp = (($this->Psak * 0.9) + 1) / (($this->Psak * 0.9) - ($this->Pst / 10)) * ($this->Ve + $this->Vwr);
    $this->VexpDatatype = gettype($this->Vexp);

    //välj expansionskärl
    $this->artData = $this->getArticleData($this->Vexp);

    //skriv ut debugdata
    if ($debug == 1) {
      $this->toString();
    }
    return $this->artData;
  }

  /**
   * calculate expansionfaktor by glykol
   * @return <type> 
   */
  private function getExpansionsfaktor($glykol, $glykoltype) {
    return 0.5;
  }

  /**
   * Hitta nästa störe kärl och returnera den
   */
  private function getArticleData($Vexp) {
    $articles = array(
        2 => array(
            Artnr => "0720007000",
            RSKnummer => "5535202",
            Volym => "2",
            Anslutning => "1/2",
            Hojd => "125",
            Diameter => "187",
            Fortryck => "3,5",
            Maxarbetstryck => "10"),
        4 => array(
            Artnr => "0720010000",
            RSKnummer => "5535208",
            Volym => "4",
            Anslutning => "3/4",
            Hojd => "225",
            Diameter => "195",
            Fortryck => "1,5",
            Maxarbetstryck => "5"),
        8 => array(
            Artnr => "0720013000",
            RSKnummer => "5535216",
            Volym => "8",
            Anslutning => "3/4",
            Hojd => "220",
            Diameter => "295",
            Fortryck => "1,5",
            Maxarbetstryck => "5"),
        12 => array(
            Artnr => "0720016000",
            RSKnummer => "5535224",
            Volym => "12",
            Anslutning => "3/4",
            Hojd => "294",
            Diameter => "281",
            Fortryck => "0,5",
            Maxarbetstryck => "4"),
        18 => array(
            Artnr => "0720019000",
            RSKnummer => "5535232",
            Volym => "18",
            Anslutning => "3/4",
            Hojd => "290",
            Diameter => "400",
            Fortryck => "0,5",
            Maxarbetstryck => "4"),
        25 => array(
            Artnr => "0720025000",
            RSKnummer => "5535240",
            Volym => "25",
            Anslutning => "3/4",
            Hojd => "324",
            Diameter => "415",
            Fortryck => "0,5",
            Maxarbetstryck => "4"),
        35 => array(
            Artnr => "0720028000",
            RSKnummer => "5535257",
            Volym => "35",
            Anslutning => "3/4",
            Hojd => "404",
            Diameter => "387",
            Fortryck => "0,5",
            Maxarbetstryck => "4"),
        50 => array(
            Artnr => "0720031000",
            RSKnummer => "5535265",
            Volym => "50",
            Anslutning => "3/4",
            Hojd => "407",
            Diameter => "507",
            Fortryck => "0,5",
            Maxarbetstryck => "4"),
        80 => array(
            Artnr => "0720034000",
            RSKnummer => "5535273",
            Volym => "80",
            Anslutning => "3/4",
            Hojd => "450",
            Diameter => "608",
            Fortryck => "2,0",
            Maxarbetstryck => "6"),
        105 => array(
            Artnr => "0720046000",
            RSKnummer => "5535241",
            Volym => "105",
            Anslutning => "3/4",
            Hojd => "500",
            Diameter => "665",
            Fortryck => "2,0",
            Maxarbetstryck => "6"),
        150 => array(
            Artnr => "0720037000",
            RSKnummer => "5535274",
            Volym => "150",
            Anslutning => "3/4",
            Hojd => "500",
            Diameter => "897",
            Fortryck => "2,0",
            Maxarbetstryck => "6"),
        200 => array(
            Artnr => "0720040000",
            RSKnummer => "5535275",
            Volym => "200",
            Anslutning => "3/4",
            Hojd => "600",
            Diameter => "812",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        250 => array(
            Artnr => "0720050000",
            RSKnummer => "5535242",
            Volym => "250",
            Anslutning => "3/4",
            Hojd => "630",
            Diameter => "957",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        300 => array(
            Artnr => "0720053000",
            RSKnummer => "5535243",
            Volym => "300",
            Anslutning => "3/4",
            Hojd => "630",
            Diameter => "1105",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        400 => array(
            Artnr => "0720056000",
            RSKnummer => "5535244",
            Volym => "400",
            Anslutning => "3/4",
            Hojd => "630",
            Diameter => "1450",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        500 => array(
            Artnr => "0720059000",
            RSKnummer => "5535245",
            Volym => "500",
            Anslutning => "1",
            Hojd => "750",
            Diameter => "1340",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        600 => array(
            Artnr => "0720062000",
            RSKnummer => "5535246",
            Volym => "600",
            Anslutning => "1",
            Hojd => "750",
            Diameter => "1555",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        700 => array(
            Artnr => "0720065000",
            RSKnummer => "5535247",
            Volym => "700",
            Anslutning => "1",
            Hojd => "750",
            Diameter => "1755",
            Fortryck => "2,5",
            Maxarbetstryck => "6"),
        800 => array(
            Artnr => "0720068000",
            RSKnummer => "5535248",
            Volym => "800",
            Anslutning => "1",
            Hojd => "750",
            Diameter => "1855",
            Fortryck => "2,5",
            Maxarbetstryck => "6")
    );

    //avrunda till närmsta heltal uppåt
    settype($Vexp, "integer");
    $this->VexpInt = $Vexp;


    if ($this->VexpInt < 800) { //Vexp < 800 slå i tabellen
      while (!array_key_exists($this->VexpInt, $articles) && $this->VexpInt < 800) {
        $this->VexpInt++;
      }
      $article = $articles[$this->VexpInt];
      return $article;
    } else { //Vexp > 800 använd dubbla kärl
      $this->VexpHalv = $this->VexpInt / 2;
      settype($this->VexpHalv, "integer");
      while (!array_key_exists($this->VexpHalv, $articles) && $this->VexpHalv < 800) {
        $this->VexpHalv++;
      }
      $article = $articles[$this->VexpHalv];
      $article['antal'] = 2;
      $ret = $article;
      if ($this->VexpInt > 800 && $this->VexpInt <= 1150) {  //öppet kärl
        $oppetkarl = array(
            Artnr => "0721359000",
            RSK => "5524100",
            Volym_l => "1150",
            Bredd_tryckh_mm => "460",
            Djup_tryckh_mm => "220",
            Höjd_tryckh_mm => "700",
            Vikt_tryckh_kg => "22,3");
        $ret['öppetkärl'] = $oppetkarl;
      }
      return $ret;
    }
  }

  /**
   * Print all variables
   */
  private function toString() {
    $classVars = array('Vs' => $this->Vs,
        'Pst' => $this->Pst,
        'Psak' => $this->Psak,
        'Tmax' => $this->Tmax,
        'glykol' => $this->glykol,
        'glykoltype' => $this->glykoltype,
        'e' => $this->e,
        'Ve' => $this->Ve,
        'Vwr' => $this->Vwr,
        'Vexp' => $this->Vexp,
        'VexpDatatype' => $this->VexpDatatype,
        'VexpInt' => $this->VexpInt,
        'VexpHalv' => $this->VexpHalv,
        'artData' => $this->artData,
    );

    echo "<pre>";
    print_r($classVars);
    echo"</pre>";
  }

}

?>
