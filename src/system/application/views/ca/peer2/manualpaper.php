<?php
include("db.php");
include("stars.php");
db_connection();
///////////////////////////////////////////////////////////////////////////////////
function dateDiff($date1,$date2)
{
$dateDiff = $date1 - $date2;
$fullDays = floor($dateDiff/(60*60*24));
return $fullDays;
}

function ChangeCAToUser($usrid,$conf)
{
echo "usrid = $usrid conf = $conf";
$sql = "DELETE FROM cadmin WHERE (adminid = $usrid && confid=$conf)";
$result = mysql_query($sql);
 echo "Deleted";
}

function ChangeUserToCA($usrid,$conf)
{
$sql = "INSERT INTO cadmin VALUES ($usrid,$conf, NULL, NOW(), CURRENT_TIMESTAMP);";
$result = mysql_query($sql);
 echo "Updated";
}
function DropDown($role,$confid,$emails)
{
/*echo "email is ".$emails." confid ".$confid." role ".$role;*/
 $arr='<select name="rolechange" onchange="RoleChangeds(\''.$emails.'\',\''.$confid.'\',this.value)" ';
 $query="select grpname,grpid from groups where ( grpid=4 || grpid=1)";
 $result = mysql_query($query);
 while($row = mysql_fetch_array($result))
 {
 $select="";
  if ($row['grpname']==$role)
  {
   $select='selected="selected"';
  } else 
  {
  $select ="";
  }
  $arr.='<option  '.$select.' value="'.$row['grpid'].'">'.$row['grpname'].'</option>';
 }
 $arr.='</select>';
 return $arr;
}
//SELECT * FROM attendee a where (a.confid=2);   /* list all attende of that conference [attende+user] */
//SELECT * FROM attendee a inner join user u on(a.usrid=u.usrid && a.confid=2); /* list all users of that conference [unpriv+cadmin]*/
//SELECT * FROM attendee a inner join cadmin ca on (a.usrid=ca.adminid && a.confid=2) inner join user u on (a.usrid=u.usrid);

