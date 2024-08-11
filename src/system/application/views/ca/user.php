<?php $base="http://localhost/basmic/"; ?>

<table width="500" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (299).png" alt="basmic" /></td>
    <td><h2><strong>User Management</strong></h2></td>
  </tr>
</table><br><br>

<br><br>
<table width="600" border="0">
  <tr>
    <td><center><a href="users">
	<img src="<?php echo $base; ?>images/Vista (61).png" width="128" height="128" alt="basmic" />
	</a></center></td>	
	<td><center><!--<a href="ar_paper">-->
	<img src="<?php echo $base; ?>images/Vista (40).png" width="128" height="128" alt="basmic" />
	<!--</a>--></center></td>
	<td><center><!--<a href="ar">-->
	<img src="<?php echo $base; ?>images/Vista (148).png" width="128" height="128" alt="basmic" />
	<!--</a>--></center></td>	
  </tr>
  <tr>
	<td><center>
	<?php echo anchor('ca/users', 'Users'); ?>
	</center></td>	
	<td><center>
	<!--<?php echo anchor('ca/ar_paper', 'Add Conference Administrator'); ?>-->
	Add Conference Administrator
	</center></td>
	<td><center>
	<!--<?php echo anchor('ca/ar', 'Close Conference'); ?>-->
	Close Conference
	</center></td>
  </tr>
</table>

<p>&nbsp;</p>

