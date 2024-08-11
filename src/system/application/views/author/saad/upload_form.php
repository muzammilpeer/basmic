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

<?php $base="http://localhost/basmic/"; ?>
<table width="600" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (114).png" alt="basmic" /></td>
    <td><h2><strong>Submit Paper to Conference</strong></h2></td>
  </tr>
</table><br>

<?php echo $error;?>
<?php echo form_open_multipart('author/do_upload');?>

<table>
	<tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>Conference:</td>
		<td><?php echo form_dropdown('confid', $con); ?>		
		</td>
	</tr>
	<tr>
		<td valign="top" class="leftcol">Abstract:</td>
		<td><textarea rows="6" cols="44" name="abstract"></textarea></td>
	</tr>
	<tr>
		<td valign="top" class="leftcol"><font color="#873A4E">*</font>Paper File: </td>
		<td><input type="file" name="userfile" size="30" /></td>
	</tr>
	<tr><td valign="top" class="leftcol">Paper Type:</td>
		<td><input type "text" name="type" size="40" /></td>
	</tr>
	<tr><td valign="top" class="leftcol">Keywords:</td>
		<td><input type "text" name="keywords" size="40" /></td>
	</tr>
	<tr><td align="center" colspan="2"><br>
		<?php //echo form_hidden('authorid',$authorid); ?>
		<?php echo form_submit('submit', ' Submit Conference Paper '); ?>
	</tr>	
</table>

<?php echo form_close(''); ?>
