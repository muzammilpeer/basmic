<h2>Register</h2>
<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>
<?php echo form_open('rev/register'); ?>
<table>
<tr><td>

<table>   
    <tbody>     
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
	            	echo form_dropdown('title', $t); ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>First Name</td>
            <td><?php echo form_input('first_name', set_value('first_name')); ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>Last Name</td>
            <td><?php echo form_input('last_name', set_value('last_name')); ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php 
            	$g = array (
            		'Male'  => 'Male',
                  	'Female'=> 'Female'
            		   );
            	echo form_dropdown('gender', $g); ?></td>
        </tr>
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
	            	echo form_dropdown('coc', $coc); ?></td>
        </tr>
        <!--<tr>
            <td>Affiliation</td>
            <td><?php echo form_input('aff', set_value('aff')); ?></td>
        </tr>-->
        <tr>
            <td>Job Position</td>
            <td><?php echo form_input('jobtitle', set_value('jobtitle')); ?></td>
        </tr>
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
            	echo form_checkbox($data);
            	echo "Delegate";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'exhibitor',
    				'value'       => 'exhibitor',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
            	echo form_checkbox($data);
            	echo "Exhibitor";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'sponsor',
    				'value'       => 'sponsor',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
            	echo form_checkbox($data);
            	echo "Sponsor";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'student',
    				'value'       => 'student',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
            	echo form_checkbox($data);
            	echo "Student";
            	$data = array(
    				'name'        => 'participanttype',
    				'id'          => 'organizer',
    				'value'       => 'organizer',
    				'checked'     =>  FALSE,
    				'style'       => 'margin:10px',
    			     );
            	echo form_checkbox($data);
            	echo "Organizer";
            	?>
            </td>
        </tr>
         <tr>
            <td><font color="#873A4E">*</font>Email</td>
            <td><?php echo form_input('email', set_value('email')); ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>Password</td>
            <td><?php echo form_password('password'); ?></td>
        </tr>          
     </tbody>
</table>

</td>

<td> 
</td>

<td>

<table>   
    <tbody>
    	<tr>
            <td>Telephone</td>
            <td><?php echo form_input('telephone', set_value('telephone')); ?></td>
        </tr>
        <tr>
            <td>Mobile No.</td>
            <td><?php echo form_input('mob', set_value('mob')); ?></td>
        </tr>
        <tr>
            <td>FAX</td>
            <td><?php echo form_input('fax', set_value('fax')); ?></td>
        </tr>      
        <tr>
            <td><font color="#873A4E">*</font>Street</td>
            <td><?php echo form_input('street', set_value('street')); ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>Post code</td>
            <td><?php echo form_input('pc', set_value('pc')); ?></td>
        </tr>
        <tr>
            <td>Town</td>
            <td><?php echo form_input('town', set_value('town')); ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>City</td>
            <td><?php echo form_input('city', set_value('city')); ?></td>
        </tr>
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
            	echo form_dropdown('country', $country); ?></td>
        </tr>
        <tr>
            <td>Message</td>
            <td><?php
            	$msg = array(
              		'name'  => 'message',
              		//'id'  => 'username',
              		'value' => 'Your Message',
              		'rows'  => '2',
             		'cols'  => '50',
              		'style' => 'width:74%',
            		    );
            	echo form_textarea($msg); 
            	?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Enter letters below</td>
        </tr>
        <tr>
            <td><a href="javascript:location.reload(true)" title="Refresh Captcha">
            	<img src="http://localhost/basmic/images/wait.png" alt="Refresh"></a></td>
            <td><?php echo $cap_img; ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo form_input('captcha', set_value('captcha')); ?></td>
        </tr>
        
    </tbody>
    <!--<tfoot>
        <tr><td colspan="2"><center></center></td></tr>
    </tfoot>-->
</table>

</td></tr>
</table>
<center><?php echo form_submit('submit', ' Register '); ?></center>
<?php echo form_close(''); ?>

