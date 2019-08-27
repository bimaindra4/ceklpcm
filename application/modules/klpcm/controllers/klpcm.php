<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class Klpcm extends MX_Controller {
	function __construct() {
    	parent::__construct();
		$this->load->model("App_Model");
		$this->load->model("M_klpcm");
    }

    function cek_data() {
        $session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['namamodule'] = "klpcm";
                $data['namafileview'] = "v-rmedik-klpcm-cekdata";
                echo Modules::run('template/rmedik_template', $data);
			} elseif($status == 2) {

			} else {
				redirect('login');
			}
		}
	}
    
    function hasil_klpcm($id = "") {
        $session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				if($id == "") {
		        	$val = $this->input->post('cari');
				} else {
					$val = $id;
				}

		        $data = [
		        	"klpcm" => $this->M_klpcm->getNoRM($val),
		        	"dokter" => $this->M_klpcm->getDokter(),
		        	"formri" => $this->M_klpcm->getForm(),
		        	"ruang" => $this->M_klpcm->getRuang(),
		        	"tl_identitas" => $this->M_klpcm->getFormTL($val, "identitas"),
		        	"tl_otentifikasi" => $this->M_klpcm->getFormTL($val, "otentifikasi"),
		        	"tl_laporan" => $this->M_klpcm->getFormTL($val, "lap_penting"),
		        	"tl_pencatatan" => $this->M_klpcm->getFormTL($val, "pencatatan")
		        ];

                $data['namamodule'] = "klpcm";
                $data['namafileview'] = "v-rmedik-klpcm-hasil";
                echo Modules::run('template/rmedik_template', $data);
			} elseif($status == 2) {

			} else {
				redirect('login');
			}
		}
	}

	function update_form_tl($id) {
		// Update Keterangan Rekam Medik
		$f_iden = $this->input->post('f_identitas');
		$f_oten = $this->input->post('f_otentifikasi');
		$f_lap = $this->input->post('f_laporan');
		$f_catat = $this->input->post('f_pencatatan');

		$data = [
			"identitas" => $f_iden,
			"otentifikasi" => $f_oten,
			"lap_penting" => $f_lap,
			"pencatatan" => $f_catat
		];

		$this->M_klpcm->updateFormRM($data,$id);

		// Insert Form Tidak Lengkap
		$iden = $this->input->post('identitas');
		$oten = $this->input->post('otentifikasi');
		$lap = $this->input->post('laporan');
		$catat = $this->input->post('pencatatan');

		if($f_iden == "L") {
			$this->M_klpcm->deleteFormTL($id, "identitas");
		} else {
			($iden != '') ? $this->M_klpcm->insertFormTL($id, $iden, "identitas") : null;
		}

		if($f_oten == "L") {
			$this->M_klpcm->deleteFormTL($id, "otentifikasi");
		} else {
			($oten != '') ? $this->M_klpcm->insertFormTL($id, $oten, "otentifikasi") : null;
		}
		
		if($f_lap == "L") {
			$this->M_klpcm->deleteFormTL($id, "lap_penting");
		} else {
			($lap != '') ? $this->M_klpcm->insertFormTL($id, $lap, "lap_penting") :  null;
		}
		
		if($f_catat == "L") {
			$this->M_klpcm->deleteFormTL($id, "pencatatan");
		} else {
			($catat != '') ? $this->M_klpcm->insertFormTL($id, $catat, "pencatatan") : null;
		}
	}
}
?>