<?php $base="http://localhost/basmic/"; ?>

<table width="500" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/User.png" alt="basmic" height="48" width="48"/></td>
    <td><h2><strong>Reviewer Management</strong></h2></td>
  </tr>
</table><br><br>

<br><br>
<table width="600" border="0">
  <tr>
    <td><center><a href="conf_rev">
	<img src="<?php echo $base; ?>images/Vista (308).png" width="128" height="128" alt="basmic" />
	</a></center></td>	
	<td><center><a href="deadline">
	<img src="<?php echo $base; ?>images/Vista (229).png" width="128" height="128" alt="basmic" />
	</a></center></td>
	<td><center><!--<a href="ar">-->
	<img src="<?php echo $base; ?>images/Automator.png" width="128" height="128" alt="basmic" />
	<!--</a>--></center></td>	
  </tr>
  <tr>
	<td><center>
	<?php echo anchor('ca/conf_rev', 'Conference Reviewers'); ?>
	</center></td>	
	<td><center>
	<?php echo anchor('ca/deadline', 'Deadline'); ?>
	</center></td>
	<td><center>
	<!--<?php echo anchor('ca/ar', 'Automation'); ?>-->Automation
	</center></td>	
  </tr>
</table>

<p>&nbsp;</p>

