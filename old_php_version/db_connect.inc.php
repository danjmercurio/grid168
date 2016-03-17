<?php
error_reporting(0);

$user = 'u1219338_across';
$pass = 'WBls9bJjChw1JfvQ';
$db	= 'newnetworkschecker';

#$db	= 'i1055732_wp1';
#$db	= 'i1055732_wp1';
$user = 'u1219338_across';
$pass = 'WBls9bJjChw1JfvQ';

//$db_host = 'www.acrossplatforms.com';
//$db_host = '184.168.81.66';
$db_host = 'localhost';
//$db_host = 'www.michaelkokernak.info';
//$db_host = '23.229.131.101';
#echo " connecting";
$link = mysql_connect($db_host, $user, $pass) or die('Could not connect: ' . mysql_error());
mysql_select_db($db, $link) or die('Could not select database: ' . mysql_error());

?>