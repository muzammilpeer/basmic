<?php
function db_connection()
{
$con = mysql_connect("localhost","root","saad");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("fastcoms_ali", $con);
}
?>
