<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js'></script>
    <title>beulco</title>

    <script type="text/javascript">
      //do the calculation
      $(function() {
        $("#calc").click(function() {
          var sysvolume = $("#sysvolume").val();
          var culvert = $("#culvert").val();
          var accumulator = $("#accumulator").val();
          var pst = $("#pst").val();
          var psak = $("#psak").val();
          var tmax = $("#tmax").val();
          var glykol = $("#glykol").val();
          var glykoltype = $("#glykoltype").val();
          var debug = $("#debug").val();
          
          if(glykol == ''){
            glykol = 0;
          }
          if(debug != ''){
            dataString = 'debug=1&';
          }

          var vs = parseInt(sysvolume) + parseInt(culvert) + parseInt(accumulator);
          var dataString = dataString + 'vs='+ vs + '&pst='+ pst + '&psak='+ psak + '&tmax='+ tmax + '&glykol=' + glykol + '&glykoltype=' + glykoltype;

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
        });
      });
    </script>

  </head>
  <body>
    Dimensionering av expansionskärl<br/>

    <div>
      Volym *
      Systemvolym (l)<input type="text" name="sysvolume" value="75" id="sysvolume"/><br/>
      Kulvert (l)<input type="text" name="culvert" value="20" id="culvert"/><br/>
      Ackumulator (l)<input type="text" name="accumulator" value="5" id="accumulator" />
    </div>

    <div>
      Glykol
      glykol (%)<input type="text" name="glykol" value="5" id="glykol" /><br/>
      <input type="radio" value="Propylenglykol" name="glykoltype" id="glykoltype" checked>Propylenglykol<br/>
      <input type="radio" value="Etylenglykol" name="glykoltype" id="glykoltype">Etylenglykol<br/>
    </div>

  Statisk höjd (m)<input type="text" name="pst" value="5" id="pst" /> &nbsp;</br>
  Säkerhetsventilens öppningstryck (bar)<input type="text" name="psak" value="2" id="psak" /> &nbsp;</br>
  Maximal vattentemperatur(grader C)<input type="text" name="tmax" value="2" id="tmax" /> &nbsp;</br>

  <input type="hidden" value="<?php echo $_GET["debug"]; ?>" id="debug"/>
  <input type="submit" value="Beräkna expansionskärl" id="calc"/>
  <div id="result"></div>

</body>
</html>