function ListUsers($confid)
{
 $query="SELECT * FROM attendee a where (a.confid=$confid)";
 $result = mysql_query($query);
 echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>User(s)</th>
	   		<th>Email Address</th>
	   		<th>Role of User</th>
	  </tr>';

 while($row = mysql_fetch_array($result))
 {
    $grp="";
	if ($row['usrid'] == NULL)
	{
	$grp="Attendee";
	} else 
	{
	$grp="Registered User";
	}
	echo'<tr id="">
	<td ><a href="#" onclick="">'.$row['firstname'].$row['lastname'].'</td>
	<td >'.$row['email'].'</td>
	<td >'.$grp.'</td>
 	</tr>';
 }
 echo '</table>Status :  <div id="Roles"></div>';

}
function ShowReviews($conf)
{
 $query="SELECT u.email,f.descp,u.firstname,u.lastname FROM feedback f inner join user u on (f.usrid=u.usrid) inner join conference c on (f.confid=c.confid && c.confid=".$conf."&& c.startdate < now() && c.enddate < now()) inner join user ch on (c.chairid=ch.usrid && ch.email='virtual_saad@live.com');";
 $result = mysql_query($query);
 echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>User(s)</th>
	   		<th>Feedback</th>
	  </tr>';

 while($row = mysql_fetch_array($result))
 {
	
	echo'<tr id="">
	<td ><a href="#" onclick="">'.$row['email'].'</td>
	<td >'.$row['descp'].'</td>
 	</tr>';
 }
 echo '</table> <div id="detail"></div>';
 
}
function ShowHistory($opt,$email)
{
 if ($opt==1)
 {
 $query="SELECT c.confid,datediff(now(),c.startdate)as remainday,c.shorttitle,c.fulltitle,c.startdate,c.enddate FROM conference c inner join cadmin ca on (c.confid=ca.confid) inner join user u on  (ca.adminid=u.usrid && c.startdate < now() && c.enddate < now() && u.email='".$email."');";
 $result = mysql_query($query);
 echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>Conference Short Title</th>
			<th>Conference Full Title</th>
	   		<th>Conference Start Dated</th>
	   		<th>Conference End Dated</th>
	   		<th>Some Day(s) Before</th>
	  </tr>';

 while($row = mysql_fetch_array($result))
 {
	echo'<tr id="'.$row['confid'].'">
	<td ><a href="#" onclick="">'.$row['shorttitle'].'</td>
	<td >'.$row['fulltitle'].'</td>
 	<td >'.$row['startdate'].'</td>
 	<td >'.$row['enddate'].'</td>
 	<td >'.$row['remainday'].' day(s)</td>
 	</tr>';
 }
 echo '</table> <div id="detail"></div>';

} else if ($opt==2)
{
 $query="SELECT r.email as revieweremail,au.email as authoremail,p.abstract,p.rating,p.accept,c.confid,datediff(now(),c.startdate)as remainday,c.shorttitle,c.fulltitle,c.startdate,c.enddate FROM conference c inner join cadmin ca on (c.confid=ca.confid) inner join user u on  (ca.adminid=u.usrid && c.startdate < now() && c.enddate < now() ) inner join paper p on (c.confid=p.confid && u.email='".$email."') inner join user r on (p.revid=r.usrid) inner join user au on (p.authorid=au.usrid);";
 $result = mysql_query($query);
 echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>Paper Abstract</th>
	   		<th>Author</th>
	   		<th>Reviewer</th>
			<th>Conference</th>
	   		<th>Rating</th>
	   		<th>Accepted/Rejeted [Paper]</th>
	  </tr>';

 while($row = mysql_fetch_array($result))
 {
	echo'<tr id="'.$row['confid'].'">
	<td ><a href="#" onclick="">'.$row['abstract'].'</td>
	<td >'.$row['authoremail'].'</td>
 	<td >'.$row['revieweremail'].'</td>
 	<td >'.$row['shorttitle'].'</td>
 	<td >'.star($row['rating']).'</td>
 	<td >'.check($row['accept']).'</td>
 	</tr>';
 }
 echo '</table> <div id="detail"></div>';

} 
}
function ShowDeadLine($email)
{
$query="select r.firstname as rfname,r.lastname as rlname,p.abstract as papername, c.shorttitle as conferencename ,r.email as remail,datediff(c.subdeadline,now()) as deadline from paper p inner join conference c on (p.confid=c.confid && c.enddate > now()  && c.subdeadline > now() ) inner join cadmin ca on (c.confid=ca.confid) inner join user ch on (ca.adminid=ch.usrid && ch.email='".$email."') inner join user r on (p.revid=r.usrid);";
$result = mysql_query($query);
echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>Reviewer Name</th>
			<th>Reviewer Email</th>
	   		<th>Paper Name</th>
	   		<th>Conference Name</th>
	   		<th>Remaining Days to Submit Review</th>
	  </tr>';

while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['conferencename'].'">
	<td ><a href="#" onclick="">'.$row['rfname'].$row['rlname'].'</td>
	<td >'.$row['remail'].'</td>
 	<td >'.$row['papername'].'</td>
 	<td >'.$row['conferencename'].'</td>
 	<td >'.$row['deadline'].' day(s)</td>
 	</tr>';
}
 echo '</table> <div id="detail"></div>';

}
function listconferences($email,$opt)
{

$query="SELECT c.confid as con,fulltitle,passinggrade as PassingGrade,startdate,enddate  FROM conference c inner join cadmin ca on (c.confid=ca.confid) inner join user u on (ca.adminid=u.usrid && u.email='".$email."' && (c.startdate > NOW() OR c.enddate > NOW())) ;";
$result = mysql_query($query);
echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>Conference Name</th>
	   		<th>Passing Grade[Minimum]</th>
	   		<th>Start Date</th>
	   		<th>End Date</th>
	  </tr>';

while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['con'].'">';
	echo '<td ><a href="#" onclick="ShowPapers('.$row['con'].','.$opt.')">'.$row['fulltitle'].'</td>';
    echo '<td >'.$row['PassingGrade'].'</td>
 	<td >'.$row['startdate'].'</td>
 	<td >'.$row['enddate'].'</td>
 	</tr>';
}
 echo '</table> ';
 if ($opt == "4")
 {
  echo '<span id="userlist" > 
  	    <input type="button" value="List All Attendee" onclick="UserManagement(1)" > 
  		<input type="button" value="List Registered User" onclick="UserManagement(2)" > 
  		</span>';
 }
 echo '<div id="detail"></div>';
}

