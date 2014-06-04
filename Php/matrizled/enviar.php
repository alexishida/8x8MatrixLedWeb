<?php
/******************************************************************************
*                                                                             *
*    Enviando os dados via porta Serial para o Arduino                        *
*                                                                             *
*    Versão: 1.0                                                              *
*    Data: 01/11/2013                                                         *
*    Autor: Alex Ishida                                                       *
*    Site: http://alexishida.com                                              *
*    E-mail: alexishida@gmail.com                                             *
*                                                                             *
*******************************************************************************/

/* Obtem via get ou post a matriz do desenho */
$dados = $_REQUEST['dados'];

/* Se for Linux ou OSX utilizar esse codigo: $porta = '/dev/tty.XYZ'; */

/* Porta Windows */
$porta = 'COM3';

/* Configura os parametros da porta Serial */
exec("mode com3: BAUD=9600 PARITY=N data=8 stop=1 xon=off");

/* Abre a conexão */
$conexao = fopen($porta, 'w');

/* Aguarda a abertura da conexão */
sleep(3);

/* Manda os dados obtidos via GET/POST */
fwrite($conexao, $dados);

/* Aguarda o envio dos dados */
sleep(1);

/* Printa na tela a resposta do Arduino */
echo fgets($conexao);

/* Fecha a conexão */
fclose($conexao);

?>