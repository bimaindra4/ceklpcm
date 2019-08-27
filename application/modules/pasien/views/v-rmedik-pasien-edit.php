<?php 
    date_default_timezone_set("Asia/Jakarta");
    $date = date("m/d/Y", strtotime($pasien->tanggal_mrs));
?>

<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Edit <small>KLPCM</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="#">Pasien</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Edit KLPCM</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-book-open font-dark"></i>
                        <span class="caption-subject uppercase"> Edit KLPCM </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo form_open('pasien/edit_pasien/'.$pasien->id_klpcm, array("class" => "form-horizontal")) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">No RM</label>
                                <div class="col-md-6">
                                    <input type="text" name="no_rm" class="form-control" value="<?php echo $pasien->no_rm ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Pasien</label>
                                <div class="col-md-6">
                                    <input type="text" name="nama" class="form-control" value="<?php echo $pasien->nama_pasien ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tanggal MRS</label>
                                <div class="col-md-6">
                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tglmrs" autocomplete="off" value="<?php echo $date ?>">
                                </div>
                            </div>
                            <?php 
                                if($pasien->dpjp == NULL) {
                                    $chk_ruang = "checked";
                                    $chk_dokter = "";
                                } else if($pasien->id_ruang == NULL) {
                                    $chk_ruang = "";
                                    $chk_dokter = "checked";
                                } 
                            ?>
                            <div class="form-group" style="margin-bottom: 0px">
                                <label class="control-label col-md-3">Pilihan</label>
                                <div class="col-md-8">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio" style="margin-bottom: 10px">
                                            <input type="radio" name="pilihan" id="pil_ruang" value="ruang" <?php echo $chk_ruang ?>> Ruang
                                            <span></span>
                                        </label>
                                        <label class="mt-radio" style="margin-bottom: 10px">
                                            <input type="radio" name="pilihan" id="pil_dokter" value="dokter" <?php echo $chk_dokter ?>> Dokter
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="pRuang">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Ruang</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="ruang" required="on">
                                            <option value="">-- Pilih Ruang --</option>
                                            <?php foreach($ruang->result() as $rowr) { ?>
                                                <option value="<?php echo $rowr->id_ruang ?>"
                                                    <?php echo ($rowr->id_ruang == $pasien->id_ruang ? "selected" : ""); ?>>
                                                    <?php echo $rowr->nama_ruang ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="pDokter">
                                <div class="form-group">
                                    <label class="control-label col-md-3">DPJP</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="dpjp" required="on">
                                            <option value="">-- Pilih Dokter --</option>
                                            <?php foreach($dokter->result() as $rowd) { ?>
                                            <option value="<?php echo $rowd->id_dokter ?>" 
                                                <?php echo ($rowd->id_dokter == $pasien->dpjp ? "selected" : ""); ?>>
                                                <?php echo $rowd->nama_dokter ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Status awal <?php echo $pasien->status_awal ?></label>
                                <div class="col-md-6">
                                    <select name="stts_awal" class="form-control">
                                        <option value="lengkap" <?php echo ($pasien->status_awal == "lengkap" ? "selected" : "") ?>>Lengkap</option>
                                        <option value="belum" <?php echo ($pasien->status_awal == "belum" ? "selected" : "") ?>>Tidak Lengkap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-8">
                                    <button type="submit" class="btn green">Simpan</button>
                                    <a href="<?php echo site_url('pasien/data') ?>" class="btn default">Kembali</a>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#pRuang").hide();
        $("#pDokter").hide();

        // waktu awal
        let pilRuang = document.getElementById("pil_ruang").checked;
        let pilDokter = document.getElementById("pil_dokter").checked;
        if(pilRuang == true) {
            $("#pRuang").show();
            $("#pDokter").hide();
            $("select[name='dpjp']").val("");
            $("select[name='dpjp']").removeProp("required");
            $("select[name='ruang']").prop("required","on");
        } else if(pilDokter == true) {
            $("#pRuang").hide();
            $("#pDokter").show();
            $("select[name='ruang']").val("");  
            $("select[name='dpjp']").prop("required","on"); 
            $("select[name='ruang']").removeProp("required");
        }

        $("input[type='radio']").on("change", function() {
            let pil = $(this).val();
            // waktu udah dipilih
            if(pil == "ruang") {
                $("#pRuang").show();
                $("#pDokter").hide();
                $("select[name='dpjp']").val("");
                $("select[name='dpjp']").removeProp("required");
                $("select[name='ruang']").prop("required","on");  
            } else if(pil == "dokter") {
                $("#pRuang").hide();
                $("#pDokter").show();
                $("select[name='ruang']").val("");  
                $("select[name='dpjp']").prop("required","on"); 
                $("select[name='ruang']").removeProp("required");
            }
        });
    });
</script>