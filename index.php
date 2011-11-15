<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js'></script>
    <script src="jquery.validate.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="http://www.beulco.se/templates/beulco_template/css/template.css" type="text/css" />
    <title>beulco</title>

    <script type="text/javascript">    
      $(function() {
        //do input validation
        var validator = $("#valuesForm").validate({
          rules: {
            volume: {
              required: true,
              digits: true,
              min: 1
            },
            pst: {
              required: true
            },
            psak: {
              required: true,
            },
            tmax: {
              required: true,
              digits: true,
              range: [1, 110]
            }
          },
          messages: {
            volume: {
              required: "Volymen saknas",
              digits: "Volymen måste vara ett heltal",
              min: jQuery.format("Volymen måste vara större än {0}")
            },
            pst: {
              required: "Statiska höjden saknas"
            },
            psak: {
              required: "Öppningstrycket saknas",
            },
            tmax: {
              required: "Volymen saknas",
              digits: "Volymen måste vara ett heltal",
              range: jQuery.format("Temperaturen måste vara mellan 1 och 110 grader")
            }
          }
        });


        //if validation is ok do the ajax call to calculate
        $("#calc").click(function() {
          if($("#valuesForm").valid()){
            doCalc();
          }
        });


        //get parameters and claculate
        function doCalc(){
          var volume = $("#volume").val();
          var vs = parseInt(volume);
          var pst = $("#pst").val();
          pst = pst.replace(',', '.');  //replace , with .
          var psak = $("#psak").val();
          psak = psak.replace(',', '.');  //replace , with .
          var tmax = $("#tmax").val();

          var glykol = $("#glykol").val();
          if(glykol == ''){
            glykol = 0;          //glykol är inte ifyllt
          }
          var glykoltyp = '';
          if($('#propylen').is(':checked')) {
            glykoltyp = 'propylen';
          } else {
            glykoltyp = 'etylen';
          }

          var debug = $("#debug").val();
          if(debug != ''){
            dataString = 'debug=1&';
          }

          var dataString = dataString + 'vs='+ vs + '&pst='+ pst + '&psak='+ psak + '&tmax='+ tmax + '&glykol=' + glykol + '&glykoltyp=' + glykoltyp;

          if(dataString==''){
          } else{
            $.ajax({
              type: "POST",
              url: "calc_ajax.php/",
              data: dataString,
              cache: false,
              success: function(html){
                $("#result").show();
                $("#result").html(html);
              }
            });
          }
          return false;
        }
      });
    </script>

    <style type="text/css">
      .mandatory{color:red;}
      .box{padding:0 0 10px 10px;background-color:#e7e7e7;width:650px; float:left;}
      .alone{padding:10px;}
      input{width:40px;}
      .label{font-weight:bold;}
      .heading{font-weight:bold;margin-bottom: 15px;}
      .labels{width:240px; float:left;}
      .inputs{width:400px; float:left;}
      .clear{clear:both;}
      #debug{padding:10px;background-color:#e7e7e7;width:400px; float:left;}
      #result-text{padding:10px;width:900px; float:left;}
      .error{padding-left: 10px; color: red;}
    </style>




  </head>
  <body>
    <div class="heading">Dimensionering av expansionskärl</div>

    <form  id="valuesForm" method="get" action="">
      <fieldset>
        <div class="box">
          <div class="labels">Totala volymen (l)<span class="mandatory">*</span></div><br/>
          <div class="labels">Systemvolym + Kulvert + Ackumulator</div>
          <div class="inputs">
            <input type="text" name="volume" value="" id="volume"/><br/>
          </div>
        </div>
        <div class="clear"></div>

        <div class="box">
          <div class="labels">Statisk höjd (m)<span class="mandatory">*</span> </div>
          <div class="inputs"><input type="text" name="pst" value="" id="pst" /></div>
        </div>
        <div class="clear"></div>

        <div class="box">
          <div class="labels">Säkerhetsventilens öppningstryck (bar)<span class="mandatory">*</span></div>
          <div class="inputs"><input type="text" name="psak" value="" id="psak" /></div>
        </div>
        <div class="clear"></div>

        <div class="box">
          <div class="labels">Maximal vattentemperatur(grader C)<span class="mandatory">*</span></div>
          <div class="inputs"><input type="text" name="tmax" value="" id="tmax" /></div>
        </div>
        <div class="clear"></div>

        <div class="box">
          <div class="labels">
            glykol (%)<br/>
            Propylenglykol<br/>
            Etylenglykol
          </div>
          <div class="inputs">
            <input type="text" name="glykol" value="0" id="glykol" /><br/>
            <input type="radio" name="glykoltype" id="propylen" checked /><br/>
            <input type="radio" name="glykoltype" id="etylen" />
          </div>
        </div>
      </fieldset>
    </form>
    <div class="clear"></div>

    <input type="hidden" value="<?php echo $_GET["debug"]; ?>" id="debug"/>
    <input type="submit" value="Beräkna expansionskärl" id="calc" style="width:auto;"/>
    <div id="result"></div>

  </body>
</html>
