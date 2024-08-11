<?php $base="http://localhost/basmic/"; ?>

<table width="300" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (132).png" alt="basmic" width="48" height="48"/></td>
    <td><h2><strong>My Papers</strong></h2></td>
  </tr>
</table>

<?php										
//////////////////////////////////////dbcode//////////////////////////////////////
//echo "auto:".$auto;
echo "<br><b>Note:</b> Don't worry, by default papers are rejected.";

$con = mysql_connect("localhost","root","saad");
if (!$con)  {die('Could not connect: ' . mysql_error());}
else
{
	mysql_select_db("basmic", $con);
	$result = mysql_query("select * from paper where authorid = ".$auto);

	if (!$result) {echo "<br>Sorry, till now you don't have submitted any papers!";}
	else
	{
	$n=1;
	while($row = mysql_fetch_array($result)) 
	{
		echo  "<center>Paper:".$n."</center><table border='1'>";
		//echo  "<table border='1'><tr><td>Paper id: </td><td>".$row['paperid']."</td></tr>";
	    //echo  "<tr><td>Reviewer: </td><td>".$row['revid']."</td></tr>";
		echo  "<tr><td width='140'>Abstract: </td><td>".$row['abstract']."</td></tr>";
		//echo  "<tr><td>File Path: </td><td>".$row['pathfile']."</td></tr>";
		echo  "<tr><td>Paper Type: </td><td>".$row['typeofpaper']."</td></tr>";
		echo  "<tr><td>Keywords: </td><td>".$row['keywords']."</td></tr>";
		echo  "<tr><td>Paper Status: </td><td>";
		if ($row['accept'] == 1)	{echo  "Accepted"."</td></tr>";}
		else	{echo "Rejected"."</td></tr>";}
		echo "<tr><td>Paper Create time: </td><td>". $row['createtime']."</td></tr></table>";
		echo "<br>";
		$n++;	
	} // while	
	} // else
}
///////////////////////db code////////////////////////////////////////////////
?>  


<p>&nbsp;</p>

