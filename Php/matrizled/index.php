<!DOCTYPE html>
<html>
<!--
*******************************************************************************
*                                                                             *
*   Interface para desenho na matriz 8x8 do Arduino                           *
*                                                                             *
*    Versão: 1.0                                                              *
*    Data: 01/11/2013                                                         *
*    Autor: Alex Ishida                                                       *
*    Site: http://alexishida.com                                              *
*    E-mail: alexishida@gmail.com                                             *
*                                                                             *
*******************************************************************************
-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>Matriz Led 8x8 by Alex Ishida</title>
        <link rel="stylesheet" href="css/estilo.css?cache=<?= time(); ?>" />
        <script type="text/javascript" src="js/jquery.js"></script>

        <script type="text/javascript">
            var led;
            var dados = "";
            $(document).ready(function() {
                
                /* Cria a matriz do desenho */
                led = criandoMatrix();
            });

            /* Preeche os dados com valor 0 para desligado e 1 para ligado */
            function alterar(x, y) {

                if (led[x][y] == "0") {
                    $("#" + x + "-" + y).removeClass("off");
                    $("#" + x + "-" + y).addClass("on");
                    led[x][y] = "1";
                }
                else {
                    $("#" + x + "-" + y).removeClass("on");
                    $("#" + x + "-" + y).addClass("off");
                    led[x][y] = "0";
                }
                
                /* Gera os dados da string de envio */
                 gerarDados();

            }
            
            /* Coloca todo os leds como desligado */
            function zerarMatriz() {

                for (x = 0; x <= 7; x++) {
                    for (y = 0; y <= 7; y++) {

                        led[x][y] = "0";
                    }
                }

            }


            /* Cria a matriz bidimensional de 8x8 com os dados inicais 0 */
            function criandoMatrix() {

                var arr = [];


                for (var i = 0; i < 8; i++) {


                    arr.push([]);


                    arr[i].push(new Array(8));

                    for (var j = 0; j < 8; j++) {

                        arr[i][j] = "0";
                    }
                }

                return arr;
            }
            
            /* Pega os dados da matriz e preenche na string de envio */
            function gerarDados() {
                dados = "";
                 for (x = 0; x <= 7; x++) {
                    for (y = 0; y <= 7; y++) {

                        dados = dados + led[x][y];
                    }
                }
                
                
            }
            
            
            /* Envia os dados via ajax usando a função load do jquery */
            function enviarDados() {
                
              $("#btnEnviar").attr("disabled", "disabled"); 
              $("#btnEnviar").val("Enviando.. Aguarde..."); 
              $( "#retorno_ajax" ).load( "enviar.php?dados="+dados, function() {
                $("#btnEnviar").val("Enviar"); 
                $("#btnEnviar").removeAttr("disabled");
              });

            }
            

        </script>
    </head>
    <body>
        <h1>Matriz Led 8x8 by Alex Ishida</h1>
        <div class="matrizLed">  
            <? for ($x = 0; $x <= 7; $x++) { ?>
                <div class="linha">
                    <? for ($y = 0; $y <= 7; $y++) { ?>
                        <div id="<?= $x ?>-<?= $y ?>" class="led off" onclick="javascript:alterar(<?= $x ?>,<?= $y ?>);"></div>
                    <? } ?>
                </div>
            <? } ?>  
        </div>
        <p style="text-align: center;"><input id="btnEnviar" name="btnEnviar" class="botao" type="button" value="Enviar" onclick="javascript:enviarDados();"></p>
        <p style="text-align: center;"><input id="btnResetar" name="btnResetar" class="botao" type="button" value="Resetar Dados" onclick="javascript:document.location.reload();"></p>
        <div id="retorno_ajax" style="display:none;"></div>
        
        <br>
    </body>
</html>
