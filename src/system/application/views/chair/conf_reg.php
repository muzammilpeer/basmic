<div id="content">
	<div id="content_container" class="clearingfix">
	<div class="floatbox">
																				
		<div class="componentheading">Conference Regetration Form</div>
										
		<div class="container">
		<table width="100%" border="0"><tr>
  
		<!--<span class="hdr">Conference regetration form</span>-->		
		<?php echo form_open('chair/conf_reg'); ?>
		<!--<form action="process10.php" method="post" id="contactform">-->
		<input type="hidden" name="form" value="coms_demo_request">
		
			<table border="0">
			<tr><td colspan="2">
				Please fill out this form to activate your conferance. 
			</td></tr>
			<tr><td><br></td></tr>
			<tr><td valign="top" width="250"><font color="#873A4E">*</font>Short title:</td>
				<td><input type="text" name="shorttitle" size="40" /></td></tr>
			<tr><td valign="top"><font color="#873A4E">*</font>Full title :</td>
				<td><input type="text" name="fulltitle" size="40" /></td></tr>
			<tr><td valign="top"><font color="#873A4E">*</font>Start Date:</td>
				<td><input type="text" name="startdate" size="40" value="yy-mm-dd" /></td></tr>
		
			<tr><td valign="top" class="leftcol"><font color="#873A4E">*</font>End Date:</td>
				<td><input type="text" name="enddate" size="40" value="yy-mm-dd" /></td>
			</tr>
	
			<tr><td valign="top" colspan="2" class="contactformtext"><hr></td></tr>
	
			<tr><td valign="top" class="leftcol">Paper Submission Deadline:</td>
				<td><input type="text" name="deadline" size="40" value="yy-mm-dd" /></td>
			</tr>
			<tr><td valign="top" class="leftcol">Paper Passing Grade:</td>
				<td><input type="text" name="passinggrade" size="40" value="5" /></td>
			</tr>
	
			<tr><td valign="top" colspan="2" class="contactformtext"><hr></td></tr>
	
			<tr><td valign="top"><font color="#873A4E">*</font>Town:</td>
				<td><input type="text" name="town" size="40" /></td>
			</tr>
			<tr><td valign="top"><font color="#873A4E">*</font>City:</td>
				<td><input type="text" name="city" size="40" /></td>
			</tr>
			<tr><td valign="top"><font color="#873A4E">*</font>Country:</td>
				<td><input type="text" name="country" size="40" /></td>
			</tr>
	
			<tr><td valign="top" colspan="2" class="contactformtext"><hr></td></tr>
	
			<tr><td valign="top">Short description of conference:</td>
				<td><textarea rows="6" cols="45" name="abstract"></textarea></td>
			</tr>
			<tr><td valign="top">Conference website:</td>
				<td><input type="text" name="URL" size="40" value="http://"/></td>
			</tr>
   
			<tr><td valign="top">How many participants are approximately expected at the event?:</td>
				<td><input type="text" name="participants" size="40" /></td>
			</tr>    
    
			<tr><td valign="top">Is the event an academic non-profit meeting?:</td>
				<td><select name="academic" >
					<option selected value="commercial"> No </option>
					<option  value="academic"> Yes </option>
				</select></td>
			</tr>
			<!--<tr><td valign="top" class="leftcol">Additional Message:</td>
					<td><textarea rows="6" cols="45" name="message"></textarea></td>
				</tr>-->	
			<tr><td align="center" colspan="2"><br>
				<!--<button type="submit">Submit Registeration Form</button>-->
				<?php echo form_submit('submit', ' Submit Registeration Form '); ?>
				</td>
			</tr>
		</table>
	<!--</form>-->
	<?php echo form_close(''); ?>
	</div></td>
</tr>
</table>

</div>
