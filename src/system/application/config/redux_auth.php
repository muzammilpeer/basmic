<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*** Tables. **/
	$config['tables']['groups'] = 'groups';
	$config['tables']['users'] = 'user';
	$config['tables']['meta'] = 'meta';
	
	/*** Default group, use name */
	$config['default_group'] = 'unprivileged';
	 
	/*** Meta table column you want to join WITH.
	 * Joins from users.id	 **/
	$config['join'] = 'user_id';
	
	/*** Columns in your meta table, id not required. **/
	$config['columns'] = array('first_name', 'last_name');
	
	/*** A database column which is used to login with. **/
	$config['identity'] = 'email';

	/*** Email Activation for registration	 **/
	$config['email_activation'] = false;
	
	/*** Folder where email templates are stored.
     	 * Default : redux_auth/	 **/
	$config['email_templates'] = 'redux_auth/';

	/*** Salt Length **/
	$config['salt_length'] = 10;
	
?>
