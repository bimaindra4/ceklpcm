<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class Pasien extends MX_Controller {
	function __construct() {
    	parent::__construct();
		$this->load->model("App_Model");
		$this->load->model("M_pasien");
    }

    function data() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$pasien = $this->M_pasien->getAllData();
				$data['pasien'] = [];
				$data['pasienAll'] = $this->M_pasien->getAllPasien();
				$data['dokter'] = $this->M_pasien->getAllDokter();
				$data['ruang_ins'] = $this->M_pasien->getAllRuang();
				$data["formri"] = $this->M_pasien->getForm();

				foreach($pasien->result() as $row) {
					$psn["id_klpcm"] = $row->id_klpcm;
					$psn["tanggal_mrs"] = $row->tanggal_mrs;

					if($row->nama_ruang == NULL) {
						$psn["indo"] = $row->dpjp;
					} else if($row->dpjp == NULL) {
						$psn["indo"] = $row->nama_ruang;
					}
					
					$psn["nama_pasien"] = $row->nama_pasien;
					$psn["no_rm"] = $row->no_rm;
					$psn["status_awal"] = ($row->status_awal == "lengkap" ? '<span class="label label-success">Lengkap</span>' : '<span class="label label-danger">Belum</span>');
					$psn["iden"] = ($row->identitas == "L" ? '<span class="label label-success">Lengkap</span>' : '<span class="label label-danger">Belum</span>');
					$psn["oten"] = ($row->otentifikasi == "L" ? '<span class="label label-success">Lengkap</span>' : '<span class="label label-danger">Belum</span>');
					$psn["lapp"] = ($row->lap_penting == "L" ? '<span class="label label-success">Lengkap</span>' : '<span class="label label-danger">Belum</span>');
					$psn["penc"] = ($row->pencatatan == "L" ? '<span class="label label-success">Lengkap</span>' : '<span class="label label-danger">Belum</span>');

					$tlf = $this->M_pasien->getDetailTLForm($row->no_rm);
					foreach($tlf->result() as $rtlf) {
						if($rtlf->keterangan == "identitas") {
							$psn["iden"] .= $rtlf->rawat_inap." / ";
						} elseif($rtlf->keterangan == "otentifikasi") {
							$psn["oten"] .= $rtlf->rawat_inap." / ";
						} elseif($rtlf->keterangan == "lap_penting") {
							$psn["lapp"] .= $rtlf->rawat_inap." / ";
						} elseif($rtlf->keterangan == "pencatatan") {
							$psn["penc"] .= $rtlf->rawat_inap." / ";
						}
					}

					$psn["iden"] = rtrim($psn["iden"]," / ");
					$psn["oten"] = rtrim($psn["oten"]," / ");
					$psn["lapp"] = rtrim($psn["lapp"]," / ");
					$psn["penc"] = rtrim($psn["penc"]," / ");

					array_push($data['pasien'], $psn);
				}

 				$data['namamodule'] = "pasien";
				$data['namafileview'] = "v-rmedik-pasien";
				echo Modules::run('template/rmedik_template', $data);
			} elseif($status == 2) {
				$data['namamodule'] = "beranda";
				$data['namafileview'] = "v-rperawat-dashboard";
				echo Modules::run('template/rperawat_template', $data);	
			} else {
				redirect('login');
			}
		}
    }
    
    function cetak() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['dokter_lap'] = $this->M_pasien->getDokterLap();
				$data['namamodule'] = "pasien";
				$data['namafileview'] = "v-rmedik-pasien-cetak";
				echo Modules::run('template/rmedik_template', $data);
			} elseif($status == 2) {
				$data['namamodule'] = "beranda";
				$data['namafileview'] = "v-rperawat-dashboard";
				echo Modules::run('template/rperawat_template', $data);	
			} else {
				redirect('login');
			}
		}
	}

	function edit_form($val) {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['pasien'] = $this->M_pasien->getDetailPasien($val);
				$data['dokter'] = $this->M_pasien->getAllDokter();
				$data['ruang'] = $this->M_pasien->getAllRuang();
				$data['namamodule'] = "pasien";
				$data['namafileview'] = "v-rmedik-pasien-edit";
				echo Modules::run('template/rmedik_template', $data);
			} else {
				redirect('login');
			}
		}
	}

	function tambah_rm() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$id = $this->input->post("norm");

				$ri = [
					"iden" => [
						"dokumen" => $this->input->post('iden'),
						"data" => $this->input->post('tl_identitas')
					], "oten" => [
						"dokumen" => $this->input->post("oten"),
						"data" => $this->input->post('tl_otentifikasi')
					], "lap" => [
						"dokumen" => $this->input->post("lap"),
						"data" => $this->input->post("tl_laporan")
					], "catat" => [
						"dokumen" => $this->input->post("catat"),
						"data" => $this->input->post("tl_pencatatan")
					]
				];

				$this->M_pasien->insertPasien($id);
				$this->M_pasien->insertRM();
				$this->M_pasien->insertRawatInap($ri);
				//redirect("pasien/data");
			} elseif($status == 2) {

			} else {
				redirect('login');
			}
		}
	}

	function edit_pasien($val) {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$this->M_pasien->editPasien($val);

				redirect("pasien/data");
			} elseif($status == 2) {

			} else {
				redirect('login');
			}
		}
	}

	function hapus_pasien($val) {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$this->M_pasien->deletePasien($val);
		
				redirect("pasien/data");
			} elseif($status == 2) {

			} else {
				redirect('login');
			}
		}
	}

	function f_edit_pasien($val) {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['pasien'] = $this->M_pasien->getSelectedData($val);
				$data['namamodule'] = "pasien";
				$data['namafileview'] = "v-rmedik-pasien-edit";
				echo Modules::run('template/rmedik_template', $data);
			} else {
				redirect('login');
			}
		}
	}

	function import_pasien() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'xls';
				$config['max_size'] = 10240; // 10 MB
				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('import')) {
					$error = array('error' => $this->upload->display_errors());
				} else {
					$upload_data = $this->upload->data();
					$this->load->library('Excel_reader');

					// File configuration
					$this->excel_reader->setOutputEncoding('230787');
					$file = $upload_data['full_path'];
					$this->excel_reader->read($file);
					error_reporting(E_ALL ^ E_NOTICE);

					// Data
					$data = $this->excel_reader->sheets[0];
					$dataExcel = array();
					for($i=2; $i<=$data['numRows']; $i++) {
						if($data['cells'][$i][1] == '') {
							break;
						}

						$dataExcel[$i-2]['nama_pasien'] = $data['cells'][$i][2];
						$dataExcel[$i-2]['tggl_mrs'] = $data['cells'][$i][3];
						$dataExcel[$i-2]['no_rm'] = $data['cells'][$i][4];
						$dataExcel[$i-2]['instalasi'] = $data['cells'][$i][5];
						$dataExcel[$i-2]['dokter1'] = $data['cells'][$i][6];
						$dataExcel[$i-2]['dokter2'] = $data['cells'][$i][7];
						$dataExcel[$i-2]['ruang'] = $data['cells'][$i][8];
					}

					$this->M_pasien->generateData($dataExcel);

					// Delete file
					$file = $upload_data['file_name'];
					$path = './uploads/'.$file;
					unlink($path);
				}

				redirect("pasien/data");
			} else {
				redirect('login');
			}
		}
	}

	function showData() {
		// Set timezone
   		date_default_timezone_set("Asia/Jakarta");
   		
		$sort = $this->input->post('sortData'); 
		$taw = $this->input->post('tanggal_awal');
		$tak = $this->input->post('tanggal_akhir');

	    if($sort == "dokter") {
	    	if($this->input->post('taw') == "" || $this->input->post('tak') == "") {
		        $data = $this->M_pasien->getDokterLap();
		    } else {
		        $taw = date("Y-m-d", strtotime($this->input->post('taw')));
		        $tak = date("Y-m-d", strtotime($this->input->post('tak')));

		        $data = $this->M_pasien->getDokterLap($taw,$tak);
		    }

	    	$no = 1;
	    	foreach($data as $row) {
	    		echo '
		            <tr class="odd gradeX">
		                <td width="50">'.$no.'</td>
		                <td width="200">'.$row['nama_dokter'].'</td>
		                <td width="50" class="text-center">'.$row['total_drm'].'</td>
		                <td width="50" class="text-center">'.$row['drm_lengkap'].'</td>
		                <td width="50" class="text-center">'.$row['drm_tdk_lengkap'].'</td>
		                <td width="50" class="text-center">'.$row['iden'].'</td>
                        <td width="50" class="text-center">'.$row['oten'].'</td>
                        <td width="50" class="text-center">'.$row['lapp'].'</td>
                        <td width="50" class="text-center">'.$row['catat'].'</td>
		                <td width="50" class="text-center">'.$row['persen_lengkap'].' %</td>
		                <td width="50" class="text-center">'.$row['persen_tdk_lengkap'].' %</td>
		            </tr>';

	        	$no++;
	    	}
	    } else if($sort == "ruang") {
	    	if($this->input->post('taw') == "" || $this->input->post('tak') == "") {
		        $data = $this->M_pasien->getRuangLap();
		    } else {
		        $taw = date("Y-m-d", strtotime($this->input->post('taw')));
		        $tak = date("Y-m-d", strtotime($this->input->post('tak')));

		        $data = $this->M_pasien->getRuangLap($taw,$tak);
		    }

	    	$no = 1;
	    	foreach($data as $row) {
	    		echo '
		            <tr class="odd gradeX">
		                <td width="50">'.$no.'</td>
		                <td width="100">'.$row['nama_ruang'].'</td>
		                <td width="50" class="text-center">'.$row['total_drm'].'</td>
		                <td width="50" class="text-center">'.$row['drm_lengkap'].'</td>
		                <td width="50" class="text-center">'.$row['drm_tdk_lengkap'].'</td>
		                <td width="50" class="text-center">'.$row['iden'].'</td>
                        <td width="50" class="text-center">'.$row['oten'].'</td>
                        <td width="50" class="text-center">'.$row['lapp'].'</td>
                        <td width="50" class="text-center">'.$row['catat'].'</td>
		                <td width="50" class="text-center">'.$row['persen_lengkap'].' %</td>
		                <td width="50" class="text-center">'.$row['persen_tdk_lengkap'].' %</td>
		            </tr>';

	        	$no++;
	    	}
	    }
	}

	function get_pasien_by_norm($id) {
		$res = $this->M_pasien->getPasienByNoRM($id);
		echo json_encode($res);
	}
}
?>