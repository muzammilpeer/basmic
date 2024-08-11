<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class redux_auth_model extends Model
{
	/*** Holds an array of tables used in
	 * @var string
	 **/
	public $tables = array();
	
	/*** activation code
	 * @var string
	 **/
	public $activation_code;
	
	/*** forgotten password key
	 * @var string
	 **/
	public $forgotten_password_code;
	
	/*** new password
	 * @var string
	 **/
	public $new_password;
	
	/*** Identity
	 * @var string
	 **/
	public $identity;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('redux_auth');
		$this->tables  = $this->config->item('tables');
		$this->columns = $this->config->item('columns');
	}
	
	/**
	 * Misc functions
	 * 
	 * Hash password : Hashes the password to be stored in the database.
     	 * Hash password db : This function takes a password and validates it
     	 * against an entry in the users table.
	 * Salt : Generates a random salt value.	
	 */
	 
	/**
	 * Hashes the password to be stored in the database.
	 * @return void
	 **/
	public function hash_password($password = false)
	{
	    $salt_length = $this->config->item('salt_length');
	    
	    if ($password === false)
	    {
	        return false;
	    }
	    
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
	    {
	        return false;
	    }
	    
	    $query  = $this->db->select('password')
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
            
        $result = $query->row();
        
		if ($query->num_rows() !== 1)
		{
		    return false;
	    }
	    
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
	 * Activation functions
	 * 
     	 * Activate : Validates and removes activation code.
     	 * Deactivae : Updates a users row with an activation code.
	 */
	
	/**
	 * activate
	 * @return void
	 **/
	public function activate($code = false)
	{
	    $identity_column = $this->config->item('identity');
	    $users_table     = $this->tables['users'];
	    
	    if ($code === false)
	    {
	        return false;
	    }
	  
	    $query = $this->db->select($identity_column)
                	      ->where('activation_code', $code)
                	      ->limit(1)
                	      ->get($users_table);
                	      
		$result = $query->row();
        
		if ($query->num_rows() !== 1)
		{
		    return false;
		}
	    
		$identity = $result->{$identity_column};
		
		$data = array('activation_code' => '');
        
		$this->db->update($users_table, $data, array($identity_column => $identity));
		
		return ($this->db->affected_rows() == 1) ? true : false;
	}
	
	/**
	 * Deactivate
	 * @return void
	 **/
	public function deactivate($username = false)
	{
	    /*$users_table = $this->tables['users'];
	    
	    if ($username === false)
	    {
	        return false;
	    }
	    
		$activation_code = sha1(md5(microtime()));
		$this->activation_code = $activation_code;
		
		$data = array('activation_code' => $activation_code);
        
		$this->db->update($users_table, $data, array('username' => $username));
		
		return ($this->db->affected_rows() == 1) ? true : false;*/
	}

	/**
	 * change password
	 * @return void
	 **/
	public function change_password($identity = false, $old = false, $new = false)
	{
	    $identity_column   = $this->config->item('identity');
	    $users_table       = $this->tables['users'];
	    
	    if ($identity === false || $old === false || $new === false)
	    {	return false;	}
	    
	    $query  = $this->db->select('password')
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
                    	   
	    $result = $query->row();

	    $db_password = $result->password; 
	    $old         = $this->hash_password_db($identity, $old);
	    $new         = $this->hash_password($new);

	    if ($db_password === $old)
	    {
	        $data = array('password' => $new);	        
	        $this->db->update($users_table, $data, array($identity_column => $identity));	        
	        return ($this->db->affected_rows() == 1) ? true : false;
	    }
	    
	    return false;
	}
	
	/**
	 * Checks username.
	 * @return void
	 **/
	public function username_check($username = false)
	{
	    /*$users_table = $this->tables['users'];
	    
	    if ($username === false)
	    { return false;  }
	    
	    $query = $this->db->select('usrid')
                           ->where('username', $username)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{	return true;	}
		
		return false;*/
	}
	
	/**
	 * Checks email.
	 * @return void
	 **/
	public function email_check($email = false)
	{
	    $users_table = $this->tables['users'];
	    
	    if ($email === false)
	    {  return false;  }
	    
	    $query = $this->db->select('usrid')
                           ->where('email', $email)
                           ->limit(1)
                           ->get($users_table);
		
		if ($query->num_rows() == 1)
		{	return true;	}
		
		return false;
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
	 * Insert a forgotten password key.
	 * @return void
	 **/
	public function forgotten_password($email=false, $fn=false, $ln=false, $g=false, $c=false)
	{
	    $users_table = $this->tables['users'];
	    
	    if ($email === false)
	    { return false; }
	    
	    //User Validation
		$query = $this->db->select('firstname, lastname, gender, country')
                    	   ->where('email', $email)
                    	   ->limit(1)
                    	   ->get($users_table);
		$result = $query->row();
		
		//if (($fn==$result->firstname)&&($ln==$result->lastname)&&($g==$result->gender)&&($c==$result->country))
		if ($result)
		{	return true;	}
		else
		{   return false;	}
	}
	
	/**
	 * undocumented function
	 * @return void
	 **/
	public function forgotten_password_complete($code = false)
	{
	    $users_table = $this->tables['users'];
	    $identity_column = $this->config->item('identity'); 
	    
	    if ($code === false)
	    {
	        return false;
	    }
	    
	    $query = $this->db->select('id')
                    	   ->where('forgotten_password_code', $code)
                           ->limit(1)
                    	   ->get($users_table);
        
        $result = $query->row();
        
        if ($query->num_rows() > 0)
        {
            $salt       = $this->salt();
		    $password   = $this->hash_password($salt);
		    
		    $this->new_password = $salt;
		    
            $data = array('password'                => $password,
                          'forgotten_password_code' => '0');
            
            $this->db->update($users_table, $data, array('forgotten_password_code' => $code));

            return true;
        }
        
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
	    //$meta_table      = $this->tables['meta'];
	    //$meta_join       = $this->config->item('join');
	    $identity_column = $this->config->item('identity');    
	    
	    if ($identity === false)
	    {
	        return false;
	    }
	    
		/*$this->db->select($users_table.'.id, '.
						  //$users_table.'.username, ' .
						  $users_table.'.password, '.
						  $users_table.'.firstname, '.
						  $users_table.'.lastname, '.
						  $users_table.'.email, '.
						  //$users_table.'.activation_code, '.
						  //$users_table.'.forgotten_password_code , '.
						  $users_table.'.ip_address, '//.
						  //$groups_table.'.name AS `group`'
						  );*/
		
		/*if (!empty($this->columns))
		{
		    foreach ($this->columns as $value)
    		{
    			$this->db->select($meta_table.'.'.$value);
    		}
		}*/
		
		//$this->db->from($users_table);
		//$this->db->join($meta_table, $users_table.'.id = '.$meta_table.'.'.$meta_join, 'left');
		//$this->db->join($groups_table, $users_table.'.grpid = '.$groups_table.'.id', 'left');
		
		if (strlen($identity) === 40)
	    {
	        //$this->db->where($users_table.'.forgotten_password_code', $identity);
	    }
	    else
	    {
	        //$this->db->where($users_table.'.'.$identity_column, $identity);
	    }
	    
		$this->db->select('title, firstname, lastname, email, gender, citizenship, jobtitle, participanttype, telephone, mobile, fax, street, postalcode, town, city, country, message');		
		//$this->db->limit(1);
		$this->db->where('email',$identity);
		$i = $this->db->get('user');
		
		return ($i->num_rows > 0) ? $i->row() : false;
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
					'mobile' => $_POST['mob'],
					'fax' => $_POST['fax'],
					//'affiliation' => $_POST['aff'],
					'street' => $_POST['street'],
					'postalcode' => $_POST['pc'],
					'town' => $_POST['town'],
					'city' => $_POST['city'],
					'country' => $_POST['country'],
					'message' => $_POST['message'],
					'updatetime' =>  $d	
					 );
		$this->db->where('email', $identity);
		$this->db->update('user', $data);
		
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
	    //$meta_table         = $this->tables['meta'];
	    $groups_table       = $this->tables['groups'];
	    //$meta_join          = $this->config->item('join');
	    $additional_columns = $this->config->item('columns');
	    
	    if ($password === false || $email === false)
	    { return false; }
	    
        	// Group ID
	    //$query = $this->db->select('grpid')->where('grpname', $this->config->item('unprivileged'))->get($groups_table);
	    //$result   = $query->row();
	    //$grpid = $result->grpid;
		$grpid = 1;
	    
        	// IP Address
            //$ip_address = $this->input->ip_address();
	    
	    $password = $this->hash_password($password);
	    
	    $t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
        	// Users table.
	    $data = array(//'username' => $username, 
	    		  'grpid' => $grpid,
			  'password' => $password, 
			  'email'    => $email,			  
			  //'ip_address' => $ip_address,
			  'title' => $_POST['title'],
			  'firstname' => $_POST['first_name'],
			  'lastname' => $_POST['last_name'],
			  'gender' => $_POST['gender'],
			  'citizenship' => $_POST['coc'],
			  'jobtitle' => $_POST['jobtitle'],
			  'participanttype' => $_POST['participanttype'],
			  'telephone' => $_POST['telephone'],
			  'mobile' => $_POST['mob'],
			  'fax' => $_POST['fax'],
			  //'affiliation' => $_POST['aff'],
			  'street' => $_POST['street'],
			  'postalcode' => $_POST['pc'],
			  'town' => $_POST['town'],
			  'city' => $_POST['city'],
			  'country' => $_POST['country'],
			  'message' => $_POST['message'],
			  'createtime' =>  $d
			 );			  
		  
	    $this->db->insert($users_table, $data);	    
        
	     	// Meta table.
	    //$id = $this->db->insert_id();		
	    //$data = array($meta_join => $id);
		
	    /*if (!empty($additional_columns))
	    {
	       	foreach ($additional_columns as $input)
	       	{$data[$input] = $this->input->post($input);}
	    }*/
        
	    //$this->db->insert($meta_table, $data);
		
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function conf_reg($email=false)
	{
	    if ($email === false)
	    { return false; }
	    
	    $this->db->select('usrid');
		$this->db->where('email',$email);
		$i = $this->db->get('user');		
		$result = $i->row();
		$chairid = $result->usrid;
		
		$grp = array('grpid' => 5);
		$this->db->where('usrid', $chairid);
		$this->db->update('user', $grp);
		
        // Conference table.
	    $data = array(
					'chairid' => $chairid,
					'shorttitle' => $_POST['shorttitle'],
					'fulltitle' => $_POST['fulltitle'],
					'startdate' => $_POST['startdate'],
					'enddate' => $_POST['enddate'],
					'subdeadline' => $_POST['deadline'],
					'passinggrade' => $_POST['passinggrade'],
					'town' => $_POST['town'],
					'city' => $_POST['city'],
					'country' => $_POST['country'],
					'shortdescp' => $_POST['abstract'],			  
					'sitelink' => $_POST['URL'],
					'typename' => $_POST['academic'],
					'totalparticipants' => $_POST['participants']
					);			  
		  
	    $this->db->insert('conference', $data);
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function att_reg()
	{	    
	    $t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
		// Attendee table.
	    $data = array(
					'confid' 	=> $_POST['confid'],
					'password' 	=> $_POST['password'],
					'title' 	=> $_POST['title'],
					'firstname' => $_POST['fname'],
					'lastname' 	=> $_POST['lname'],
					'email' 	=> $_POST['email'],
					'mobile' 	=> $_POST['mobile'],
					'comments' 	=> $_POST['comment'],
					'createtime'=> $d					
					);			  
		  
	    $this->db->insert('attendee', $data);
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function att_reg2($identity = false)
	{	    
	    if ($identity === false){ return false; }
		
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		$usrid = $result->usrid;
		
		$t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
		// Attendee table.
	    $data = array(
					'confid' 	=> $_POST['confid'],
					'usrid' 	=> $usrid,
					'password' 	=> $_POST['password'],
					'title' 	=> $_POST['title'],
					'firstname' => $_POST['fname'],
					'lastname' 	=> $_POST['lname'],
					'email' 	=> $_POST['email'],
					'mobile' 	=> $_POST['mobile'],
					'comments' 	=> $_POST['comment'],
					'createtime'=> $d					
					);			  
		  
	    $this->db->insert('attendee', $data);
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	/**
	 * login
	 * @return void
	 **/
	public function login($identity = false, $password = false)
	{
	    $identity_column = $this->config->item('identity');
	    $users_table     = $this->tables['users'];
	    
	    if ($identity === false || $password === false || $this->identity_check($identity) == false)
	    { return false; }
	    
	    $query = $this->db->select($identity_column.', password ')
                    	   ->where($identity_column, $identity)
                    	   ->limit(1)
                    	   ->get($users_table);
	    
            $result = $query->row();
        
            if ($query->num_rows() == 1)
            {
             $password = $this->hash_password_db($identity, $password);
            
             //if (!empty($result->activation_code)) { return false; }
            
    		if ($result->password === $password)
    		{   $this->session->set_userdata($identity_column,  $result->{$identity_column});
    		    return true;
    		}
            }
        
		return false;		
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
		$i = $this->db->get('user');
		$result = $i->row();
		
		return ($i->num_rows > 0) ? $result->grpid : false;
	}
	
	public function auto($identity = false)
	{
	    $users_table     = $this->tables['users'];
	    $groups_table    = $this->tables['groups'];	    
	    $identity_column = $this->config->item('identity');    
	    
	    if ($identity === false)	    { return false; }
	    
		$this->db->select('auto');		
		$this->db->where('email',$identity);
		$i = $this->db->get('user');
		$result = $i->row();		
		
		return ($i->num_rows > 0) ? $result->auto : false;
	}
	
	public function no_auto($identity = false)
	{
		// Get user id of chair
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		
		//Auto=1 where the chair is
		$usrid = $result->usrid;		
		$data = array('auto' => 1);
		$this->db->where('usrid', $usrid);
		$this->db->update('user', $data);		
		
		//Paper Automation
		$con = mysql_connect("localhost","root","saad");
		if (!$con) {die('Could not connect: ' . mysql_error());}
		mysql_select_db("basmic", $con);
		$query = "select * from paper p inner join conference c on (p.rating >= 7 && p.confid=c.confid && p.status = c.status = 1)";
		$arr = mysql_query($query);
		//Fetching those papers who are in this conference and have status '1' and their rating is >7..
		while($res = mysql_fetch_array($arr))
		{mysql_query("update paper SET accept=1 where paperid=$res[paperid]");}
		
		return true;
	}
	
	public function do_auto($identity = false)
	{
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		
		$usrid = $result->usrid;		
		$data = array('auto' => 1);
		$this->db->where('usrid', $usrid);
		$this->db->update('user', $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function paper($identity = false)
	{
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		
		$chairid = $result->usrid;
		$query = $this->db->query("SELECT confid, shorttitle, passinggrade FROM conference c where (c.chairid=$chairid);");		
		
		$data2 = array();
		$x2=0;
		foreach ($query->result() as $row)
		{
			$data2[$x2]=$row->confid; 			$x2++;
			$data2[$x2]=$row->shorttitle; 		$x2++;
			$data2[$x2]=$row->passinggrade; 	$x2++;
			
			$confid = $row->confid;				
			$query2 = $this->db->query("SELECT paperid,abstract,typeofpaper,status FROM paper p where (p.confid=$confid);");
						
			foreach ($query2->result() as $row2)
			{
			$data2[$x2]=$row2->paperid; 		$x2++;
			$data2[$x2]=$row2->abstract; 		$x2++;
			$data2[$x2]=$row2->typeofpaper; 	$x2++;
			$data2[$x2]=$row2->status; 			$x2++;
			}
		}
		//print_r($data2);		
		return $data2;
	}
	
	public function conf($identity = false)
	{
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		
		$chairid = $result->usrid;
		$this->db->select('confid');
		$this->db->where('chairid',$chairid);
		$i = $this->db->get('conference');		
		
		$data = array();
		$x=0;
		foreach ($i->result() as $row)
		{
			$data[$x] = $row->confid; 		$x++;			
		}
				
		return ($this->db->affected_rows() > 0) ? $data : false;
	}
	
	public function conf2()
	{		
		$query2 = $this->db->query("SELECT `confid`,`shorttitle` FROM `conference`");
		
		$data2 = array();
		$x2=0;
		foreach ($query2->result() as $row2)
			{
			$data2[$x2]=$row2->confid; 			$x2++;
			$data2[$x2]=$row2->shorttitle; 		$x2++;			
			}
		$z=0;
				
		return ($query2->num_rows > 0) ? $data2 : false;
	}
	
	public function conf3($identity = false)
	{		
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		$usrid = $result->usrid;
		
		$query2 = $this->db->query("SELECT c.confid as con,fulltitle,passinggrade as PassingGrade,startdate,enddate  FROM conference c inner join attendee a on (c.confid=a.confid && a.usrid=$usrid && (c.startdate > NOW() OR c.enddate > NOW()));");		
		
		$data2 = array();
		$x2=0;
		foreach ($query2->result() as $row2)
			{
			$data2[$x2]=$row2->con; 			$x2++;
			$data2[$x2]=$row2->fulltitle; 		$x2++;
			//$data2[$x2]=$row2->passinggrade;	$x2++;
			//$data2[$x2]=$row2->startdate; 		$x2++;
			//$data2[$x2]=$row2->enddate; 		$x2++;
			}
		$z=0;
				
		return ($query2->num_rows > 0) ? $data2 : false;
	}
	
	public function get_authorid($identity = false)
	{		
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		$usrid = $result->usrid;
		return $usrid;
	}
	
	public function get_authorid2($id = false)
	{		
		$this->db->select('authorid');
		$this->db->where('authorid',$id);
		$i = $this->db->get('author');		
		$result = $i->row();		
		$a = $result->authorid;
		if ($a)	{return true;}
		else {return false;}
	}
	
	public function create_author($authorid)
	{	    
	    $t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
		// Author table.
	    $data = array(
					'authorid' 	 	=> $authorid,
					'acceptedpapers'=> 0,
					'rejectedpapers'=> 0,
					'createtime' => $d					
					);			  
		  
	    $this->db->insert('author', $data);
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function get_auth_papers($identity = false)
	{		
		$this->db->select('usrid');
		$this->db->where('email',$identity);
		$i = $this->db->get('user');		
		$result = $i->row();
		$usrid = $result->usrid;
		
		$this->db->select('acceptedpapers, rejectedpapers');
		$this->db->where('authorid',$usrid);
		$i = $this->db->get('author');		
		
		$data = array();
		$x=0;
		foreach ($i->result() as $row)
		{$data[$x] = $row->acceptedpapers; 		$x++;
		 $data[$x] = $row->rejectedpapers; 		$x++;}
		
		return ($this->db->affected_rows() > 0) ? $data : false;
	}
	
	public function sub_paper($authorid, $confid, $userfile, $abstract, $type, $keywords)
	{	    
	    $t=time();
	    $d=date("Y-m-d-h-i-s",$t);
		
		$b = basename($userfile);
		$userfile = "../../../basmic/uploads/".$b;
		
		// Paper table.
	    $data = array(
					'authorid' 	 => $authorid,
					'confid' 	 => $confid,
					'pathfile' 	 => $userfile,
					'abstract'   => $abstract,
					'typeofpaper'=> $type,
					'keywords' 	 => $keywords,					
					'createtime' => $d					
					);			  
		  
	    $this->db->insert('paper', $data);
	    return ($this->db->affected_rows() > 0) ? true : false;
	}
		
}

