<h2>Forgotten Password</h2><?php $base_url="http://localhost/basmic/" ?>
<table><tr><td width="380">

<p>Please enter your details to reset your password.</p>
<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<?php echo form_open('author/forgotten_password'); ?>
<table border="0">    
    <tbody>
        <tr>
            <td width="100"><font color="#873A4E">*</font>Email Address</td>
            <td><?php echo form_input('email', set_value('email')); ?></td>			
        </tr>
		 <tr>
            <td width="100"><font color="#873A4E">*</font>First Name</td>
            <td><?php echo form_input('first_name', set_value('first_name')); ?></td>
        </tr>
		 <tr>
            <td width="100"><font color="#873A4E">*</font>Last Name</td>
            <td><?php echo form_input('last_name', set_value('last_name')); ?></td>
        </tr>
		 <tr>
            <td width="100"><font color="#873A4E">*</font>Gender</td>
            <td><?php 
            	$g = array (
            		'Male'  => 'Male',
                  	'Female'=> 'Female'
            		   );
            	echo form_dropdown('gender', $g); ?>
			</td>			
        </tr>
		<tr>
            <td width="100"><font color="#873A4E">*</font>Country</td>
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
            	echo form_dropdown('country', $country); ?>
			</td>
        </tr>
		<tr><td></td></tr>
		<tr>
		<td colspan="2"><center><?php echo form_submit('submit', '    Reset Password     '); ?></center></td>
		</tr>
    </tbody>    
</table><?php echo form_close(''); ?>

<!--
<?php echo form_open('welcome/forgotten_password_complete'); ?>
<table>   
    <tbody>
        <tr>
            <td width="100">Verification Code</td>
            <td><?php echo form_input('code', set_value('code')); ?></td>
			<td><?php echo form_submit('submit', ' Send New Password '); ?></td>
        </tr>
    </tbody>    
</table>
<?php echo form_close(''); ?>-->

</td><td>
<img src="<?php echo $base_url; ?>images/Finder.png">
</td></tr></table>
