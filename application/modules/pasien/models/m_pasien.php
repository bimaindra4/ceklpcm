<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class M_pasien extends CI_Model {
	public function __construct() {
		parent::__construct();
    }
    
    function getAllData() {
        $this->db->select("rm.*,
                           r.nama_ruang AS nama_ruang, 
                           d.nama_dokter AS dpjp, 
                           p.nama_pasien");
        $this->db->join("rekam_medis rm", "p.no_rm = rm.no_rm");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter", "left");
        $this->db->join("ruang r", "rm.id_ruang = r.id_ruang", "left");
        $this->db->order_by("rm.tanggal_mrs", "desc");
        $db = $this->db->get("pasien p");
        return $db;
    }

    function getSelectedData($val) {
        $this->db->where("id_pasien", $val);
        $db = $this->db->get("pasien");
        return $db;
    }

    function getDetailPasien($val) {
        $this->db->select("p.*, d.nama_dokter AS dpjp, rm.id_ruang");
        $this->db->join("rekam_medis rm", "p.id_pasien = rm.id_pasien");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter");
        $this->db->where("p.id_pasien", $val);
        $db = $this->db->get("pasien p");
        return $db->row();
    }

    function getAllPasien() {
        $db = $this->db->get("pasien");
        return $db;
    }

    function getAllDokter() {
        $db = $this->db->get("dokter");
        return $db;
    }

    function getAllRuang() {
        $db = $this->db->get("ruang");
        return $db;
    }

    function getForm() {
        $db = $this->db->get("form_rawat_inap");
        return $db;
    }

    function getDetailTLForm($id) {
        $this->db->select("tri.*, fri.rawat_inap");
        $this->db->join("form_rawat_inap fri", "tri.id_rawat_inap = fri.id_inap");
        $this->db->where("tri.id_klpcm", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $q;
    }

    function getDetailTLForm_Dokter($id) {
        $this->db->select("tri.*, fri.rawat_inap");
        $this->db->join("form_rawat_inap fri", "tri.id_rawat_inap = fri.id_inap");
        $this->db->join("rekam_medis rm", "tri.no_rm = rm.no_rm");
        $this->db->where("rm.instalasi_dpjp", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $q;
    }

    function getDetailTLForm_Ruang($id) {
        $this->db->select("tri.*, fri.rawat_inap");
        $this->db->join("form_rawat_inap fri", "tri.id_rawat_inap = fri.id_inap");
        $this->db->join("rekam_medis rm", "tri.no_rm = rm.no_rm");
        $this->db->where("rm.id_ruang", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $query;
    }

    function getDokterLap($taw="",$tak="") {
        $l = "L";
        $tl = "T";
        $dat = [];

        $this->db->select("d.id_dokter, d.nama_dokter, COUNT(rm.no_rm) AS total_drm");
        $this->db->from("rekam_medis rm");
        $this->db->join("dokter d", "rm.instalasi_dpjp = d.id_dokter", "right");

        if($taw != "" || $tak != "") {
            $this->db->join("pasien p", "rm.no_rm = p.no_rm");
            $this->db->where("tanggal_mrs <=", "$tak");
            $this->db->where("tanggal_mrs >=", "$taw");
        }

        $this->db->group_by("d.id_dokter");
        $this->db->order_by("d.id_dokter");
        $db = $this->db->get();

        foreach($db->result() as $row) {
            if($taw != "" || $tak != "") {
                // Hitung DRM Lengkap
                $this->db->select("
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.identitas='$l' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.otentifikasi='$l' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.lap_penting='$l' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.pencatatan='$l' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak') AS lengkap
                ");
                $this->db->from("rekam_medis");
                $drm_lkp = $this->db->get()->row()->lengkap;

                $this->db->select("
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.identitas='$tl' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.otentifikasi='$tl' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.lap_penting='$tl' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.pencatatan='$tl' AND rm.instalasi_dpjp=$row->id_dokter AND p.tanggal_mrs BETWEEN '$taw' AND '$tak') AS tdklengkap
                ");
                $this->db->from("rekam_medis");
                $drm_tlkp = $this->db->get()->row()->tdklengkap;
            } else {
                // Hitung DRM Lengkap
                $this->db->select("
                    (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$l' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$l' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$l' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$l' AND instalasi_dpjp=$row->id_dokter) AS lengkap
                ");
                $this->db->from("rekam_medis");
                $drm_lkp = $this->db->get()->row()->lengkap;

                // Hitung DRM Tidak Lengkap
                $this->db->select("
                    (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$tl' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$tl' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$tl' AND instalasi_dpjp=$row->id_dokter)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$tl' AND instalasi_dpjp=$row->id_dokter) AS tdklengkap
                ");
                $this->db->from("rekam_medis");
                $drm_tlkp = $this->db->get()->row()->tdklengkap;
            }

            // Persentase
            if($drm_lkp == 0 && $drm_tlkp == 0) {
                $total_drm = 0;
                $p_lkp = "0";
                $p_tlkp = "0";
            } else {
                $total_drm = $drm_lkp + $drm_tlkp;
                $p_lkp = round(($drm_lkp * 100) / $total_drm, 2); // presentas drm lengkap
                $p_tlkp =  round(($drm_tlkp * 100) / $total_drm, 2); // presentas drm lengkap
            }

            // Get Detail Form
            $iden = "";
            $oten = "";
            $lapp = "";
            $catat = "";

            $tlf = $this->getDetailTLForm_Dokter($row->id_dokter);
            foreach($tlf->result() as $rtlf) {
                if($rtlf->keterangan == "identitas") {
                    $iden .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "otentifikasi") {
                    $oten .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "lap_penting") {
                    $lapp .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "pencatatan") {
                    $catat .= $rtlf->rawat_inap." / ";
                }
            }

            $data = [
                "nama_dokter" => $row->nama_dokter,
                "total_drm" => 4*$row->total_drm,
                "drm_lengkap" => $drm_lkp,
                "drm_tdk_lengkap" => $drm_tlkp,
                "persen_lengkap" => $p_lkp,
                "persen_tdk_lengkap" => $p_tlkp,
                "iden" => rtrim($iden, " / "),
                "oten" => rtrim($oten, " / "),
                "lapp" => rtrim($lapp, " / "),
                "catat" => rtrim($catat, " / ")
            ];

            array_push($dat, $data);
        }

        return $dat;
    }

    function getRuangLap($taw="",$tak="") {
        $l = "L";
        $tl = "T";
        $dat = [];

        $this->db->select("r.id_ruang, r.nama_ruang, COUNT(rm.no_rm) AS total_drm");
        $this->db->join("ruang r", "rm.id_ruang = r.id_ruang", "right");

        if($taw != "" || $tak != "") {
            $this->db->join("pasien p", "rm.no_rm = p.no_rm");
            $this->db->where("tanggal_mrs <=", "$tak");
            $this->db->where("tanggal_mrs >=", "$taw");
        }

        $this->db->group_by("r.id_ruang");
        $this->db->order_by("r.id_ruang");
        $db = $this->db->get('rekam_medis rm');

        foreach($db->result() as $row) {
            if($taw != "" || $tak != "") {
                // Hitung DRM Lengkap
                $this->db->select("
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.identitas='$l' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.otentifikasi='$l' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.lap_penting='$l' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.pencatatan='$l' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak') AS lengkap
                ");
                $this->db->from("rekam_medis");
                $drm_lkp = $this->db->get()->row()->lengkap;

                // Hitung DRM Tidak Lengkap
                $this->db->select("
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.identitas='$tl' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.otentifikasi='$tl' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.lap_penting='$tl' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak')+
                    (SELECT COUNT(rm.no_rm) FROM rekam_medis rm JOIN pasien p ON rm.no_rm = p.no_rm WHERE rm.pencatatan='$tl' AND rm.id_ruang=$row->id_ruang AND p.tanggal_mrs BETWEEN '$taw' AND '$tak') AS tdklengkap
                ");
                $this->db->from("rekam_medis");
                $drm_tlkp = $this->db->get()->row()->tdklengkap;
            } else {
                // Hitung DRM Lengkap
                $this->db->select("
                    (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$l' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$l' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$l' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$l' AND id_ruang=$row->id_ruang) AS lengkap
                ");
                $this->db->from("rekam_medis");
                $drm_lkp = $this->db->get()->row()->lengkap;

                // Hitung DRM Tidak Lengkap
                $this->db->select("
                    (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$tl' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$tl' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$tl' AND id_ruang=$row->id_ruang)+
                    (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$tl' AND id_ruang=$row->id_ruang) AS tdklengkap
                ");
                $this->db->from("rekam_medis");
                $drm_tlkp = $this->db->get()->row()->tdklengkap;
            }

            // Persentase
            if($drm_lkp == 0 && $drm_tlkp == 0) {
                $total_drm = 0;
                $p_lkp = "0";
                $p_tlkp = "0";
            } else {
                $total_drm = $drm_lkp + $drm_tlkp;
                $p_lkp = round(($drm_lkp * 100) / $total_drm, 2); // presentase drm lengkap
                $p_tlkp =  round(($drm_tlkp * 100) / $total_drm, 2); // presentase drm tidak lengkap
            }

            // Get Detail Form
            $iden = "";
            $oten = "";
            $lapp = "";
            $catat = "";

            $tlf = $this->getDetailTLForm_Ruang($row->id_ruang);
            foreach($tlf->result() as $rtlf) {
                if($rtlf->keterangan == "identitas") {
                    $iden .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "otentifikasi") {
                    $oten .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "lap_penting") {
                    $lapp .= $rtlf->rawat_inap." / ";
                } elseif($rtlf->keterangan == "pencatatan") {
                    $catat .= $rtlf->rawat_inap." / ";
                }
            }

            $data = [
                "nama_ruang" => $row->nama_ruang,
                "total_drm" => 4*$row->total_drm,
                "drm_lengkap" => $drm_lkp,
                "drm_tdk_lengkap" => $drm_tlkp,
                "persen_lengkap" => $p_lkp,
                "persen_tdk_lengkap" => $p_tlkp,
                "iden" => rtrim($iden, " / "),
                "oten" => rtrim($oten, " / "),
                "lapp" => rtrim($lapp, " / "),
                "catat" => rtrim($catat, " / ")
            ];

            array_push($dat, $data);
        }

        return $dat;
    }

    function insertPasien($id) {
        // search pasien
        $this->db->select("*");
        $this->db->where("no_rm", $id);
        $scr = $this->db->get("pasien");
        $num_scr = $scr->num_rows();

		// insert to pasien
        if($num_scr == 0) {
            $data = array(
                "no_rm" => $id,
                "nama_pasien" => strtoupper($this->input->post("nama_pasien")),
            );

            $db = $this->db->insert("pasien", $data);
            ($db) ? $out=true : $out=false;
        } else {
            $out = false;
        }
        
        return $out;
    }

    function insertRM() {
        // Set date
        date_default_timezone_set("Asia/Jakarta");
        $tgl_now = $this->input->post("tglskrg");
        if($tgl_now == "1") {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d", strtotime($this->input->post("tglmrs")));
        }

        $dpjp = ($this->input->post("dpjp") == "" ? NULL : $this->input->post("dpjp"));
        $ruang = ($this->input->post("ruang") == "" ? NULL : $this->input->post("ruang"));

		// insert to rekam_medik
		$data = array(
            "id_klpcm" => "",
			"no_rm" => $this->input->post("norm"),
            "tanggal_mrs" => $date,
			"dpjp" => $dpjp,
            "id_ruang" => $ruang,
            "status_awal" => $this->input->post("status_awal"),
			"identitas" => $this->input->post("iden"),
			"otentifikasi" => $this->input->post("oten"),
			"lap_penting" => $this->input->post("lap"),
			"pencatatan" => $this->input->post("catat")
        );

        $db = $this->db->insert("rekam_medis", $data);
        $out = ($db ? true : false);
        return $out;
    }

    function insertRawatInap($data) {
        if($data['iden']['dokumen'] == "T") {
            foreach($data['iden']['data'] as $row) {
                $data = [
                    "id_rawat_inap" => $row,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "identitas"
                ];

                $this->db->insert("tl_rawat_inap", $data);
            }
        }

        if($data['oten']['dokumen'] == "T") {
            foreach($data['oten']['data'] as $row) {
                $data = [
                    "id_rawat_inap" => $row,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "otentifikasi"
                ];

                $this->db->insert("tl_rawat_inap", $data);
            }
        }

        if($data['lap']['dokumen'] == "T") {
            foreach($data['lap']['data'] as $row) {
                $data = [
                    "id_rawat_inap" => $row,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "lap_penting"
                ];

                $this->db->insert("tl_rawat_inap", $data);
            }
        }

        if($data['catat']['dokumen'] == "T") {
            foreach($data['catat']['data'] as $row) {
                $data = [
                    "id_rawat_inap" => $row,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "pencatatan"
                ];

                $this->db->insert("tl_rawat_inap", $data);
            }
        }
    }
    
    function editPasien($val) {
        // Set timezone
        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d", strtotime($this->input->post("tglmrs")));

        $dat1 = array(
            "nama_pasien" => $this->input->post("nama"),
        );

        $this->db->update("pasien", $dat1, array("id_pasien" => $val));

        $dat2 = array(
            "id_ruang" => $this->input->post('ruang')
        );

        $this->db->update("rekam_medis", $dat2, array("no_rm" => $this->input->post("no_rm")));
    }

    function deletePasien($val) {
        // $val = id_pasien
        // get no_rm from pasien
        $this->db->select("no_rm");
        $this->db->from("pasien");
        $this->db->where("id_pasien", $val);
        $getId = $this->db->get()->row();
        $no_rm = $getId->no_rm;

        // delete pasien
        $this->db->delete("pasien", array("id_pasien" => $val));

        // delete rekam_medis
        $this->db->delete("rekam_medis", array("no_rm" => $no_rm));
    }

    function generateData($val) {
        // Set timezone
        date_default_timezone_set("Asia/Jakarta");

        for($i=0; $i<count($val); $i++) {
            // create dokter_1 & dokter_2
            ($val[$i]['dokter1'] == "-") ? $d1 = NULL : $d1 = $val[$i]['dokter1'];
            ($val[$i]['dokter2'] == "-") ? $d2 = NULL : $d2 = $val[$i]['dokter2'];

            $dpjp = $this->getIDDokter($val[$i]['instalasi']);
            $d1 = $this->getIDDokter($d1);
            $d2 = $this->getIDDokter($d2);
            $ruang = $this->getIDRuang($val[$i]['ruang']);

            // insert to rekam_medik
            $dat1 = array(
                "no_rm" => $val[$i]['no_rm'],
                "instalasi_dpjp" => $dpjp,
                "dokter_1" => $d1,
                "dokter_2" => $d2,
                "id_ruang" => $ruang,
                "identitas" => NULL,
                "otentifikasi" => NULL,
                "lap_penting" => NULL,
                "pencatatan" => NULL
            );
            
            $this->db->insert("rekam_medis", $dat1);

            // insert to pasien
            $dat2 = array(
                "nama_pasien" => strtoupper($val[$i]['nama_pasien']),
                "tanggal_mrs" => date("Y-m-d", strtotime($val[$i]['tggl_mrs'])),
                "no_rm" => $val[$i]['no_rm']
            );

            //var_dump($val[$i]['tggl_mrs']);
            
            $db = $this->db->insert("pasien", $dat2);
        }
    }

    function getIDDokter($nama) {
        $this->db->select("id_dokter");
        $this->db->where("nama_dokter", $nama);
        $db = $this->db->get("dokter");

        if($db->num_rows == 0) {
            return NULL;
        } else {
            $res = $db->row();
            return $res->id_dokter;
        }
    }

    function getIDRuang($nama) {
        $this->db->select("id_ruang");
        $this->db->where("nama_ruang", $nama);
        $db = $this->db->get("ruang");

        if($db->num_rows == 0) {
            return NULL;
        } else {
            $res = $db->row();
            return $res->id_ruang;
        }
    }

    function getPasienByNoRM($id) {
        $this->db->select("nama_pasien");
        $this->db->where("no_rm", $id);
        $db = $this->db->get("pasien");

        if($db->num_rows() == 0) {
            return false;
        } else {
            return $db->row();
        }
    }

    function getLastIDKlpcm() {
        $this->db->select("id_klpcm");
        $this->db->order_by("id_klpcm", "desc");
        $this->db->limit(1,0);
        $db = $this->db->get("rekam_medis");

        return $db->row()->id_klpcm;
    }
}
?>