<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class Beranda extends MX_Controller {
	function __construct() {
    	parent::__construct();
		$this->load->model("App_Model");
		$this->load->model("M_beranda");
	}

	function index() {
		$session = $this->App_Model->get_session();
		if (!$session['session_userid'] && !$session['session_status']){
			redirect('login');
		} else {
			$id_user = $session['session_userid'];
			$status = $session['session_status'];
			if($status == 1) {
				$data['numPasien'] = $this->M_beranda->getNumPasien();
				$data['numDokter'] = $this->M_beranda->getNumDokter();
				$data['numRMLengkap'] = $this->M_beranda->getNumRMLengkap();
				$data['numRMTidakLengkap'] = $this->M_beranda->getNumRMTidakLengkap();

				$data['namamodule'] = "beranda";
				$data['namafileview'] = "v-rmedik-beranda";
				echo Modules::run('template/rmedik_template', $data);	
			} elseif($status == 2) {
				$data['dokter_lap'] = $this->M_beranda->getDokterLap();
				$data['ruangan'] = $this->M_beranda->getRuangan();
				$data['namamodule'] = "beranda";
				$data['namafileview'] = "v-rperawat-dashboard";
				echo Modules::run('template/rperawat_template', $data);	
			} else {
				redirect('login');
			}
		}
	}

	function getDetailRM() {
		$id_dosen = $this->input->post("id_dosen");
		$nama_dosen = $this->input->post("nama_dosen");
		
		$rm = $this->M_beranda->getDetailRM($id_dosen);
		if($rm->num_rows() == 0) {
			echo '<h3 align="center">Data Tidak Ada</h3>';
		} else {
			foreach($rm->result() as $row) {
				$iden = "";
				$oten = "";
				$lapp = "";
				$penc = "";

				$tlf = $this->M_beranda->getDetailTLForm($row->no_rm);
				foreach($tlf->result() as $rtlf) {
					if($rtlf->keterangan == "identitas") {
						$iden .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "otentifikasi") {
						$oten .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "lap_penting") {
						$lapp .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "pencatatan") {
						$penc .= $rtlf->rawat_inap." / ";
					}
				}


				echo '
	                <p><b>RM '.$row->no_rm.'</b></p>
	                <table class="table table-bordered">
                        <tr>
                            <th width="150">Identitas</th>
                            <td>'.rtrim($iden," / ").'</td>
                        </tr>
                        <tr>
                            <th width="150">Otentifikasi</th>
                            <td>'.rtrim($oten," / ").'</td>
                        </tr>
                        <tr>
                            <th width="150">Lap. Penting</th>
                            <td>'.rtrim($lapp," / ").'</td>
                        <tr>
                            <th width="150">Pencatatan</th> 
                            <td>'.rtrim($penc," / ").'</td>
                        </tr>
	                </table>
	                <hr>
				';
			}
		}
	}

	function getSearchByRM() {
		$rm = $this->input->post('rm');
		$q = $this->M_beranda->getRMFromRM($rm);
		$tl = $this->M_beranda->getDetailTLForm($rm);

		$iden = "";
		$oten = "";
		$lapp = "";
		$penc = "";

		$tlf = $this->M_beranda->getDetailTLForm($rm);
		foreach($tlf->result() as $rtlf) {
			if($rtlf->keterangan == "identitas") {
				$iden .= $rtlf->rawat_inap." / ";
			} elseif($rtlf->keterangan == "otentifikasi") {
				$oten .= $rtlf->rawat_inap." / ";
			} elseif($rtlf->keterangan == "lap_penting") {
				$lapp .= $rtlf->rawat_inap." / ";
			} elseif($rtlf->keterangan == "pencatatan") {
				$penc .= $rtlf->rawat_inap." / ";
			}
		}

		if($q->num_rows != 0) {
			$q = $q->row();
			echo '
				<table class="table table-striped table-bordered table-hover">
					<thead>
		                <tr>
		                    <th>RM</th>
		                    <th>Dokter</th>
		                    <th>Identitas</th>
		                    <th>Otentifikasi</th>
		                    <th>Lap. Penting</th>
		                    <th>Pencatatan</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr class="odd gradeX">
		                    <td width="50">'.$rm.'</td>
		                    <td width="250">'.$q->dpjp.'</td>
		                    <td width="150">'.rtrim($iden," / ").'</td>
		                    <td width="150">'.rtrim($oten," / ").'</td>
		                    <td width="150">'.rtrim($lapp," / ").'</td>
		                    <td width="150">'.rtrim($penc," / ").'</td>
		                </tr>
		            </tbody>
	            </table>
			';
		} else {
			echo '
				<table class="table table-striped table-bordered table-hover">
					<thead>
		                <tr>
		                    <th>RM</th>
		                    <th>Dokter</th>
		                    <th>Identitas</th>
		                    <th>Otentifikasi</th>
		                    <th>Lap. Penting</th>
		                    <th>Pencatatan</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr class="odd gradeX">
		                    <td colspan="6" align="center">Data Kosong</td>
		                </tr>
		            </tbody>
	            </table>
			';
		}
	}

	function getSearchByRuang() {
		$ruang = $this->input->post('ruang');
		$q = $this->M_beranda->getRMFromRuang($ruang);

		if($q->num_rows() != 0) {
			$iden = "";
			$oten = "";
			$lapp = "";
			$penc = "";

			echo '
				<table class="table table-striped table-bordered table-hover" id="sample_3">
					<thead>
		                <tr>
		                    <th>RM</th>
		                    <th>Dokter</th>
		                    <th>Identitas</th>
		                    <th>Otentifikasi</th>
		                    <th>Lap. Penting</th>
		                    <th>Pencatatan</th>
		                </tr>
		            </thead>
		            <tbody>
			';

			foreach($q->result() as $row) {
				$tlf = $this->M_beranda->getDetailTLForm($row->no_rm);
				
				foreach($tlf->result() as $rtlf) {
					if($rtlf->keterangan == "identitas") {
						$iden .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "otentifikasi") {
						$oten .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "lap_penting") {
						$lapp .= $rtlf->rawat_inap." / ";
					} elseif($rtlf->keterangan == "pencatatan") {
						$penc .= $rtlf->rawat_inap." / ";
					}
				}

				echo '
	                <tr class="odd gradeX">
	                    <td width="50">'.$row->no_rm.'</td>
	                    <td width="250">'.$row->dpjp.'</td>
	                    <td width="120">'.rtrim($iden," / ").'</td>
	                    <td width="120">'.rtrim($oten," / ").'</td>
	                    <td width="120">'.rtrim($lapp," / ").'</td>
	                    <td width="120">'.rtrim($penc," / ").'</td>
	                </tr>
				';
			}

			echo '</tbody></table>';
		} else {
			echo '
				<table class="table table-striped table-bordered table-hover">
					<thead>
		                <tr>
		                    <th>RM</th>
		                    <th>Dokter</th>
		                    <th>Identitas</th>
		                    <th>Otentifikasi</th>
		                    <th>Lap. Penting</th>
		                    <th>Pencatatan</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr class="odd gradeX">
		                    <td colspan="6" align="center">Data Kosong</td>
		                </tr>
		            </tbody>
	            </table>
			';
		}
	}
}