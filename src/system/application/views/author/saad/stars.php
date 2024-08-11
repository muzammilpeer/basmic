<?php

function emptys()
{
 $r = "<img src='";
 $r .= "http://localhost/fastcoms/";
 $r .= "images/empty.gif' width='20' height='20' />";
 return $r;
}

function half()
{
 $r = "<img src='";
 $r .= "http://localhost/fastcoms/";
 $r .= "images/half.gif' width='20' height='20' />";
 return $r;
}

function full($c)
{
$img = null;
 for ($i=0;$i<$c;$i++)
 {
  $r = "<img src='";
  $r .= "http://localhost/fastcoms/";
  $r .= "images/full.gif' width='20' height='20' />";
  $img.=  $r;
 }
 return $img;
}

function star($value)
{
 $count = $value/2;
if ($value % 2 == 0)
{ return full($count); } 
else 
{
if ($value > 0) {
$imgs = null;
 $imgs .= full($count-1);
 $imgs .= half();
 return $imgs;
 }
}
 if($value <= 0)
 { return emptys(); }
}
//stars($_GET['val']);
/*for ($i=0;$i<=10;$i++)
 {
       echo "<p>".star($i)."</p>"; 
 }*/
?>
