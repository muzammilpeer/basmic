<?php $base="http://localhost/basmic/"; ?>

<table width="500" border="0">
  <tr>
    <td><img src="<?php echo $base; ?>images/Vista (114).png" alt="fastcoms" /></td>
    <td><h2><strong>Accept/Reject Papers</strong></h2></td>
  </tr>
</table>

<?php echo form_open_multipart('chair/ar_paper'); ?>	
<br><br>

<table width="500" border="0">
  <tr><td><center>
  What is your paper accept/reject policy?<br><br>
  </center></td></tr>
  <tr>
    <td><center>
		<?php             	
				if ($auto==1) {$auto='auto';}
				else if ($auto==0) {$auto='manual';}				
				$t = array (
            		'auto'   => 'Accept/Reject Automatically',
                  	'manual' => 'Accept/Reject Manually'
            		   );
	            echo form_dropdown('policy', $t, $auto); 				
		?>
	</center></td>
	</tr>
	<tr><td><center><br><br>
		<?php echo form_submit('submit', ' Apply Changes '); ?>		
	</center></td>	
  </tr>
  <tr>
	<!--<td><center>Paper Cabinet</center></td>	
	<td><center>Accept/Reject Papers
	</center></td>-->
  </tr>
</table>
<?php echo form_close(''); ?>

<p>&nbsp;</p>

