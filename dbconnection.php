<?php
session_start();

error_reporting(0);
ob_start();

/*
function connection_error()
{
    mail("webmaster@competeonline.com", "DBMS CONNECTION ERROR", "This is an automated response to the failure of database conectivity..Please sort the problem out..");
    return mysql_error();
}
*/

$serverName = "127.0.0.1";
$dbUsername = "root";
$dbPassword = "";
$dbName = "fest";
$connection=mysql_connect($serverName,$dbUsername,$dbPassword) or die(mysql_error());
mysql_select_db($dbName,$connection);
/*
if(isset($_SESSION['op_name']))
{
    echo '<div style="position: fixed; background: url('."'_img/black.png'".') repeat; bottom:3px; left: 3px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as '.$_SESSION['op_name'].'&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>';
}
else
{
    echo '<div style="position: fixed; background: url('."'_img/black.png'".') repeat; bottom:3px; left: 3px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>';
}
*/

?>
