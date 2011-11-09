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
          if(glykol == ''){
            glykol = 0;                     //glykol är inte ifyllt
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

          var vs = parseInt(sysvolume) + parseInt(culvert) + parseInt(accumulator);
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
        });
      });
    </script>

    <style type="text/css">
      .mandatory{color:red;}
      .box{padding:0 0 10px 10px;background-color:#e7e7e7;width:400px; float:left;}
      .alone{padding:10px;}
      input{width:40px;}
      .label{font-weight:bold;}
      .labels{width:215px; float:left;}
      .inputs{width:100px; float:left;}
      .clear{clear:both;}
      #debug{padding:10px;background-color:#e7e7e7;width:400px; float:left;}
      #result-text{padding:10px;width:400px; float:left;}
    </style>




  </head>
  <body>
    <h2>Dimensionering av expansionskärl</h2>

    <div class="box">
      <span class="label">Volym</span> <span class="mandatory">*</span> <br/>
      <div class="labels">
        Systemvolym (l)<br/>
        Kulvert (l)<br/>
        Ackumulator (l)
      </div>
      <div class="inputs">
        <input type="text" name="sysvolume" value="75" id="sysvolume"/><br/>
        <input type="text" name="culvert" value="20" id="culvert"/><br/>
        <input type="text" name="accumulator" value="5" id="accumulator" />
      </div>
    </div>
    <div class="clear"></div>

    <div class="alone">
      <div class="labels">Statisk höjd (m)<span class="mandatory">*</span> </div>
      <div class="inputs"><input type="text" name="pst" value="5" id="pst" /></div>
    </div>
    <div class="clear"></div>

    <div class="alone">
      <div class="labels">Säkerhetsventilens öppningstryck (bar)<span class="mandatory">*</span></div>
      <div class="inputs"><input type="text" name="psak" value="2" id="psak" /></div>
    </div>
    <div class="clear"></div>

    <div class="alone">
      <div class="labels">Maximal vattentemperatur(grader C)<span class="mandatory">*</span></div>
      <div class="inputs"><input type="text" name="tmax" value="2" id="tmax" /></div>
    </div>
    <div class="clear"></div>

    <div class="box">
      <span class="label">Glykol</span><br/>
      <div class="labels">
        glykol (%)<br/>
        Propylenglykol<br/>
        Etylenglykol
      </div>
      <div class="inputs">
        <input type="text" name="glykol" value="5" id="glykol" /><br/>
        <input type="radio" name="glykoltype" id="propylen" checked /><br/>
        <input type="radio" name="glykoltype" id="etylen" />
      </div>
    </div>
    <div class="clear"></div>

    <input type="hidden" value="<?php echo $_GET["debug"]; ?>" id="debug"/>
    <input type="submit" value="Beräkna expansionskärl" id="calc" style="width:auto;"/>
    <div id="result"></div>

  </body>
</html>
