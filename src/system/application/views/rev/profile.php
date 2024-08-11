<h2>Your Profile</h2>
<?php 
$base_url = "http://localhost/basmic/";

echo "<table><td width='400'>";

echo "<table border='0'>";
$i = 3;
foreach ($profile as $value => $list)
{
  //if ($i == 1)  	{echo "<tr><td>User ID: </td><td>".$list."</td></tr>"; $i+=1;}
  //else if ($i == 2)     {echo "<tr><td>Group ID: </td><td>".$list."</td></tr>"; $i+=1;}
  /*else*/ if ($i == 3) {echo "<tr><td width='120'>Name: </td><td>"./*"Title: : ".*/$list." "; $i+=1;}
  else if ($i == 4)     {echo "<!--<tr><td width='120'><Name: ></td><td>-->".$list." "; $i+=1;}
  else if ($i == 5)     {echo $list."<br>"; $i+=1;}
  else if ($i == 6)     {echo "<tr><td>Email: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 7)     {echo "<tr><td>Gender: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 8)     
  {
	  if ($list=='AA')  {echo "<tr><td>Citizenship: </td><td>"."Afghanistan"."</td></tr>";}
	  else if ($list=='BD')  {echo "<tr><td>Citizenship: </td><td>"."Bangladesh"."</td></tr>";}
	  else if ($list=='IN')  {echo "<tr><td>Citizenship: </td><td>"."India"."</td></tr>";}
	  else if ($list=='IR')  {echo "<tr><td>Citizenship: </td><td>"."Iran"."</td></tr>";}
	  else if ($list=='CN')  {echo "<tr><td>Citizenship: </td><td>"."China"."</td></tr>";}
	  else if ($list=='PK')  {echo "<tr><td>Citizenship: </td><td>"."Pakistan"."</td></tr>";}
	  else if ($list=='PE')  {echo "<tr><td>Citizenship: </td><td>"."Peru"."</td></tr>";}
	  else if ($list=='SA')  {echo "<tr><td>Citizenship: </td><td>"."Saudi Arabia"."</td></tr>";}
	  else if ($list=='LK')  {echo "<tr><td>Citizenship: </td><td>"."Sri Lanka"."</td></tr>";}
	  $i+=1;
  }
  //else if ($i == 9)    {if ($list) echo "<tr><td>Affiliation: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 9)     {if ($list) echo "<tr><td>Job Title: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 10)    {echo "<tr><td>Participant Type: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 11)    {if ($list) echo "<tr><td>Telephone: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 12)    {if ($list) echo "<tr><td>Mobile No: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 13)    {if ($list) echo "<tr><td>FAX: </td><td>".$list."</td></tr>"; $i+=1;}  
  else if ($i == 14)    {echo "<tr><td>Street: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 15)    {echo "<tr><td>Postal Code: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 16)    {if ($list) echo "<tr><td>Town: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 17)    {echo "<tr><td>City: </td><td>".$list."</td></tr>"; $i+=1;}
  else if ($i == 18)    
  {
	  if ($list=='AA')  {echo "<tr><td>Country: </td><td>"."Afghanistan"."</td></tr>";}
	  else if ($list=='BD')  {echo "<tr><td>Country: </td><td>"."Bangladesh"."</td></tr>";}
	  else if ($list=='IN')  {echo "<tr><td>Country: </td><td>"."India"."</td></tr>";}
	  else if ($list=='IR')  {echo "<tr><td>Country: </td><td>"."Iran"."</td></tr>";}
	  else if ($list=='CN')  {echo "<tr><td>Country: </td><td>"."China"."</td></tr>";}
	  else if ($list=='PK')  {echo "<tr><td>Country: </td><td>"."Pakistan"."</td></tr>";}
	  else if ($list=='PE')  {echo "<tr><td>Country: </td><td>"."Peru"."</td></tr>";}
	  else if ($list=='SA')  {echo "<tr><td>Country: </td><td>"."Saudi Arabia"."</td></tr>";}
	  else if ($list=='LK')  {echo "<tr><td>Country: </td><td>"."Sri Lanka"."</td></tr>";}
	  $i+=1;
  }
}
echo "</table>";

echo "</td><td>";

echo "<table border='0'>";
echo "<tr><td colspan='2'>"."<center><b>Profile Options</b></center>"."</td></tr>"; 
echo "<tr><td><img src='".$base_url."images/actions_lock.png'>"."</td>";
echo "<td><center>".anchor('rev/change_password', 'Change Password')."</center></td></tr>"; 
echo "<tr><td><img src='".$base_url."images/File edit.png'>"."</td>";
echo "<td><center>".anchor('rev/edit_profile', 'Edit Profile')."</center></td></tr>"; 
echo "</table>";

echo "</td></table>";

?>