function ListConf($email,$opt)
{

$query="SELECT c.confid as con,fulltitle,passinggrade as PassingGrade,startdate,enddate  FROM conference c inner join user u on (c.chairid=u.usrid && u.email='".$email."' && (c.startdate > NOW() OR c.enddate > NOW())) ;";
$result = mysql_query($query);
echo'<table style="width: auto"  class="style2" id="mytable">
	   <tr>
			<th>Conference Name</th>
	   		<th>Passing Grade[Minimum]</th>
	   		<th>Start Date</th>
	   		<th>End Date</th>
	  </tr>';

while($row = mysql_fetch_array($result))
{
	echo'<tr id="'.$row['con'].'">';
	echo '<td ><a href="#" onclick="ShowReview('.$row['con'].')">'.$row['fulltitle'].'</td>';
    echo '<td >'.$row['PassingGrade'].'</td>
 	<td >'.$row['startdate'].'</td>
 	<td >'.$row['enddate'].'</td>
 	</tr>';
}
 echo '</table> <div id="detail"></div>';
}


function ListPapers($confid,$opts)
{
if ($opts=="1")
{
$query="SELECT paperid,abstract,typeofpaper,rating,accept FROM paper p where (p.status=1 && p.confid=".$confid.");";
$result = mysql_query($query);

echo'<table style="width: auto"  class="style2" id="mytable">
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
} else if ($opts=="2")
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
 	<td >'.check($row['accept']).'</td>
 	</tr>';
}
} else if ($opts=="3")
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
} else if ($opt == 4 ) 
{
echo "Hello";
}

}
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
}
/*//////////////////////////////////////////////////////////////////////////////////////*/
/*	    	Checks Here																	*/
/*//////////////////////////////////////////////////////////////////////////////////////*/

if (isset($_GET['usremail']))
{
	if (isset($_GET['role']))
	{
		$emails=$_GET['usremail'];
		$role=$_GET['role'];
		$confs=$_GET['confno'];
		/* if usremail is of unpriv. then update it to ca. in this case add  user as a ca of conference in ca table....if from ca to unpr. then unpriv is like attende and is unpriv normally.*/
		if ($role==4)		{ChangeUserToCA($emails,$confs);} 
		else if ($role==1)	{ChangeCAToUser($emails,$confs);} 
	}
}

if(isset($_GET['ShowReview']))
{
	$conf = $_GET['ShowReview'];
	ShowReviews($conf); 
}

if (isset($_GET['Listallconf']))
{
	$opt = $_GET['Listallconf'];
	echo "opts ".$opt;
	listconferences($email,$opt);
}
///////////////////////////////////////////////////

if (isset($_GET['listpapers']))
{
	$confid=$_GET['listpapers'];
	$opt=$_GET['opt'];
	echo "confid ".$confid;
	echo "opts ".$opt;
	if ($opt=="4") ListUsers($confid);
	else ListPapers($confid,$opt);
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
if (isset($_GET['menubar']) == true && isset($_GET['optno']) == true)
{
$menubar = $_GET['menubar'];
$opt= $_GET['optno'];
 if ( $menubar == "usermanagement")
 {
	if ($opt=="user")
	{listconferences($email,"4");  echo "User Muzammil ";} 
	else if ($opt=="addca")
	{echo "Add CA ";} 
	else if ($opt=="closingconference")
	{echo "Closing Conf";} 
 }
 
 else if ($menubar == "papermanagement")
 {papermanagement($opt);} 
 
 else if ($menubar == "reviewermanagement")
 {
   if ($opt =="conferencereviewer")
   {listconferences($email,"3");} 
   else if ($opt == "automation")
   { } 
   else if ($opt == "deadline")
   {ShowDeadline($email);}
 } 
 
 else if ($menubar=="history")
 {
  if ($opt=="conference")
  {echo "conference"; ShowHistory("1",$email);} 
  else if ($opt=="paper")
  {echo "paper"; ShowHistory("2",$email);} 
  else if ($opt=="closingmessage")
  {echo "closing"; ListConf($email,"4");}
 }
}
?>