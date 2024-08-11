<?php $base="http://localhost/basmic/"; ?>

<table width="600" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (132).png" alt="fastcoms" height="48" width="48"/></td>
    <td><h2><strong>History of Conferences & Papers</strong></h2></td>
  </tr>
</table><br><br>

<br><br>
<table width="600" border="0">
  <tr>
    <td><center><a href="h_conf">
	<img src="<?php echo $base; ?>images/Vista (16).png" width="128" height="128" alt="fastcoms" />
	</a></center></td>	
	<td><center><a href="h_paper">
	<img src="<?php echo $base; ?>images/Vista (161).png" width="128" height="128" alt="fastcoms" />
	</a></center></td>
	<td><center><a href="closing">
	<img src="<?php echo $base; ?>images/Vista (155).png" width="128" height="128" alt="fastcoms" />
	</a></center></td>	
  </tr>
  <tr>
	<td><center>
	<?php echo anchor('chair/h_conf', 'Conferences'); ?>
	</center></td>	
	<td><center>
	<?php echo anchor('chair/h_paper', 'Papers'); ?>
	</center></td>
	<td><center>
	<?php echo anchor('chair/closing', 'Closing Message'); ?>	
	</center></td>	
  </tr>
</table>

<p>&nbsp;</p>

