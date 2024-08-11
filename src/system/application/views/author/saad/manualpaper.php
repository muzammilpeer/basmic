<?php
$site="http://localhost/basmic/system/application/views/author/saad/";
include("db.php");
include("stars.php");
db_connection();
///////////////////////////////////////////////////////////////////////////////////
function listconferences($email,$opt)
{
	$query="SELECT c.confid as con,fulltitle,passinggrade as PassingGrade,startdate,enddate  FROM conference c inner join attendee a on (c.confid=a.confid && a.usrid=12 && (c.startdate > NOW() OR c.enddate > NOW()));";
	$result = mysql_query($query);
	echo'<table border="1" style="width: auto"  class="style2" id="mytable">
		<tr>
			<th>Conference Name</th>
	   		<th>Passing Grade</th>
	   		<th>Start Date</th>
	   		<th>End Date</th>
		</tr>';	

	while($row = mysql_fetch_array($result))
	{
	$r=$row['con'];
	echo'<tr id="'.$row['con'].'">
			<td ><a href="#" onclick="ShowPapers('.$r.','.$opt.')">'.$row['fulltitle'].'</td>
			<td ><center>'.$row['PassingGrade'].'</center></td>
			<td >'.$row['startdate'].'</td>
			<td >'.$row['enddate'].'</td>
		</tr>';
	}
	echo '</table> <div id="detail"></div>';
}

///////////////////////////////////////////////////////////////////////////////////
function ListPapers($confid,$opts)
{	
	/*if ($opts=="1")
	{
	$query="SELECT paperid,abstract,typeofpaper,rating,accept FROM paper p where (p.status=1 && p.confid=".$confid.");";
	$result = mysql_query($query);

	echo'<br><table border="1" style="width: auto"  class="style2" id="mytable">
		<tr>
			<th>Paper</th>
	   		<th>Category</th>
	   		<th>Rating</th>
	   		<th>Accept/Reject</th>
		</tr>';

	while($row = mysql_fetch_array($result))
	{
	echo '<input type="hidden" name="paperid" value="'.$row['paperid'].'">';
	echo'<tr id="'.$row['paperid'].'">
	<td ><a href="#" onclick="ShowPapers('.$row['paperid'].')">'.$row['abstract'].'</td>
	<td >'.$row['typeofpaper'].'</td>
 	<td >'.star($row['rating']).'</td>
 	<td ><select id="paperaccept" name="'.$row['paperid'].'" onchange="ManualAccept(this.value,this.name)">';
				if ($row['accept'] == 0 )
				{
				echo '<option selected="'.$row['accept'].'">Reject</option>';
				echo '<option>Accept</option>';
				} else {
				echo '<option selected="'.$row['accept'].'">Accept</option>';
				echo '<option>Reject</option>';
				}
	echo'</select></td>
		</tr>';
	}
	echo '</table><span id="statusbar">Status :</span>';
	} // if
	else if ($opts=="2")
	{
	$query="SELECT p.paperid,p.abstract,p.typeofpaper,p.rating,p.accept,u.firstname as author,u.lastname as alast,u1.firstname as reviewer,u1.lastname as rlast FROM paper p inner join user u on (p.authorid=u.usrid && p.confid='".$confid."') left join user u1 on (p.revid=u1.usrid);";
	$result = mysql_query($query);

	echo'<table style="width: auto"  class="style2" id="mytable">
		<tr>
			<th>Paper</th>
	   		<th>Author Name</th>
	   		<th>Reviewer Name</th>
	   		<th>Category</th>
	   		<th>Rating</th>
	   		<th>Accept/Reject</th>
		</tr>';
	
	while($row = mysql_fetch_array($result))
	{
	echo'<tr id="'.$row['paperid'].'">
	<td ><a href="#" onclick="ShowPapers('.$row['paperid'].')">'.$row['abstract'].'</td>
	<td >'.$row['author']." ".$row['alast'].'</td>
	<td >'.$row['reviewer']." ".$row['rlast'].'</td>
	<td >'.$row['typeofpaper'].'</td>
 	<td >'.star($row['rating']).'</td>
 	<td >'.$row['accept'].'</td>
 	</tr>';
	}
	} // else if 
	else if ($opts=="3")
	{
	echo "conf id new is ".$confid;
	$query="SELECT c.subdeadline,u1.firstname as rfirst,u1.lastname as rlast,r.revid as revids,r.current_load,r.paper_perweek  FROM paper p inner join conference c  on (c.confid=p.confid && c.confid='".$confid."') inner join reviewer r on (r.revid=p.revid) inner join user u1 on (p.revid=u1.usrid);";
	$results = mysql_query($query);

	echo'<table style="width: auto"  class="style2" id="detailstable">
		<tr>
			<th>Reviewer Name</th>
	   		<th>Paper Per Week to Review</th>
	   		<th>Current Paper Assigned for Reviewing</th>
	   		<th>Sub Dead Line to Reviewer</th>
		</tr>';
	
	while($row = mysql_fetch_array($results))
	{
	echo'<tr>
	<td><a href="#" onclick="Profile('.$row['revids'].')">'.$row['rfirst']." ".$row['rlast'].'</a></td>
	<td>'.$row['paper_perweek'].'</td>
	<td>'.$row['current_load'].'</td>
	<td>'.$row['subdeadline'].'</td></tr>';
	}
	echo "</table>";
	} // else if */

} // function ListPapers
///////////////////////////////////////////////////////////////////////////////////

