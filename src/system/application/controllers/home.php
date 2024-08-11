<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();	
	}
	
	function index()
	{
		redirect('home/status');
	}
	
	function status()
	{
	    $status['status'] = $this->redux_auth->logged_in();
	    $content= $this->load->view('status', $status, true);
	    $data = array(
               		'status' => $status['status'],
               		'content' => $content               		
          		);
	    $this->load->view('home', $data);
	}	
	
	// User Registeration
	function register()
	{	    	    $this->form_validation->set_rules('first_name', 'First Name', 'required');
	    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
	    $this->form_validation->set_rules('email', 'Email Address', 'required|callback_email_check|valid_email');
	    $this->form_validation->set_rules('password', 'Password', 'required');
	    $this->form_validation->set_rules('participanttype', 'Participant Type', 'required');
	    $this->form_validation->set_rules('street', 'Street', 'required');
	    $this->form_validation->set_rules('pc', 'Postcode', 'required');
	    $this->form_validation->set_rules('city', 'City', 'required');
	    $this->form_validation->set_rules('country', 'Country', 'required');
	    $this->form_validation->set_rules('captcha', 'Captcha', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
	        $captcha_result = '';
	        $reg['cap_img'] = $this -> _make_captcha();	        
	        $content = $this->load->view('register', $reg, true);	        
	        $data = array(
               		'status'  => $status['status'],
               		'content' => $content               		
          		);          	
          	$this->load->vars($data);          
	        $this->load->view('home');	        
	    }
	    else
	    {
	        $email 	    = $this->input->post('email');	        
	        $password = $this->input->post('password');
	        	        
	        if ( $this -> _check_capthca() ) 
	        {
	        $register = $this->redux_auth->register($password, $email);
	       	        
	        	if ($register)
	        	{   $this->session->set_flashdata('message', '<p class="success">You are now registered. You can now login.</p>');
	            	    redirect('home/register');
	        	}
	        else
	        	{   $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
	            	    redirect('home/register');
	        	}
	        }else {
			$this->session->set_flashdata('message', 'Enter captcha. Please try again!');
			redirect('home/register');
		}
	        
	    }	    
	}
	
	public function conf_reg()
	{
		$this->form_validation->set_rules('shorttitle', 'Short Title', 'required');
	    $this->form_validation->set_rules('fulltitle', 'Full Title', 'required');
		$this->form_validation->set_rules('startdate', 'Start Date', 'required');
		$this->form_validation->set_rules('enddate', 'End Date', 'required');
		$this->form_validation->set_rules('town', 'Town', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {
			if ($this->redux_auth->logged_in())
			{
	        $data['profile'] = $this->redux_auth->profile();	        
	        $data['content'] = $this->load->view('conf_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        /*$data = array(
	        	'profile' => $profile['profile'],
               		'status' => $status['status'],
               		'content' => $content               		
          		);*/
          	$this->load->vars($data);
	        $this->load->view('home');
			}
			else
			{	redirect('home/login');		}
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity'));	        
	        $change = $this->redux_auth_model->conf_reg($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Your Conference is Created.</p>');				
				redirect('chair/profile');
			}
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Your Conference creation Failed!</p>');    }
		}
	}
	
	public function att_reg()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
	    $this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confid', 'Conference Name', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile number', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {			
			$data['profile'] = $this->redux_auth_model->conf2();
	        $data['content'] = $this->load->view('att_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();	       
          	$this->load->vars($data);
	        $this->load->view('home');			
		}
		else
		{			
	        $change = $this->redux_auth_model->att_reg();		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">You are registered to the conference.</p>');				
				redirect('home/status');
			}
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Your Conference registration Failed!</p>');    }
		}
	}
	
	// Username & Email Checking
	public function username_check($username)
	{
	    $check = $this->redux_auth_model->username_check($username);
	    
	    if ($check)
	    {
	        $this->form_validation->set_message('username_check', 'The username "'.$username.'" already exists.');
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}
	
	public function email_check($email)
	{
	    $check = $this->redux_auth_model->email_check($email);
	    
	    if ($check)
	    {
	        $this->form_validation->set_message('email_check', 'The email "'.$email.'" already exists.');
	        return false;
	    }
	    else
	    {
	        return true;
	    }
	}
	
	// Login & Logout
	function login()
	{
	    $this->form_validation->set_rules('email', 'Email Address', 'required');
	    $this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');				
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
	        $content = $this->load->view('login', null, true);
	        $data = array(
               		'status' => $status['status'],
               		'content' => $content               		
          		);
	        $this->load->view('home', $data);
	    }
	    else
	    {
	        $email    = $this->input->post('email');
	        $password = $this->input->post('password');	        
	        $login = $this->redux_auth->login($email, $password);
		    
	        if ($login)
			{ 
				$newdata = array('email' => $email);
				$this->session->set_userdata($newdata);
				$grp = $this->redux_auth->grp_id();
				if ($grp==1)				{redirect('home/status');}
				else if ($grp==2)			{redirect('author/status');}
				else if ($grp==3)			{redirect('rev/status');}
				else if ($grp==4)			{redirect('ca/status');}	
				else if ($grp==5)			{redirect('chair/status');}				
				else
				{echo "Invalid User";}
			}
			else
			{	$this->session->set_flashdata('message', '<p class="error">Invalid username or password, try again.</p>');
				redirect('home/login');		
			}
	    }
	}	
	
	function logout()
	{
		$this->redux_auth->logout();
		redirect('home/status');
	}
	
	function logout2()
	{
		$this->redux_auth->logout();		
		redirect('home/login');
	}
	
	// Password Functions
	function change_password()
	{	    
	    $this->form_validation->set_rules('old', 'Old password', 'required');
	    $this->form_validation->set_rules('new', 'New Password', 'required|matches[new_repeat]');
	    $this->form_validation->set_rules('new_repeat', 'Repeat New Password', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
			$content = $this->load->view('change_password', null, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('home', $data);
	    }
	    else
	    {
	        $old = $this->input->post('old');
	        $new = $this->input->post('new');
	        
	        $identity = $this->session->userdata($this->config->item('identity'));
	        
	        $change = $this->redux_auth->change_password($identity, $old, $new);
		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Password changes are saved.</p>');
				redirect('home/profile');  }
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Password changes Failed! Try again!</p>');
			    redirect('home/change_password');
			}
	    }
	}
	
	function forgotten_password()
	{
	    $this->form_validation->set_rules('email', 'Email Address', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
			$content = $this->load->view('forgotten_password', null, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('home', $data);
	    }
	    else
	    {
	        $email = $this->input->post('email');
			$fm    = $this->input->post('first_name');
			$lm    = $this->input->post('last_name');
			$g     = $this->input->post('gender');
			$c     = $this->input->post('country');
			$forgotten = $this->redux_auth->forgotten_password($email, $fm, $lm, $g, $c);
		    
			if ($forgotten)
			{				
				$newdata = array('email' => $email);
				$this->session->set_userdata($newdata);
				$this->session->set_flashdata('message', '<p class="success">You can now change your password.</p>');
	            redirect('home/profile');
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">You entered invalid details, try again.</p>');
	            redirect('home/forgotten_password');
			}
	    }
	}
	
	public function forgotten_password_complete()
	{
	    $this->form_validation->set_rules('code', 'Verification Code', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        redirect('home/forgotten_password');
	    }
	    else
	    {
	        $code = $this->input->post('code');
			$forgotten = $this->redux_auth->forgotten_password_complete($code);
		    
			if ($forgotten)
			{
				$this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
	            redirect('home/forgotten_password');
			}
			else
			{
				$this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
	            redirect('home/forgotten_password');
			}
	    }
	}
	
	// Profile
	public function profile()
	{	    
		if ($this->redux_auth->logged_in())
	    {
	        $data['profile'] = $this->redux_auth->profile();	        
	        $data['content'] = $this->load->view('profile', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        /*$data = array(
	        	'profile' => $profile['profile'],
               		'status' => $status['status'],
               		'content' => $content               		
          		);*/
          	$this->load->vars($data);
	        $this->load->view('home');
	    }
	    else
	    {
	        redirect('home/login');
	    }
	}
	
	function edit_profile()
	{	    
	    $this->form_validation->set_rules('first_name', 'First Name', 'required');
	    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('participanttype', 'Participant Type', 'required');
	    $this->form_validation->set_rules('street', 'Street', 'required');
	    $this->form_validation->set_rules('pc', 'Postcode', 'required');
	    $this->form_validation->set_rules('city', 'City', 'required');
	    $this->form_validation->set_rules('country', 'Country', 'required');		
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
			$data['profile'] = $this->redux_auth->profile();
			$content = $this->load->view('edit_profile', $data, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('home', $data);
	    }
	    else
	    {
	        $identity = $this->session->userdata($this->config->item('identity'));	        
	        $change = $this->redux_auth->profile_edit($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Your profile is Updated.</p>');				
				redirect('home/profile');
			}
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Your profile editing Failed!</p>');    }
	    }
	}
	
	function _make_captcha()
	{
		$this -> load -> plugin( 'captcha' );
		$vals = array(
					'img_path'   => './captcha/', // PATH for captcha
					'img_url'    => 'http://localhost/basmic/captcha/', // URL for captcha img
					'img_width'  => 170, // width
					'img_height' => 30, // height
					'font_path'  => './system/texb.ttf',
					'expiration' => 4000 
					); 
		// Create captcha
		$cap = create_captcha( $vals ); 
		// Write to DB
		if ( $cap ) 
		{	$data = array(
					'captcha_id' => null,
					'captcha_time' => $cap['time'],
					'ip_address' => $this -> input -> ip_address(),
					'word' => $cap['word'] 
				     );
			$query = $this -> db -> insert_string('captcha', $data );
			$this -> db -> query( $query );
		}else {	return "Captcha not work!" ;	}
		return $cap['image'] ;
	}
	
	function _check_capthca()
	{ 
		// Delete old data ( 2hours)
		$expiration = time()-7200 ;
		$sql = " DELETE FROM captcha WHERE captcha_time < ? ";
		$binds = array($expiration);
		$query = $this->db->query($sql, $binds);
    
		//checking input
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row -> count > 0)	{ return true; }
		return false;		
	}
}

/* End of file Home.php */
/* Location: ./system/application/controllers/home.php */
