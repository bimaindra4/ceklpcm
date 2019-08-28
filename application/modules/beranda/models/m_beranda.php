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
            SELECT IFNULL(SUM(IF(identitas='L' AND otentifikasi='L' AND lap_penting='L' AND pencatatan='L', 1, 0)), 0) AS lengkap
            FROM rekam_medis");
        
        $res = $db->row();
        if($res == null) {
            return 0;
        } else {
            return $res->lengkap;
        }
    }

    function getNumRMTidakLengkap() {
        $db = $this->db->query("
            SELECT IFNULL(SUM(IF(identitas='T' OR otentifikasi='T' OR lap_penting='T' OR pencatatan='T', 1, 0)), 0) AS tdklengkap
            FROM rekam_medis
        ");
        
        $res = $db->row();
        if($res == null) {
            return 0;
        } else {
            return $res->tdklengkap;
        }
    }

    function getDokterLap() {
        $l = "L";
        $tl = "T";
        $dat = [];

        $this->db->select("d.id_dokter, d.nama_dokter, rm.dpjp");
        $this->db->from("rekam_medis rm");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter", "right");
        $this->db->group_by("d.id_dokter");
        $this->db->order_by("d.id_dokter");
        $db = $this->db->get();

        foreach($db->result() as $row) {
            ($row->dpjp == NULL) ? $dpjp = "0" : $dpjp = $row->dpjp;
            
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

            if($drm_lkp == 0 && $drm_tlkp == 0) {
                $total_drm = 0;
            } else {
                $total_drm = $drm_lkp + $drm_tlkp;
            }

            $data = [
                "id_dokter" => $row->id_dokter,
                "nama_dokter" => $row->nama_dokter,
                "total_drm" => $total_drm,
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
        $this->db->where("dpjp", $id);
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
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter");
        $this->db->where("no_rm", $id);
        $db = $this->db->get("rekam_medis rm");
        return $db;
    }

    function getRMFromRuang($id) {
        $this->db->select("rm.no_rm, d.nama_dokter AS dpjp");
        $this->db->join("dokter d", "rm.dpjp = d.id_dokter");
        $this->db->where("id_ruang", $id);
        $db = $this->db->get("rekam_medis rm");
        return $db;
    }
}
?>