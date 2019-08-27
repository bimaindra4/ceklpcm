<?php if (!defined('BASEPATH')) exit('Maaf, akses secara langsung tidak diperkenankan.');
class M_beranda extends CI_Model {
	public function __construct() {
		parent::__construct();
    }
    
    function getNumPasien() {
        $db = $this->db->get("pasien");
        return $db->num_rows();
    }

    function getNumDokter() {
        $db = $this->db->get("dokter");
        return $db->num_rows();
    }

    function getRuangan() {
        $db = $this->db->get("ruang");
        return $db;
    }

    function getNumRMLengkap() {
        $db = $this->db->query("
            SELECT
                (SELECT COUNT(*) FROM rekam_medis WHERE identitas='L')+
                (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='L')+
                (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='L')+
                (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='L')
                    AS rm_lengkap
            FROM rekam_medis LIMIT 1
        ");
        
        $res = $db->row();
        if($res == null) {
            return 0;
        } else {
            return $res->rm_lengkap;
        }
    }

    function getNumRMTidakLengkap() {
        $db = $this->db->query("
            SELECT
                (SELECT COUNT(*) FROM rekam_medis WHERE identitas='T')+
                (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='T')+
                (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='T')+
                (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='T')
                    AS rm_tdk_lengkap
            FROM rekam_medis LIMIT 1
        ");
        
        $res = $db->row();
        if($res == null) {
            return 0;
        } else {
            return $res->rm_tdk_lengkap;
        }
    }

    function getDokterLap() {
        $l = "L";
        $tl = "TL";
        $dat = [];

        $this->db->select("d.id_dokter, d.nama_dokter, COUNT(rm.no_rm) AS total_drm, rm.instalasi_dpjp");
        $this->db->from("rekam_medis rm");
        $this->db->join("dokter d", "rm.instalasi_dpjp = d.id_dokter", "right");
        $this->db->group_by("d.id_dokter");
        $this->db->order_by("d.id_dokter");
        $db = $this->db->get();

        foreach($db->result() as $row) {
            ($row->instalasi_dpjp == NULL) ? $dpjp = "0" : $dpjp = $row->instalasi_dpjp;
            
            // Hitung DRM Lengkap
            $this->db->select("
                (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$l' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$l' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$l' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$l' AND instalasi_dpjp=$dpjp) AS lengkap
            ");
            $this->db->from("rekam_medis");
            $drm_lkp = $this->db->get()->row()->lengkap;

            // Hitung DRM Tidak Lengkap
            $this->db->select("
                (SELECT COUNT(*) FROM rekam_medis WHERE identitas='$tl' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE otentifikasi='$tl' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE lap_penting='$tl' AND instalasi_dpjp=$dpjp)+
                (SELECT COUNT(*) FROM rekam_medis WHERE pencatatan='$tl' AND instalasi_dpjp=$dpjp) AS tdklengkap
            ");
            $this->db->from("rekam_medis");
            $drm_tlkp = $this->db->get()->row()->tdklengkap;

            $data = [
                "id_dokter" => $row->id_dokter,
                "nama_dokter" => $row->nama_dokter,
                "total_drm" => 4*$row->total_drm,
                "drm_lengkap" => $drm_lkp,
                "drm_tdk_lengkap" => $drm_tlkp,
            ];

            array_push($dat, $data);
        }

        return $dat;
    }

    function getDetailRM($id) {
        $this->db->select("no_rm, identitas, otentifikasi, lap_penting, pencatatan");
        $this->db->from("rekam_medis");
        $this->db->where("instalasi_dpjp", $id);
        $this->db->where("identitas", "T");
        $this->db->or_where("otentifikasi", "T");
        $this->db->or_where("lap_penting", "T");
        $this->db->or_where("pencatatan", "T");

        $db = $this->db->get();
        return $db;
    }

    function getDetailTLForm($id) {
        $this->db->select("tri.*, fri.rawat_inap");
        $this->db->join("form_rawat_inap fri", "tri.id_rawat_inap = fri.id_inap");
        $this->db->where("tri.no_rm", $id);
        $q = $this->db->get("tl_rawat_inap tri");

        return $q;
    }

    function getRMFromRM($id) {
        $this->db->select("rm.no_rm, d.nama_dokter AS dpjp");
        $this->db->join("dokter d", "rm.instalasi_dpjp = d.id_dokter");
        $this->db->where("no_rm", $id);
        $db = $this->db->get("rekam_medis rm");
        return $db;
    }

    function getRMFromRuang($id) {
        $this->db->select("rm.no_rm, d.nama_dokter AS dpjp");
        $this->db->join("dokter d", "rm.instalasi_dpjp = d.id_dokter");
        $this->db->where("id_ruang", $id);
        $db = $this->db->get("rekam_medis rm");
        return $db;
    }
}
?>