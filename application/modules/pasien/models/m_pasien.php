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
        $this->db->select("p.*, d.nama_dokter AS dpjp, rm.*");
        $this->db->join("rekam_medis rm", "p.no_rm = rm.no_rm");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter");
        $this->db->where("rm.id_klpcm", $val);
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
        $this->db->join("rekam_medis rm", "tri.id_klpcm = rm.id_klpcm");
        $this->db->where("rm.dpjp", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $q;
    }

    function getDetailTLForm_Ruang($id) {
        $this->db->select("tri.*, fri.rawat_inap");
        $this->db->join("form_rawat_inap fri", "tri.id_rawat_inap = fri.id_inap");
        $this->db->join("rekam_medis rm", "tri.id_klpcm = rm.id_klpcm");
        $this->db->where("rm.id_ruang", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $q;
    }

    function getDokterLap($taw="",$tak="") {
        $l = "L";
        $tl = "T";
        $dat = [];

        $this->db->select("d.id_dokter, d.nama_dokter");
        $this->db->from("rekam_medis rm");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter", "right");

        if($taw != "" || $tak != "") {
            $this->db->where("tanggal_mrs <=", $tak);
            $this->db->where("tanggal_mrs >=", $taw);
        }

        $this->db->group_by("d.id_dokter");
        $this->db->order_by("d.id_dokter");
        $db = $this->db->get();

        foreach($db->result() as $row) {
            if($taw != "" || $tak != "") {
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$l' AND otentifikasi='$l' AND lap_penting='$l' AND pencatatan='$l', 1, 0)), 0) AS lengkap
                    FROM rekam_medis
                    WHERE dpjp='$row->id_dokter' AND tanggal_mrs BETWEEN $taw AND $tak
                ";
                $res = $this->db->query($sql);
                $drm_lkp = (empty($res->row()) ? 0 : $res->row()->lengkap);

                // Hitung DRM Tidak Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$tl' OR otentifikasi='$tl' OR lap_penting='$tl' OR pencatatan='$tl', 1, 0)), 0) AS tdklengkap
                    FROM rekam_medis
                    WHERE dpjp='$row->id_dokter' AND tanggal_mrs BETWEEN $taw AND $tak
                ";
                $res = $this->db->query($sql);
                $drm_tlkp = (empty($res->row()) ? 0 : $res->row()->tdklengkap);
            } else {
                // Hitung DRM Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$l' AND otentifikasi='$l' AND lap_penting='$l' AND pencatatan='$l', 1, 0)), 0) AS lengkap
                    FROM rekam_medis
                    WHERE dpjp='$row->id_dokter'
                ";
                $res = $this->db->query($sql);
                $drm_lkp = (empty($res->row()) ? 0 : $res->row()->lengkap);
                // Hitung DRM Tidak Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$tl' OR otentifikasi='$tl' OR lap_penting='$tl' OR pencatatan='$tl', 1, 0)), 0) AS tdklengkap
                    FROM rekam_medis
                    WHERE dpjp='$row->id_dokter'
                ";
                $res = $this->db->query($sql);
                $drm_tlkp = (empty($res->row()) ? 0 : $res->row()->tdklengkap);
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
                "total_drm" => $total_drm,
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

        $this->db->select("r.id_ruang, r.nama_ruang");
        $this->db->from("rekam_medis rm");
        $this->db->join("ruang r", "rm.id_ruang = r.id_ruang", "right");

        if($taw != "" || $tak != "") {
            $this->db->where("tanggal_mrs <=", $tak);
            $this->db->where("tanggal_mrs >=", $taw);
        }

        $this->db->group_by("r.id_ruang");
        $this->db->order_by("r.id_ruang");
        $db = $this->db->get();
        foreach($db->result() as $row) {
            if($taw != "" || $tak != "") {
                // Hitung DRM Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$l' AND otentifikasi='$l' AND lap_penting='$l' AND pencatatan='$l', 1, 0)), 0) AS lengkap
                    FROM rekam_medis
                    WHERE id_ruang='$row->id_ruang'
                    AND tanggal_mrs BETWEEN $taw AND $tak
                ";
                $res = $this->db->query($sql);
                $drm_lkp = (empty($res->row()) ? 0 : $res->row()->lengkap);

                // Hitung DRM Tidak Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$tl' OR otentifikasi='$tl' OR lap_penting='$tl' OR pencatatan='$tl', 1, 0)), 0) AS tdklengkap
                    FROM rekam_medis
                    WHERE id_ruang='$row->id_ruang'
                    AND tanggal_mrs BETWEEN $taw AND $tak
                ";
                $res = $this->db->query($sql);
                $drm_tlkp = (empty($res->row()) ? 0 : $res->row()->tdklengkap);
            } else {
                // Hitung DRM Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$l' AND otentifikasi='$l' AND lap_penting='$l' AND pencatatan='$l', 1, 0)), 0) AS lengkap
                    FROM rekam_medis rm
                    WHERE id_ruang='$row->id_ruang'
                ";
                $res = $this->db->query($sql);
                $drm_lkp = (empty($res->row()) ? 0 : $res->row()->lengkap);

                // Hitung DRM Tidak Lengkap
                $sql = "
                    SELECT IFNULL(SUM(IF(identitas='$tl' OR otentifikasi='$tl' OR lap_penting='$tl' OR pencatatan='$tl', 1, 0)), 0) AS tdklengkap
                    FROM rekam_medis
                    WHERE id_ruang='$row->id_ruang'
                ";
                $res = $this->db->query($sql);
                $drm_tlkp = (empty($res->row()) ? 0 : $res->row()->tdklengkap);
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
                "total_drm" => $total_drm,
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
            foreach($data['iden']['data'] as $rows) {
                $iden = [
                    "id_rawat_inap" => $rows,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "identitas"
                ];

                $this->db->insert("tl_rawat_inap", $iden);
            }
        }

        if($data['oten']['dokumen'] == "T") {
            foreach($data['oten']['data'] as $rowd) {
                $oten = [
                    "id_rawat_inap" => $rowd,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "otentifikasi"
                ];

                $this->db->insert("tl_rawat_inap", $oten);
            }
        }

        if($data['lap']['dokumen'] == "T") {
            foreach($data['lap']['data'] as $rowt) {
                $lap = [
                    "id_rawat_inap" => $rowt,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "lap_penting"
                ];

                $this->db->insert("tl_rawat_inap", $lap);
            }
        }

        if($data['catat']['dokumen'] == "T") {
            foreach($data['catat']['data'] as $rowe) {
                $catat = [
                    "id_rawat_inap" => $rowe,
                    "id_klpcm" => $this->getLastIDKlpcm(),
                    "keterangan" => "pencatatan"
                ];

                $this->db->insert("tl_rawat_inap", $catat);
            }
        }
    }
    
    function editPasien($val) {
        // Set timezone
        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d", strtotime($this->input->post("tglmrs")));

        $data = array(
            "tanggal_mrs" => $date,
            "dpjp" => ($this->input->post("dpjp") == "" ? NULL : $this->input->post("dpjp")),
            "id_ruang" => ($this->input->post('ruang') == "" ? NULL : $this->input->post('ruang')), 
            "status_awal" => $this->input->post('stts_awal')
        );

        $this->db->update("rekam_medis", $data, array("id_klpcm" => $val));
    }

    function deleteKLPCM($val) {
        $this->db->delete("rekam_medis", array("id_klpcm" => $val));
    }

    function generateData($val) {
        // Set timezone
        date_default_timezone_set("Asia/Jakarta");

        for($i=0; $i<count($val); $i++) {
            $dpjp = $this->getIDDokter($val[$i]['instalasi']);
            $d1 = $this->getIDDokter($d1);
            $d2 = $this->getIDDokter($d2);
            $ruang = $this->getIDRuang($val[$i]['ruang']);

            // insert to rekam_medik
            $dat1 = array(
                "no_rm" => $val[$i]['no_rm'],
                "dpjp" => $dpjp,
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