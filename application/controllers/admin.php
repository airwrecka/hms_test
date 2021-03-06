<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	
	

public function add_user(){
		$data['title'] = 'Add User';
		$this->load->model('model_users');
		$data['mail'] = '';
		$data['success'] = '';
		$data['specialists'] = $this->model_users->get_Specialists();

		if($this->session->userdata('usertype') == "ADMIN"){
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/add_user',$data);
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}		
	}
	public function view_user(){
		$data['title'] = 'View User';
		if($this->session->userdata('usertype') == "ADMIN"){
			$tmpl = array('table_open' => '<table class="table striped hovered dataTable" id="dataTables-1">');
			$this->table->set_template($tmpl);
			$this->table->set_heading('id', 'email', 'fname','lname','utype','action');
			
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/view_user');
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}		
	}
	
		//start viewclinic
	public function view_clinic(){
		$data['title'] = 'View Clinic';
		if($this->session->userdata('usertype') == "ADMIN"){
			$tmpl = array('table_open' => '<table class="table striped hovered dataTable" id="dataTables-1">');
			$this->table->set_template($tmpl);
			$this->table->set_heading('id', 'Clinic Name', 'Specialization','Room num', 'Action');
			
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/view_clinic');
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}		
	}
	//end viewclinic
	
	//start addclinic
	public function add_clinic(){
		$data['title'] = 'Add Clinic';
		$this->load->model('model_users');
		$data['success'] =' ';
		$data['specialists'] = $this->model_users->get_Specialists();
		if($this->session->userdata('usertype') == "ADMIN"){
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/add_clinic',$data);
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}	
	}
	//end addclinic

	public function addClinic_validation(){
		$data['title'] = 'Add Clinic';
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('clinicname','Clinic Name','required|trim');
		$this->form_validation->set_rules('room_num','Room num','required|trim');
		$this->load->model('model_users');
		$data['specialists'] = $this->model_users->get_Specialists();
		if($this->form_validation->run()){
			
			if($this->model_users->admin_addClinic()){
				$data['success'] = $this->ret_success_notif();
			}
		}
		else{
			$data['success'] = $this->ret_fail_notif();
		}
		$this->load->view('templates/header/header_all',$data);	
		$this->load->view('templates/header/navbar_admin');
		$this->load->view('admin/add_clinic',$data);
	}

	public function build_drop_clinic(){
		$id = $_POST['specialist'];
		$this->load->model('model_users');
		$data['clinic'] = $this->model_users->getClinicByCategory($id);
        
       $output = null;
       $output .= "<option value=''set_select('clinic', '', TRUE); disabled='disabled'> Assigned Clinic</option>";
        foreach ($data['clinic'] as $s)
        {
            $output .= "<option value='".$s->clinic_id."'>".$s->clinic_name."</option>";
        }
        $output .= "<option value='others'>Others</option>";

        echo  $output;
	}
	
	public function datatable(){
		
		$this->datatables->where('email !=',$this->session->userdata('email'));
        $this->datatables->select('id,email,fname,lname,utype')
			->add_column('action', get_buttons('$1'), 'id')
            ->from('users');
 
        echo $this->datatables->generate();
    }

    public function datatable_clinic(){
		
        $this->datatables->select('clinic.clinic_id, clinic.clinic_name, medical_specialist.specialist,clinic.room_num')
			->add_column('action', get_buttons('$1'), 'clinic.clinic_id')
            ->from('clinic')
            ->join('medical_specialist', 'medical_specialist.specialist_id = clinic.clinic_category', 'inner');
 
        echo $this->datatables->generate();
    }

    public function datatable_announcement(){
		
        $this->datatables->select('announcement.id, announcement.announcement_datetime_made, announcement.announcement_subject, clinic.clinic_name,announcement.announcement_details')
        	->unset_column('announcement.announcement_details')
			->add_column('action', get_buttons_wdetails('$1', '$2'), 'announcement.id, announcement.announcement_details')
			//->add_column('details', '<p value="$1" style="display:none;">$1</p>', 'announcement.announcement_details')
            ->from('announcement')
            ->join('clinic', 'clinic.clinic_id = announcement.fk_clinic_id', 'left');
 
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

	public function deleteClinic($id){
		$this->load->model('model_users');
		if($this->model_users->deleteClinicFromDB($id)){
			
				echo "success";
		}else{
			echo "fail";
		}	
	}

	public function deleteAnnouncement($id){
		$this->load->model('model_users');
		if($this->model_users->deleteAnnouncmentfromDb($id)){
			echo "success";
		}else{
			echo "fail";
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
	

	public function editClinicInfo(){		
		$this->load->model('model_users');
		if($this->model_users->edit_clinic()){
			echo "success";			
		}else{
			echo $this->input->post('uiD');
			echo "error";
		}	
	}

	public function editAnnouncement(){		
		$this->load->model('model_users');
		if($this->model_users->edit_announcement()){
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
		$data['title'] = 'Add User';
		$this->load->library('form_validation');	
	
		$data['mail'] = ' ';
		$data['success'] = ' ';
		$this->load->library('email');
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
			if($this->form_validation->run('user_doctor')){
				$this->email->from('hms_administrator@gmail.com',"Administrator");
				$this->email->to($this->input->post('email'));
				$this->email->subject("Your Account");
				$message  = "Hello ".$this->input->post('fname')." ".$this->input->post('lname')."!";
				$message .= "<p>The credentials for your account is ".$this->input->post('email') ."</p>";
				$message .= "<p> and the password is ".$this->input->post('password') ."</p>";	
				$this->email->message($message);
				
				//send mail to the user
				if($this->model_users->admin_addDoctor()){
					$data['success'] = $this->ret_success_notif();
					if (!$this->email->send()){
						$data['mail'] = $this->ret_failmail_notif();
					}
					else 
						$data['mail'] = $this->ret_succmail_notif(); 		
				}else
					$data['success'] = $this->ret_fail_notif();
					
			}else {}//do nothing //**}
	
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
				if($this->model_users->admin_addAdmin()){
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
		$data['specialists'] = $this->model_users->get_Specialists();
		
		
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/add_user',$data);
			$this->load->view('templates/footer/footer_admin');
	}// end of adduservalidation
	
	public function makeAnnouncement(){
		$data['success'] ='';
		$data['title'] = 'Make Announcement';
		$this->load->view('templates/header/header_all',$data);	
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

	//start view announcement
	public function view_announcement(){
		$data['title'] = 'View Announcements';
		if($this->session->userdata('usertype') == "ADMIN"){
			$tmpl = array('table_open' => '<table class="table striped hovered dataTable" id="dataTables-1">');
			$this->table->set_template($tmpl);
			$this->table->set_heading('id', 'Date and Time Made', 'Announcement Subject', 'Made From', 'Action');
			
			$this->load->view('templates/header/header_all',$data);	
			$this->load->view('templates/header/navbar_admin');
			$this->load->view('admin/view_announcement');
			$this->load->view('templates/footer/footer_admin');
		}else{
			show_404();
		}		
	}
	//end announcement



	
}//end of controller
