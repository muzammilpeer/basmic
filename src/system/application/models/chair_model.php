<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class chair_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->config('redux_auth');
		$this->tables  = $this->config->item('tables');
		$this->columns = $this->config->item('columns');
	}
		
	public function hash_password($password = false)
	{
	    $salt_length = $this->config->item('salt_length');	    
	    if ($password === false)
	    {return false;}	    
		$salt = $this->salt();		
		$password = $salt . substr(sha1($salt . $password), 0, -$salt_length);		
		return $password;		
	}
	
	/**
	 * This function takes a password and validates it
     	 * against an entry in the users table.
	 * @return void
	 **/
	public function hash_password_db($identity = false, $password = false)
	{
	    $identity_column   = $this->config->item('identity');
	    $users_table       = $this->tables['users'];
	    $salt_length       = $this->config->item('salt_length');
	    
	    if ($identity === false || $password === false)
	    {return false;}
	    
	    $query  = $this->db->select('password')
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
            
        $result = $query->row();
        
		if ($query->num_rows() !== 1)
		{return false;}
	    
		$salt = substr($result->password, 0, $salt_length);
		$password = $salt . substr(sha1($salt . $password), 0, -$salt_length);
        
		return $password;
	}
	
	/**
	 * Generates a random salt value.
	 * @return void
	 **/
	public function salt()
	{
		return substr(md5(uniqid(rand(), true)), 0, $this->config->item('salt_length'));
	}
    	
	/**
	 * Identity check
	 * @return void
	 **/
	protected function identity_check($identity = false)
	{
	    $identity_column = $this->config->item('identity');
	    $users_table     = $this->tables['users'];
	    
	    if ($identity === false)
	    {  return false;   }
	    
	    $query = $this->db->select('usrid')
                           ->where($identity_column, $identity)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{	return true;	}
		
		return false;
	}	

	/**
	 * profile
	 * @return void
	 **/
	public function profile($identity = false)
	{
	    $users_table     = $this->tables['users'];
	    $groups_table    = $this->tables['groups'];	    
	    $identity_column = $this->config->item('identity');    
	    
	    if ($identity === false)
	    {return false;}
	    
		$this->db->select('title, firstname, lastname, email, gender, citizenship, affiliation, jobtitle, participanttype, telephone, mobilephone, fax, street, postalcode, town, city, country, message');		
		//$this->db->limit(1);
		$this->db->where('email',$identity);
		$i = $this->db->get('user');
		
		return ($i->num_rows > 0) ? $i->row() : false;
	}
	
	public function no_auto($identity = false)
	{
		/*$this->db->select('ursid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		
		$chairid = $result->usrid;
		$this->db->select('confid');
		$this->db->where('chairid',$chairid);
		$i = $this->db->get('conference');		
		$result = $i->row();
		
		$confid = $result->usrid;*/
		//$sql = "UPDATE `fastcoms_ali`.`conference` SET `auto` = '0' WHERE `conference`.`confid` = $confid LIMIT 1 ;";
		//$this->db->query($sql);
		$data = array('auto' => 0);
		$this->db->where('confid', 1);
		$this->db->update('conference', $data);
	}
	
	public function edit_profile($identity = false)
	{
		$t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		$data = array(
					'title' => $_POST['title'],
					'firstname' => $_POST['first_name'],
					'lastname' => $_POST['last_name'],
					'gender' => $_POST['gender'],
					'citizenship' => $_POST['coc'],
					'jobtitle' => $_POST['jobtitle'],
					'participanttype' => $_POST['participanttype'],
					'telephone' => $_POST['telephone'],
					'mobilephone' => $_POST['mob'],
					'fax' => $_POST['fax'],
					'affiliation' => $_POST['aff'],
					'street' => $_POST['street'],
					'postalcode' => $_POST['pc'],
					'town' => $_POST['town'],
					'city' => $_POST['city'],
					'country' => $_POST['country'],
					'message' => $_POST['message'],
					'updatetime' =>  $d	
					 );
		$this->db->where('email', $identity);
		$this->db->update('profile', $data);
		
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	/**
	 * Basic functionality
	 * 
	 * Register
	 * Login
	 */
	
	/**
	 * register
	 * @return void
	 **/
	public function register($password=false, $email=false)
	{
	    $users_table        = $this->tables['users'];	
	    $groups_table       = $this->tables['groups'];	    
	    $additional_columns = $this->config->item('columns');
	    
	    if ($password === false || $email === false)
	    { return false; }
	    
        	// Group ID
	    $query = $this->db->select('grpid')->where('name', $this->config->item('unprivileged'))->get($groups_table);
	    $result   = $query->row();
	    $grpid = $result->grpid;	          
	    
	    $password = $this->hash_password($password);
	    
	    $t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
        	// Users table.
	    $data = array( 
	    		  'grpid' => $grpid,
			  'password' => $password, 
			  'email'    => $email,			  		
			  'title' => $_POST['title'],
			  'firstname' => $_POST['first_name'],
			  'lastname' => $_POST['last_name'],
			  'gender' => $_POST['gender'],
			  'citizenship' => $_POST['coc'],
			  'jobtitle' => $_POST['jobtitle'],
			  'participanttype' => $_POST['participanttype'],
			  'telephone' => $_POST['telephone'],
			  'mobilephone' => $_POST['mob'],
			  'fax' => $_POST['fax'],
			  'affiliation' => $_POST['aff'],
			  'street' => $_POST['street'],
			  'postalcode' => $_POST['pc'],
			  'town' => $_POST['town'],
			  'city' => $_POST['city'],
			  'country' => $_POST['country'],
			  'message' => $_POST['message'],
			  'createtime' =>  $d
			 );			  
		  
	    $this->db->insert($users_table, $data);	            	   
		
	    return ($this->db->affected_rows() > 0) ? true : false;
	}	
	
	public function grp_id($identity = false)
	{
	    $users_table     = $this->tables['users'];
	    $groups_table    = $this->tables['groups'];	    
	    $identity_column = $this->config->item('identity');    
	    
	    if ($identity === false)
	    { return false; }
	    
		$this->db->select('grpid');		
		//$this->db->limit(1);
		$this->db->where('email',$identity);
		$i = $this->db->get('profile');
		$result = $i->row();
		
		return ($i->num_rows > 0) ? $result->grpid : false;
	}
	
	public function auto($identity = false)
	{
	    $users_table     = $this->tables['users'];
	    $groups_table    = $this->tables['groups'];	    
	    $identity_column = $this->config->item('identity');    
	    
	    if ($identity === false)
	    { return false; }
	    
		$this->db->select('usrid');		
		//$this->db->limit(1);
		$this->db->where('email',$identity);
		$i = $this->db->get('user');
		$result = $i->row();
		$chairid = $result->grpid;
		
		$this->db->select('auto');		
		//$this->db->limit(1);
		$this->db->where('chairid',$chairid);
		$i = $this->db->get('conference');
		$result = $i->row();
		
		return ($i->num_rows > 0) ? $result->auto : false;
	}
		
}
