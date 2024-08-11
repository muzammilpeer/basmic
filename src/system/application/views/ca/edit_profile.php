<h2>Edit Profile</h2>
<?php echo form_open_multipart('ca/edit_profile'); ?>
<table>
<tr><td>

<table>   
    <tbody>
<?php 
$i = 3;
foreach ($profile as $value => $list)
if ($i == 3) {
?>  
        <tr>
            <td>Title</td>
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
	            	echo form_dropdown('title', $t, $list); ?></td>
        </tr>
<?php 
$i+=1;} 
else if ($i == 4) {
?>
        <tr>
            <td><font color="#873A4E">*</font>First Name</td>
            <td><?php				
				$data = array('name'=>'first_name','id'=>'first_name','size'=>20, 'value' => $list); 
				echo form_input($data);
				?>
			</td>
        </tr>
<?php
$i+=1;}
else if ($i == 5) { 
?>
        <tr>
            <td><font color="#873A4E">*</font>Last Name</td>
            <td><?php
			$data = array('name'=>'last_name','id'=>'last_name','size'=>20, 'value' => $list);  
			echo form_input($data); 
			?>
		</td>
        </tr>
<?php
$i+=1;}
else if ($i == 6) { $i+=1; }
else if ($i == 7) {
?>
        <tr>
            <td>Gender</td>
            <td><?php 
            	$g = array (
            		'Male'  => 'Male',
                  	'Female'=> 'Female'
            		   );
            	echo form_dropdown('gender', $g, $list); ?></td>
        </tr>
<?php
$i+=1;}
else if ($i == 8) { 
?>
        <tr>
            <td>Citizenship</td> <!-- Citizenship -->
            <td><?php 
            	$coc = array (
            		'AA' => 'Afghanistan',
                  	'BD' => 'Bangladesh',
                  	'IN' => 'India',
                  	'IR' => 'Iran',
                  	'CN' => 'China',
                  	'PK' => 'Pakistan',
                  	'PE' => 'Peru',        
                  	'SA' => 'Saudi Arabia',
                  	'LK' => 'Sri Lanka'
            		   );
	            	echo form_dropdown('coc', $coc, $list);
					?>
				</td>
        </tr>
<?php
$i+=1;}
//else if ($i == 9) { 
	//if ($list) {

//} 
//$i+=1;}
else if ($i == 9) {
	//if ($list) {
?>
        <tr>
            <td>Job Position</td>
            <td><?php
			$data = array('name'=>'jobtitle','id'=>'jobtitle','size'=>20, 'value' => $list);
			echo form_input($data); 
			?>
		</td>
        </tr>
<?php
//} 
$i+=1;}
else if ($i == 10) { 
?>
        <tr>
            <td><font color="#873A4E">*</font>Type of participant</td>
            <td><?php			
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'delegate',
    				'value'       => 'delegate',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
				if ($list == 'delegate') {$data['checked'] = 'TRUE';}
            	echo form_checkbox($data);
            	echo "Delegate";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'exhibitor',
    				'value'       => 'exhibitor',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
				if ($list == 'exhibitor') {$data['checked'] = 'TRUE';}
            	echo form_checkbox($data);
            	echo "Exhibitor";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'sponsor',
    				'value'       => 'sponsor',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
				if ($list == 'sponsor') {$data['checked'] = 'TRUE';}
            	echo form_checkbox($data);
            	echo "Sponsor";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'student',
    				'value'       => 'student',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
				if ($list == 'student') {$data['checked'] = 'TRUE';}
            	echo form_checkbox($data);
            	echo "Student";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'organizer',
    				'value'       => 'organizer',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
				if ($list == 'organizer') {$data['checked'] = 'TRUE';}
            	echo form_checkbox($data);
            	echo "Organizer";
            	?>
            </td>
        </tr>
<?php
$i+=1;}
else if ($i == 11) {
?>         
     </tbody>
</table>

</td>

<td> 
</td>

<td>

<table>   
    <tbody>
<?php
//if ($list) {
?>
    	<tr>
            <td>Telephone</td>
            <td><?php 
			$data = array('name'=>'telephone','id'=>'telephone','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
//} 
$i+=1;} 
else if ($i == 12) {
	//if ($list) {
?>
        <tr>
            <td>Mobile No.</td>
            <td><?php 
			$data = array('name'=>'mob','id'=>'mob','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
//} 
$i+=1;}
else if ($i == 13) {
	//if ($list) {
?>
        <tr>
            <td>FAX</td>
            <td><?php 
			$data = array('name'=>'fax','id'=>'fax','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>  
<?php
//} 
$i+=1;}
else if ($i == 14) {
?>
        <tr>
            <td><font color="#873A4E">*</font>Street</td>
            <td><?php 
			$data = array('name'=>'street','id'=>'street','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
$i+=1;}
else if ($i == 15) {
?> 
        <tr>
            <td><font color="#873A4E">*</font>Post code</td>
            <td><?php 
			$data = array('name'=>'pc','id'=>'pc','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
$i+=1;}
else if ($i == 16) {
	//if ($list) {
?> 
        <tr>
            <td>Town</td>
            <td><?php 
			$data = array('name'=>'town','id'=>'town','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
//} 
$i+=1;}
else if ($i == 17) {
?> 
        <tr>
            <td><font color="#873A4E">*</font>City</td>
            <td><?php 
			$data = array('name'=>'city','id'=>'city','size'=>20, 'value' => $list);
			echo form_input($data); 
			?></td>
        </tr>
<?php
$i+=1;}
else if ($i == 18) {
?> 
        <tr>
            <td><font color="#873A4E">*</font>Country</td>
            <td><?php 
            	$country = array (
            			'AA' => 'Afghanistan',
                  		'BD' => 'Bangladesh',
                  		'IN' => 'India',
                  		'IR' => 'Iran',
                  		'CN' => 'China',
                  		'PK' => 'Pakistan',
                  		'PE' => 'Peru',        
                  		'SA' => 'Saudi Arabia',
                  		'LK' => 'Sri Lanka'
            		   	);
            	echo form_dropdown('country', $country, $list); ?></td>
        </tr>
<?php
$i+=1;}
else if ($i == 19) {
?> 
        <tr>
            <td>Message</td>
            <td><?php
            	$msg = array(
              		'name'  => 'message',
              		'id'    => 'message',
              		'value' => 'Your Message',
              		'rows'  => '2',
             		'cols'  => '50',
              		'style' => 'width:74%',
            		    );
				if ($list) {$msg['value'] = $list;}
            	echo form_textarea($msg); 
            	?>
            </td>
        </tr>
<?php
$i+=1;}
//else if ($i == 19) {
?>         
        
    </tbody>
    <!--<tfoot>
        <tr><td colspan="2"><center></center></td></tr>
    </tfoot>-->
</table>

</td></tr>
</table>
<center><?php echo form_submit('submit', ' Update Profile '); ?></center>
<?php echo form_close(''); ?>

