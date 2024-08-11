<?php
include("db.php");
include("stars.php");
@include("download.php");
db_connection();

///////////////////////////////////////////////////////////////////////////////////
function dateDiff($date1,$date2)
{
	$dateDiff = $date1 - $date2;
	$fullDays = floor($dateDiff/(60*60*24));
	return $fullDays;
}

function ListPapers()
{
$query="SELECT p.paperid,p.abstract,c.subdeadline,p.pathfile FROM paper p inner join conference c on (p.confid=c.confid)  inner join reviewer r on (p.revid=r.revid) inner join user u on (p.revid=u.usrid && u.grpid=3 && u.email='hina@tareen.com' && (c.subdeadline > now() &&  c.enddate >  now()));";
$result = mysql_query($query);

echo'<table style="width: auto"  class="style2" id="mytable" border="1">
	   <tr>
			<th>Paper Name</th>
	   		<th>Deadline Date</th>
	   		<th>Download</th>
	  </tr>';
$count=0;
while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['paperid'].'">
	<td >'.$row['abstract'].'</td>
	<td >'.$row['subdeadline'].'</td>
 	<td ><a href="'.$row['pathfile'].'" > Download </td>
	</tr>';
	$count++;
}
echo '</table><span id="statusbar"></span>';
echo "<p> $count Assigned Paper Record(s) Found ! </p>";
}

function Rate($val,$papid)
{	
	$out=" ";
	$out.= '<select name="Select1" onchange="RateUpdate(this.value,'.$papid.')">';
	for ($i=0;$i<=10;$i++)
	{
		$select=" ";
		if ($val==$i) {$select='selected="selected"';}
		$out.='<option '.$select.'>'.$i.'</option>';
	}
	$out.='</select>';
	return $out;	
}

function RatePaper($email)
{
//$query="SELECT p.abstract,p.paperid,p.rating FROM paper p inner join reviewer r on (p.revid=r.revid) inner join user u  on (r.revid=u.usrid && u.email='hina@tareen.com');";
$query="SELECT p.abstract,p.paperid,p.rating FROM paper p inner join reviewer r on (p.revid=r.revid) inner join user u  on (r.revid=u.usrid && u.email='".$email."') inner join conference c on (p.confid=c.confid && c.subdeadline > now() && c.enddate > now());";

$result = mysql_query($query);

echo'<table style="width: auto"  class="style2" id="mytable" border="1">
	   <tr>
			<th>Paper Name</th>
	   		<th>Rate</th>
	  </tr>';
$count=0;
while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['paperid'].'">
	<td >'.$row['abstract'].'</td>
	<td >'.Rate($row['rating'],$row['paperid']).'</td>
	</tr>';
	$count++;
}
echo '</table><span id="statusbar"></span>';
echo "<p> $count Paper Record(s) Found ! </p>";
//echo "<br>This is rate paper!";
}

function History()
{
$query="SELECT p.abstract,c.subdeadline,p.pathfile,p.paperid,p.rating FROM paper p inner join conference c on (p.confid=c.confid)  inner join reviewer r on (p.revid=r.revid) inner join user u on (p.revid=u.usrid && u.grpid=3 && u.email='hina@tareen.com' && (c.subdeadline < now() &&  c.enddate <  now()));";
$result = mysql_query($query);

echo'<table style="width: auto"  class="style2" id="mytable" border="1">
	   <tr>
			<th>Paper Name</th>
	   		<th>Deadline of Paper</th>
	   		<th>Rate</th>
	   		<th>Download Old Paper</th>
	  </tr>';
$count=0;

while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['paperid'].'">
	<td >'.$row['subdeadline'].'</td>
	<td >'.star($row['rating']).'</td>
	<td ><a href="'.$row['pathfile'].'" > Download</a></td>
	</tr>';
	$count++;
}
echo '</table><span id="statusbar"></span>';
echo "<p> $count History Record(s) Found ! </p>";
}

/////////////////////////////////////////////////////////////////
function UpdateRate($rate,$paper)
{
	$query = "UPDATE  paper SET  rating =  '".$rate."' WHERE  paperid =".$paper." ;";
	$result = mysql_query($query);
	echo "Updated";
	
	//Get confid of the rated paper
	$query = "SELECT `confid` FROM `paper` WHERE paperid=".$paper.";";
	$result = mysql_query($query);
	list($confid)= mysql_fetch_row($result);
	
	//Get chairid of the conference in which paper is submitted
	$query = "SELECT chairid FROM conference WHERE confid=".$confid.";";
	$result = mysql_query($query);
	list($chairid)= mysql_fetch_row($result);
	
	//Get status of automation
	$query = "SELECT auto FROM user WHERE usrid=".$chairid.";";
	$result = mysql_query($query);
	list($auto)= mysql_fetch_row($result);
	
	//If Automation is enabled than do Paper Automation
	if ($auto)
	{
	$query = "select * from paper p inner join conference c on (p.rating >= 7 && p.confid=c.confid && p.status = c.status = 1)";
	$arr = mysql_query($query);

	//Fetching those papers who are in this conference and have status '1' and their rating is >7..
	while($res = mysql_fetch_array($arr))
	{mysql_query("update paper SET accept=1 where paperid=$res[paperid]");}
	}
}

///////////////////////////////////////////////////////////////////////////////////
/*//////////////////////////////////////////////////////////////////////////////////////*/
/*	    	Checks Here																	*/
/*//////////////////////////////////////////////////////////////////////////////////////*/

if (isset($_GET['ListPaper']))
{
	$check = $_GET['ListPaper'];
	if ($check==true)	{ListPapers();}
} 
else if (isset($_GET['RatePaper']))
{
	$check = $_GET['RatePaper'];
	if ($check==true)	{RatePaper();}
} 
else if (//isset($_GET['check'])==true && 
		 isset($_GET['rating'])== true && 
		 isset($_GET['paper']) == true)
{
	$rate=$_GET['rating'];
	$paper=$_GET['paper'];
	UpdateRate($rate,$paper);
} 
else if (isset($_GET['History']))
{
	$check = $_GET['History'];
	if ($check==true)
	{History();}
} 

?>