function papermanagement($opt)
{
  if ($opt =="papercabinet")
   {
   echo '<span id="mainbody">	
<div id="mainmiddle" class="floatbox withoutright">												
	<div id="content">
		<div id="content_container" class="clearingfix">
			<div class="floatbox">
				<div class="componentheading">Paper Management[PaperCabinet]<br />
				</div>
				<a href="#" onclick="Conferences(2)" >List all Conferences</a> | <a href="#" onclick="Conferences(2)" >List all papers</a>
				<span id="processing">Processing</span>
			</div>
		</div>
	</div>
</div>							
</span>';

   } else if ($opt == "automation")
   {
   echo '<span id="mainbody">	
<div id="mainmiddle" class="floatbox withoutright">												
	<div id="content">
		<div id="content_container" class="clearingfix">
			<div class="floatbox">
				<div class="componentheading">Paper Management[Automation]<br />
				</div>
				Accept or Reject of Paper Process :
				<form method="post">
				<select name="Select1" id="optionselect">
				<option>Automatic</option>
				<option>Manual</option>
				</select>
				<input name="Button1" type="button" value="Apply" onclick="paperauto()"/></form>
				<span id="processing">Processing</span>
			</div>
		</div>
	</div>
</div>							
</span>';

	}
} // function papermanagement
/*//////////////////////////////////////////////////////////////////////////////////////*/
/*	    	Checks Here																	*/
/*//////////////////////////////////////////////////////////////////////////////////////*/

//if (isset($_GET['Listallconf']))
{
	/*$opt = $_GET['Listallconf'];
	$opt = 1;
	echo "opts ".$opt;
	listconferences($email,$opt);*/
}
///////////////////////////////////////////////////

if (isset($_GET['listpapers']))
{
	$confid=$_GET['listpapers'];
	$opt=$_GET['opt'];
	//echo "confid ".$confid;
	//echo "opts ".$opt;
	//ListPapers($confid,$opt);	
}
//////////////////////////////////////////////////////////////////////////
/*

 if ($cc==0)
 echo'No Paper Submitted Yet.';
 echo '</table>';
}*/

/////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['acceptorreject']))
{
	$acpt=$_GET['acceptorreject'];
	$id=$_GET['paperid'];
	$query="UPDATE paper SET accept = '".$acpt."' WHERE paperid =".$id.";";
	$result = mysql_query($query);
	$querys="select abstract from paper where paperid='".$id."'";
	$results = mysql_query($querys);
	$row = mysql_fetch_array($results);

	$status = "";
	if ( $acpt=="1")
	{$status="Accept";} 
	else {$status="Reject";} 
	echo "Status : \"".$row['abstract'] ."\" Changed to \"".$status."\" !";  
}

//////////////////////////////////////////////////////////////////////////////////////////
//if (isset($_GET['menubar']) == true && isset($_GET['optno']) == true)
{
	//$menubar = "papermanagement";	//$_GET['menubar'];
	//$opt = "automation";			//$_GET['optno'];
	
	/*if ( $menubar == "usermanagement")	{ }
	
	else  if ($menubar == "papermanagement")
	{	papermanagement($opt);	 } 
	
	else if ($menubar == "reviewermanagement")
	{
		if ($opt =="conferencereviewer")
		{	listconferences($email,"3");   } 
		else if ($opt == "automation")	{  } 
		else if ($opt == "deadline")	{  }
	}*/
}

// "papermanagement" "automation"

?>
