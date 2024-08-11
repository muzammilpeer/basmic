<?php

class Author extends Controller 
{
	function Author()
	{
		parent::Controller();	
	}
	
	function index()
	{
		redirect('author/status');
	}
	
	function status()
	{
	    $status['status'] = $this->redux_auth->logged_in();
	    $content= $this->load->view('author/status', $status, true);
	    $data = array(
               		'status' => $status['status'],
               		'content' => $content               		
          		);
	    $this->load->view('author/home', $data);
	}
	
	function my_papers()
	{	    		
			$status['status'] = $this->redux_auth->logged_in();
			$identity = $this->session->userdata($this->config->item('identity'));			
			$auto['auto'] = $this->redux_auth_model->get_authorid($identity);
			if ($status['status'])
			{
			$content= $this->load->view('author/my_papers', $auto, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('author/home', $data);
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
			$content= $this->load->view('author/ar_paper', $auto, true);
			//$content = $this->load->view('author/peer2/main.php', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('author/home', $data);
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
				redirect('author/paper');
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
				redirect('author/paper');
				}
				else
				{echo "Failed to make changes!";}
			}
		}
	}
	
	function upload()
	{	    
		$this->form_validation->set_rules('confid', 'Conference', 'required');
		$this->form_validation->set_rules('userfile', 'Paper File', 'required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		if ($this->form_validation->run() == false)
	    {
			$status['status'] = $this->redux_auth->logged_in();
			if ($status['status'])
			{	
			$id = $identity['identity'] = $this->session->userdata($this->config->item('identity'));
			$identity['profile'] = $this->redux_auth_model->conf2();
			//$identity['authorid'] = $this->redux_auth_model->get_authorid($id);
			$identity['error'] = ' ';			
			$content = $this->load->view('author/saad/upload_form', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('author/home', $data);
			}
			else
			{	redirect('home/status');	}
		}
		/*else
		{
			$id = $this->session->userdata($this->config->item('identity'));
			$authorid	= $this->redux_auth_model->get_authorid($id);
			$confid		= $this->input->post('confid');
			$userfile	= $this->input->post('userfile');
			$abstract	= $this->input->post('abstract');
			$type		= $this->input->post('type');
			$keywords	= $this->input->post('keywords');
			
						
			$paper = $this->redux_auth_model->sub_paper($authorid, $confid, $userfile, $abstract, $type, $keywords);
			if ($paper)
			{
				$this->form_validation->set_message('message', 'Your paper is successfully submitted.');
				redirect('author/upload');
				}
			else
			{$this->form_validation->set_message('message', 'Your paper is NOT submitted!');
			 redirect('author/upload');
			 }
		}*/
	}
	
	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'doc|pdf|odt';
		$config['max_size']	= '800';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';		
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
			$status['status'] = $this->redux_auth->logged_in();
			$identity['identity'] = $this->session->userdata($this->config->item('identity'));			
			$identity['error'] = $error;
			$identity['profile'] = $this->redux_auth_model->conf2();
			$content = $this->load->view('author/saad/upload_form', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('author/home', $data);
		}	
		else
		{	$id = $this->session->userdata($this->config->item('identity'));
			$authorid	= $this->redux_auth_model->get_authorid($id);
			$confid		= $this->input->post('confid');
			$upload_data= $this->upload->data();
			$userfile	= $upload_data['full_path'];
			$abstract	= $this->input->post('abstract');
			$type		= $this->input->post('type');
			$keywords	= $this->input->post('keywords');			
						
			$a_id = $this->redux_auth_model->get_authorid2($authorid);
			if ($a_id)
			{$paper = $this->redux_auth_model->sub_paper($authorid, $confid, $userfile, $abstract, $type, $keywords);}
			else
			{$a = $this->redux_auth_model->create_author($authorid);
			 if ($a) {$paper = $this->redux_auth_model->sub_paper($authorid, $confid, $userfile, $abstract, $type, $keywords);}
			}
						
			$status['status'] = $this->redux_auth->logged_in();
			$identity['identity'] = $this->session->userdata($this->config->item('identity'));
			$identity['upload_data'] = $this->upload->data();
			$content = $this->load->view('author/saad/upload_success', $identity, true);
			$data = array(
						'status' => $status['status'],
						'content' => $content               		
						);
			$this->load->view('author/home', $data);
			if ($paper)
			{	$this->form_validation->set_message('message', 'Your paper is successfully submitted.');
				//redirect('author/upload');
				}
			else
			{	$this->form_validation->set_message('message', 'Your paper is NOT submitted!');
				//redirect('author/upload');
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
			$content = $this->load->view('author/change_password', null, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('author/home', $data);
	    }
	    else
	    {
	        $old = $this->input->post('old');
	        $new = $this->input->post('new');
	        
	        $identity = $this->session->userdata($this->config->item('identity'));
	        
	        $change = $this->redux_auth->change_password($identity, $old, $new);
		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Password changes are saved.</p>');
				redirect('author/profile');  }
    		else
    		{	$this->session->set_flashdata('message', '<p class="error">Password changes Failed! Try again!</p>');
			    redirect('author/change_password');
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
			$content = $this->load->view('author/edit_profile', $data, true);
			$data = array(
               		'status' => $status['status'],
               		'content' => $content               		
						);
	        $this->load->view('author/home', $data);
	    }
	    else
	    {
	        $identity = $this->session->userdata($this->config->item('identity'));	        
	        $change = $this->redux_auth->profile_edit($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">Your profile is Updated.</p>');				
				redirect('author/profile');
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
				{redirect('author/status');}
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
	        $identity = $this->session->userdata($this->config->item('identity'));
			$data['profile'] = $this->redux_auth->profile();			
			$data['p']	     = $this->redux_auth_model->get_auth_papers($identity);
	        $data['content'] = $this->load->view('author/profile', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        
          	$this->load->vars($data);
	        $this->load->view('author/home');
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
	        $data['content'] = $this->load->view('author/att_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();	       
          	$this->load->vars($data);
	        $this->load->view('author/home');			
		}
		else
		{			
	        $identity = $this->session->userdata($this->config->item('identity'));
			$change = $this->redux_auth_model->att_reg2($identity);		
    		if ($change)
    		{	$this->session->set_flashdata('message', '<p class="success">You are registered to the conference.</p>');				
				redirect('author/status');
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
	        $data['content'] = $this->load->view('author/conf_reg', $data, true);
	        $data['status']  = $this->redux_auth->logged_in();
	        /*$data = array(
	        	'profile' => $profile['profile'],
               		'status' => $status['status'],
               		'content' => $content               		
          		);*/
          	$this->load->vars($data);
	        $this->load->view('author/home');
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

/* End of file author.php */
/* Location: ./system/application/controllers/author.php */	

