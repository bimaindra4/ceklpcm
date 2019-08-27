<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class User extends MX_Controller {
	function __construct() {
    	parent::__construct();
		$this->load->model("App_Model");
		$this->load->model("M_user");
    }

    function form_tambah_user() {
        $session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['namamodule'] = "user";
                $data['namafileview'] = "v-user-tambahuser";
                echo Modules::run('template/rmedik_template', $data);
			} else {
				redirect('login');
			}
		}
	}

    function form_edit_user() {
        $session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['namamodule'] = "user";
                $data['namafileview'] = "v-user-edituser";
                $data['username'] = $id_user;
                $data['iduser'] = $this->M_user->getIDRekammed($id_user);
                echo Modules::run('template/rmedik_template', $data);
			} else {
				redirect('login');
			}
		}
	}

	function tambah_user() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data = [
					"nama_user" => $this->input->post("nama"),
					"username" => $this->input->post("user"),
					"password" => sha1($this->input->post("pass")),
					"status" => $this->input->post("status")
				];

				$this->M_user->insertUser($data);
				redirect("user/form_tambah_user");
			} else {
				redirect('login');
			}
		}
	}

	function edit_user() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$id = $this->input->post("iduser");
				$user = $this->input->post("user");

				$data = [
					"username" => $user,
					"password" => sha1($this->input->post("pass"))
				];

				$this->M_user->updateUser($data,$id);
				$this->App_Model->store_session($user, 1);
				redirect("user/form_edit_user");
			} else {
				redirect('login');
			}
		}
	}
}
?>