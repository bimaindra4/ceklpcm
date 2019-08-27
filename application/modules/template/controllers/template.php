<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan!');
class Template extends MX_Controller{
	public function __construct(){
		parent::__construct();
		//$this->load->model("App_Model");
		//$this->load->model("M_template");
	}

	/*public function wakasis_template($data) {
		$session = $this->App_Model->get_session();
		$id = $session['session_userid'];
		$st = $session['session_status'];

		$data['user'] = $this->M_template->getDataUser($id,$st);
		$this->load->view('v-wakasis', $data);
	}*/

	public function rmedik_template($data) {
		$this->load->view('v-rmedik', $data);
	}

	public function rperawat_template($data) {
		$this->load->view('v-rperawat', $data);
	}
}