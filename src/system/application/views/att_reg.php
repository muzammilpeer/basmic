<?php 
$x=1;
$c1=array();
$c2=array();
$x1=$x2=0;
foreach ($profile as $row)
		{
			if ($x%2==0)	{$c1[$x1]=$row; $x1++; $x++;}
			else {$c2[$x2]=$row; $x2++; $x++;}
		}
$con = array();
for ($i=0; $i<$x1; $i++)
{ $con[$c2[$i]]=$c1[$i]; }
?>

<div id="content">
<div id="content_container" class="clearingfix">
<div class="floatbox">
																				
<div class="componentheading">Attendee Registration Form</div>								
<div class="container">

<table width="100%">
<tr>
  
  <!--<span class="hdr">BASMIC Conference regetration form</span>-->  
  <?php echo form_open('home/att_reg'); ?>
  <!--<form action="process13.php" method="post" id="contactform">-->
  <input type="hidden" name="form" value="coms_demo_request">
  <input type="hidden" name="lang" value="en">
    <table id="contactform">
		Please fill out this form to reserve a seat in conference.</span> </td></tr>
    	<br /><br />
		
	<tr><td valign="top" class="leftcol">Title:</td>
		<td><?php 
            	$t = array (
            		'Mr'  => 'Mr.',
                  	'Mrs' => 'Mrs.',
                  	'Ms'  => 'Ms.',
                  	'Ing' => 'Ing.',
                  	'Dr'  => 'Dr.',
                  	'Prof'=> 'Prof.',
                  	'EP'  => 'Emeritus Prof.',
                  	'DM'  => 'Dr. Med.'
            		   );
	            	echo form_dropdown('title', $t); ?>
		</td>
	</tr>		
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>First Name:</td>
		<td><input type="text" name="fname" size="30" /></td>
	</tr>
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Last Name:</td>
		<td><input type="text" name="lname" size="30" value="" /></td>
	</tr>
		
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Email:</td>
		<td><input type="text" name="email" size="30" value="" /></td>
	</tr>
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Password:</td>
		<td><input type="password" name="password" size="30" /></td>
	</tr>
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Conference you want to attend:</td>
		<td><?php echo form_dropdown('confid', $con); ?>
		<!--<input type="text" name="confid" size="30" />-->
		</td>
	</tr>
    <tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Mobile number:</td>
		<td><input type "text" name="mobile" size="30" /></td>
	</tr>
    <tr><td valign="top" class="leftcol">Comments:</td>
		<td><textarea rows="6" cols="33" name="comment"></textarea></td>
	</tr>
    <tr><td align="center" colspan="2"><br>
		<!--<button type="submit">Submit Registeration Form</button>-->
		<?php echo form_submit('submit', ' Submit Registeration Form '); ?></td>
	</tr>
    </table>
  <!--</form>-->
  <?php echo form_close(''); ?>
</div>
	
</td>
</tr></table></div>

</div>

<?php 
/*$x=1;
foreach ($profile as $row)
		{
			if ($x%2==0)	{echo $row."<br>"; $x++;}
			else {$x++;}
		}*/
/*foreach ($c2 as $row)
{echo $row."<br>";}*/
?>
