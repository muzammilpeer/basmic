<?php

class Rev extends Controller 
{
	function Rev()
	{
		parent::Controller();	
	}
	
	function index()
	{
		redirect('rev/status');
	}
	
	function status()
	{
	    $status['status'] = $this->redux_auth->logged_in();
	    $content= $this->load->view('rev/status', $status, true);
	    $data = array(
               		'status' => $status['status'],
               		'content' => $content               		
          		);
	    $this->load->view('rev/home', $data);
	}
	
	function paper()
	{	    		
			$status['status'] = $this->redux_auth->logged_in();
			$identity = $this->session->userdata($this->config->item('identity'));
			$auto['auto'] = $this->redux_auth_model->auto($identity);
			if ($status['status'])
			{
			$content= $this->load->view('rev/paper', $auto, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('rev/home', $data);
			}
			else
			{	redirect('home/status');	}		
	}
	
	function ar_paper()
	{
	    $this->form_validation->set_rules('policy', 'Policy', 'required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {
			$status['status'] = $this->redux_auth->logged_in();
			if ($status['status'])
			{
			$identity = $this->session->userdata($this->config->item('identity'));
			$auto['auto'] = $this->redux_auth_model->auto($identity);
			$content= $this->load->view('rev/ar_paper', $auto, true);
			//$content = $this->load->view('rev/peer2/main.php', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('rev/home', $data);
			}
			else
			{	redirect('home/status');	}
		}
		else
		{
			$policy    = $this->input->post('policy');
			
			if ($policy=='manual')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->no_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
			else if ($policy=='auto')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->do_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
		}
	}
	
	function list_papers()
	{	    
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {
			$status['status'] = $this->redux_auth->logged_in();
			if ($status['status'])
			{	
			$identity['identity'] = $this->session->userdata($this->config->item('identity'));
			$content = $this->load->view('rev/peer/list_papers.php', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('rev/home', $data);
			}
			else
			{	redirect('home/status');	}
		}
		else
		{
			$policy    = $this->input->post('policy');
			
			if ($policy=='manual')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->no_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
			else if ($policy=='auto')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->do_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
		}
	}
	
	function rate_paper()
	{	    
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {
			$status['status'] = $this->redux_auth->logged_in();
			if ($status['status'])
			{	
			$identity['identity'] = $this->session->userdata($this->config->item('identity'));
			$content = $this->load->view('rev/peer/rate_paper.php', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('rev/home', $data);
			}
			else
			{	redirect('home/status');	}
		}
		else
		{
			$policy    = $this->input->post('policy');
			
			if ($policy=='manual')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->no_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
			else if ($policy=='auto')
			{
				$identity = $this->session->userdata($this->config->item('identity'));				
				$manual = $this->redux_auth_model->do_auto($identity);				
				if ($manual)
				{
				$this->form_validation->set_message('message', 'Now you can manually accept/reject papers.');
				redirect('rev/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
		}
	}
	
	function change_password()
	{	    
	    $this->form_validation->set_rules('old', 'Old password', 'required');
	    $this->form_validation->set_rules('new', 'New Password', 'required|matches[new_repeat]');
	    $this->form_validation->set_rules('new_repeat', 'Repeat New Password', 'required');
	    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
	    
	    if ($this->form_validation->run() == false)
	    {
	        $status['status'] = $this->redux_auth->logged_in();
			$content = $this->load->view('rev/change_password', null, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('rev/home', $data);
	    }
	    else
	    {
	        $old = $this->input->post('old');
	        $new = $this->input->post('new');
	        
	        $identity = $this->session->userdata($this->config->item('identity'));
	        
	        $change = $this->redux_auth->change_password($identity, $old, $new);
		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Password changes are saved.</p>');
				redirect('rev/profile');  }
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Password changes Failed! Try again!</p>');
			    redirect('rev/change_password');
			}
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
			$content = $this->load->view('rev/edit_profile', $data, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('rev/home', $data);
	    }
	    else
	    {
	        $identity = $this->session->userdata($this->config->item('identity'));	        
	        $change = $this->redux_auth->profile_edit($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Your profile is Updated.</p>');				
				redirect('rev/profile');
			}
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Your profile editing Failed!</p>');    }
	    }
	}
	
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
				if ($grp==1)
				{redirect('home/status');}
				else if ($grp==5)
				{redirect('rev/status');}
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
	
	public function profile()
	{	    
		if ($this->redux_auth->logged_in())
	    {
	        $data['profile'] = $this->redux_auth->profile();	        
	        $data['content'] = $this->load->view('rev/profile', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        /*$data = array(
	        	'profile' => $profile['profile'],
               		'status' => $status['status'],
               		'content' => $content               		
          		);*/
          	$this->load->vars($data);
	        $this->load->view('rev/home');
	    }
	    else
	    {
	        redirect('home/login');
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
	        $data['content'] = $this->load->view('rev/att_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();	       
          	$this->load->vars($data);
	        $this->load->view('rev/home');			
		}
		else
		{			
	        $identity = $this->session->userdata($this->config->item('identity'));
			$change = $this->redux_auth_model->att_reg2($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">You are registered to the conference.</p>');				
				redirect('rev/status');
			}
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Your Conference registration Failed!</p>');    }
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
	        $data['content'] = $this->load->view('rev/conf_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        /*$data = array(
	        	'profile' => $profile['profile'],
               		'status' => $status['status'],
               		'content' => $content               		
          		);*/
          	$this->load->vars($data);
	        $this->load->view('rev/home');
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
}

/* End of file rev.php */
/* Location: ./system/application/controllers/rev.php */	

