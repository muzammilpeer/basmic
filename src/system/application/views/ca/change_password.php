<h2>Change Password</h2>
<?php echo form_open('ca/change_password'); ?>
<table>    
    <tbody>
        <tr>
            <td><font color="#873A4E">*</font>Old Password</td>
            <td><?php echo form_password('old', set_value('old')) ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>New Password</td>
            <td><?php echo form_password('new', set_value('new')) ?></td>
        </tr>
        <tr>
            <td><font color="#873A4E">*</font>Repeat New Password</td>
            <td><?php echo form_password('new_repeat', set_value('new_repeat')) ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', ' Change Password '); ?></td>
        </tr>
    </tfoot>
</table>
<?php echo form_close(); ?>
