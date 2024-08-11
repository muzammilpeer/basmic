<?php $base="http://localhost/basmic/"; ?>

<table width="500" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (114).png" alt="basmic" /></td>
    <td><h2><strong>Paper Management</strong></h2></td>
  </tr>
</table><br><br>

<br><br>
<table width="600" border="0">
  <tr>
    <td><center><a href="cabinet">
	<img src="<?php echo $base; ?>images/Vista (48).png" width="128" height="128" alt="basmic" />
	</a></center></td>	
	<td><center><a href="ar_paper">
	<img src="<?php echo $base; ?>images/Vista (137).png" width="128" height="128" alt="basmic" />
	</a></center></td>
	<?php
	if ($auto==0) { ?>
	<td><center><a href="ar">
	<img src="<?php echo $base; ?>images/Vista (265).png" width="128" height="128" alt="basmic" />
	</a></center></td>
	<?php } ?>
  </tr>
  <tr>
	<td><center>
	<?php echo anchor('chair/cabinet', 'Paper Cabinet'); ?>
	</center></td>	
	<td><center>
	<?php echo anchor('chair/ar_paper', 'Accept/Reject Papers'); ?>
	</center></td>
	<?php
	if ($auto==0) { ?>
	<td><center>
	<?php echo anchor('chair/ar', 'Manually Accept/Reject'); ?>	
	</center></td>
	<?php } ?>
  </tr>
</table>

<p>&nbsp;</p>

