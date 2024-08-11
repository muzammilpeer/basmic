<?php $base="http://localhost/basmic/"; ?>

<table width="600" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (114).png" alt="basmic" /></td>
    <td><h2><strong>Manually Accept/Reject Paper(s)</strong></h2></td>
  </tr>
</table><br><br>

<?php echo form_open_multipart('chair/ar'); ?>

<br><br>
<table border="1">
  <tr>
    <td width="150"><center><b>Conference Name</b></center></td>
	<td width="50"><center><b>Passing Grade</b></center></td>
	<td width="150"><center><b>Paper</b></center></td>
	<td width="100"><center><b>Category</b></center></td>
	<td width="100"><center><b>Accept/Reject</b></center></td>
  </tr>
  
<?php 
$i=0;
foreach ($conf as $h)
{

	if ($i==7) {echo "<tr>"; $i=0;}
	if ($i==0) {}
	else if ($i==3) {}
	else if ($i==6) 
	{
		if ($h==0) {/*echo "<td><center>"."Reject"."</center></td>";*/}
		else if ($h==1) {/*echo "<td><center>"."Accept"."</center></td>";*/}
		$t = array (
            		0 => 'Reject',
                  	1 => 'Accept'
				   );
		echo "<td><center>".form_dropdown('ar', $t, $h)."</center></td>";
	}
	else  	   {echo "<td><center>".$h."</center></td>";}
	if ($i==7) {echo "</tr>"; $i=0;}
	$i++;
	
} 
?>
</table>
<br><br>
<center><?php echo form_submit('submit', ' Update Changes '); ?></center>
<?php echo form_close(''); ?>
	
<p>&nbsp;</p>
