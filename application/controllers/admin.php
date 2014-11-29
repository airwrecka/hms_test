<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	
	

public function add_user(){
	
$data['mail'] = '';
$data['success'] = '';

		if($this->session->userdata('usertype') == "ADMIN"){
			$this->load->view('templates/header/header_all');
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/add_user',$data);
		}else{
			show_404();
		}		
	}
	public function view_user(){
		if($this->session->userdata('usertype') == "ADMIN"){
			$tmpl = array('table_open' => '<table class="table striped hovered dataTable" id="dataTables-1">');
			$this->table->set_template($tmpl);
			$this->table->set_heading('id', 'email', 'fname','lname','utype','action');
			
			$this->load->view('templates/header/header_all');
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/view_user');
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}		
	}
	
	public function datatable(){
        $this->datatables->select('id,email,fname,lname,utype')
			->add_column('action', get_buttons('$1'), 'id')
            ->from('users');
 
        echo $this->datatables->generate();
    }
	
	public function deleteUser($id){
		$this->load->model('model_users');
		if($this->model_users->deleteUserFromDB($id)){
			
				echo "success";
		}else{
			echo "invalid id";
		}	
	}
	
	public function editUserInfo(){
		
		$this->load->model('model_users');
		
		if($this->model_users->edit_user()){
					echo "success";
					
		}else{
			echo $this->input->post('uiD');
			echo "error";
		}	
	
	}
	
	public function ret_success_notif(){
		
		return "<script>var not = $.Notify({
				 	style: {background: 'green', color: 'white'},
    				caption: 'DATABASE',
       				content: 'add to database success!!!',
      			  	timeout: 10000 // 10 seconds
						});
					
					</script>";
		
	}
	
	public function ret_fail_notif(){
		
		return "<script>var not = $.Notify({
				 	style: {background: 'RED', color: 'white'},
    				caption: 'DATABASE',
       				content: 'add to database FAIL!!!',
      			  	timeout: 10000 // 10 seconds
						});
					
					</script>";
		
	}
	
	
	public function ret_failmail_notif(){
		return "<script>var not = $.Notify({
				 	style: {background: 'red', color: 'white'},
    				caption: 'MAIL FAIL',
       				content: 'SEND to EMAIL  FAIL!!!',
      			  	timeout: 10000 // 10 seconds
						});
					
					</script>";
	}
	
	public function ret_succmail_notif(){
	 return "<script>var not = $.Notify({
				 	style: {background: '#00EEFF', color: 'white'},
    				caption: 'MAIL SUCCESS',
       				content: 'SEND to EMAIL  SUCCESS!!!',
      			  	timeout: 10000 // 10 seconds
						});
					
					</script>";	
	}	
	public function addUser_validation(){
		$this->load->library('form_validation');	
			$config = array(
					'mailtype' => 'html',
				);		
				
		$data['mail'] = ' ';
		$data['success'] = ' ';
		$this->load->library('email', $config);
		$this->load->model('model_users');	
		

		
		if($this->input->post('utype') == 1){//user	
			if($this->form_validation->run('user_patient')){		
				$this->email->from('hms_administrator@gmail.com',"Administrator");
				$this->email->to($this->input->post('email'));
				$this->email->subject("Your Account");
				$message  = "Hello ".$this->input->post('fname')." ".$this->input->post('lname')."!";
				$message .= "<p>The credentials for your account is ".$this->input->post('email') ."</p>";
				$message .= "<p> and the password is ".$this->input->post('password') ."</p>";	
				$this->email->message($message);
				
				//send mail to the user
				if($this->model_users->admin_addUser()){
					$data['success'] = $this->ret_success_notif();
					if (!$this->email->send()){
						$data['mail'] = $this->ret_failmail_notif();
					}
					else 
						$data['mail'] = $this->ret_succmail_notif(); 		
				}else
					$data['success'] = $this->ret_fail_notif();
					
			}else {}//do nothing //**}
	
		}else if($this->input->post('utype') == 2){//doctor
	
		}else if($this->input->post('utype') == 3){//admin
			if($this->form_validation->run('users')){		
				$this->email->from('hms_administrator@gmail.com',"Administrator");
				$this->email->to($this->input->post('email'));
				$this->email->subject("Your Account");
				$message  = "Hello ".$this->input->post('fname')." ".$this->input->post('lname')."!";
				$message .= "<p>The credentials for your account is ".$this->input->post('email') ."</p>";
				$message .= "<p> and the password is ".$this->input->post('password') ."</p>";	
				$this->email->message($message);
				
					//send mail to the user
				if($this->model_users->admin_addUser()){
					$data['success'] = $this->ret_success_notif();
					if (!$this->email->send()){
						$data['mail'] = $this->ret_failmail_notif();
					}
					else 
						$data['mail'] = $this->ret_succmail_notif(); 		
				}else{
					$data['success'] = $this->ret_fail_notif();
				}	
			
			}else{
			  //do nothing
		
			}			
		}
		$this->load->view('templates/header/header_all');
		$this->load->view('templates/header/navbar_admin');
		$this->load->view('admin/admin',$data);
	}
	
	public function makeAnnouncement(){
		$this->load->view('templates/header/header_all');
		$this->load->view('templates/header/navbar_admin');
		$this->load->view('makeAnnouncement');	
	}
	
	public function makeAnnouncement_validation(){
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('subject','Subject','required|trim');
		$this->form_validation->set_rules('details','Details','required|trim');
		
		if($this->form_validation->run()){
			$this->load->model('model_users');
			if($this->model_users->addAnnouncement()){
				echo "Successfully added";
		}
		}
		else{
			
			$this->makeAnnouncement();
		}
		
	}



	
}//end of controller