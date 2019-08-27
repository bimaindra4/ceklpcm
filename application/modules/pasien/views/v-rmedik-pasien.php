<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Data <small>KLPCM</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="#">KLPCM</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Data KLPCM</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <button data-toggle="modal" data-target="#tambah-pasien" class="btn blue btn-outline" style="margin-bottom: 15px">Tambah KLPCM</button>
            <button data-toggle="modal" data-target="#import" class="btn green btn-outline pull-right" style="margin-bottom: 15px">Import Data</button>            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-users font-dark"></i>
                        <span class="caption-subject uppercase"> Data KLPCM </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal MRS</th>
                                <th>Instalasi / Dokter</th>
                                <th>Nama Pasien</th>
                                <th>RM</th>
                                <th>Status Awal</th>
                                <th>Formulir</th>
                                <th>ID</th>
                                <th>OTF</th>
                                <th>LAP</th>
                                <th>JELAS</th>
                                <th>Status Akhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                date_default_timezone_set("Asia/Jakarta");
                                $no = 1; 
                                foreach($pasien as $row) { 
                            ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($row['tanggal_mrs'])) ?></td>
                                    <td><?php echo $row['indo'] ?></td>
                                    <td><?php echo $row['nama_pasien'] ?></td>
                                    <td><?php echo $row['no_rm'] ?></td>
                                    <td><?php echo ucfirst($row['status_awal']) ?></td>
                                    <td></td>
                                    <td><?php echo $row['iden'] ?></td>
                                    <td><?php echo $row['oten'] ?></td>
                                    <td><?php echo $row['lapp'] ?></td>
                                    <td><?php echo $row['penc'] ?></td>
                                    <td></td>
                                    <td>
                                        <a href="<?php echo site_url('pasien/edit_form/'.$row['id_klpcm']) ?>" class="btn blue btn-xs btn-outline">Edit</a>
                                        <a href="<?php echo site_url('pasien/hapus_pasien/'.$row['id_klpcm']) ?>" class="btn red btn-xs btn-outline">Hapus</a>
                                        <!-- <a href="<?php //echo site_url('klpcm/hasil_klpcm/'.$row['no_rm']) ?>" class="btn blue btn-xs btn-outline">Cek</a> -->
                                    </td>
                                </tr>
                            <?php $no++; } ?>
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tambah-pasien" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('pasien/tambah_rm', array('class' => 'form-horizontal')) ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah KLPCM</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No RM</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="norm" name="norm" autocomplete="off" required="on">
                                    <span class="input-group-btn">
                                        <button class="btn blue" type="button" value="rm" name="rm">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Pasien</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nama_pasien" required="on" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal MRS</label>
                            <div class="col-md-8">
                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tglmrs" autocomplete="off">
                                <div class="mt-checkbox-list" style="margin-top: 10px; margin-bottom: -20px">
                                    <label class="mt-checkbox">
                                        <input type="checkbox" name="tglskrg" value="1"> Tanggal Sekarang
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px">
                            <label class="control-label col-md-3">Pilihan</label>
                            <div class="col-md-8">
                                <div class="mt-radio-inline">
                                    <label class="mt-radio" style="margin-bottom: 10px">
                                        <input type="radio" name="pilihan" value="ruang"> Ruang
                                        <span></span>
                                    </label>
                                    <label class="mt-radio" style="margin-bottom: 10px">
                                        <input type="radio" name="pilihan" value="dokter"> Dokter
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="pRuang">
                            <div class="form-group">
                                <label class="control-label col-md-3">Ruang</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="ruang" required="on">
                                        <option value="">-- Pilih R/I --</option>
                                        <?php foreach($ruang_ins->result() as $row) { ?>
                                            <option value="<?php echo $row->id_ruang ?>"><?php echo $row->nama_ruang ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="pDokter">
                            <div class="form-group">
                                <label class="control-label col-md-3">DPJP</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="dpjp" required="on">
                                        <option value="">-- Pilih Dokter --</option>
                                        <?php foreach($dokter->result() as $row) { ?>
                                            <option value="<?php echo $row->id_dokter ?>"><?php echo $row->nama_dokter ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status Awal</label>
                            <div class="col-md-8">
                                <select class="form-control" name="status_awal">
                                    <option value="">-- Status Awal --</option>
                                    <option value="Lengkap">Lengkap</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>
                        </div>
                        <div id="formulir">
                            <div class="form-group">
                                <label class="control-label col-md-3">Identitas</label>
                                <div class="col-md-3">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="iden" value="L" style="margin-right: 5px" onclick="disableForm('iden')"> L
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="iden" value="T" style="margin-right: 5px" onclick="enableForm('iden')"> T
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select id="multiple" name="tl_identitas[]" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                        <?php foreach($formri->result() as $row) { ?>
                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Otentifikasi</label>
                                <div class="col-md-3">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="oten" value="L" style="margin-right: 5px" onclick="disableForm('oten')"> L
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="oten" value="T" style="margin-right: 5px" onclick="enableForm('oten')"> T
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select id="multiple" name="tl_otentifikasi[]" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                        <?php foreach($formri->result() as $row) { ?>
                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Lap. Penting</label>
                                <div class="col-md-3">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="lap" value="L" style="margin-right: 5px" onclick="disableForm('lap')"> L
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="lap" value="T" style="margin-right: 5px" onclick="enableForm('lap')"> T
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select id="multiple" name="tl_laporan[]" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                        <?php foreach($formri->result() as $row) { ?>
                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kejelasan Tulisan</label>
                                <div class="col-md-3">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="catat" value="L" style="margin-right: 5px" onclick="disableForm('catat')"> L
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="catat" value="T" style="margin-right: 5px" onclick="enableForm('catat')"> T
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select id="multiple" name="tl_pencatatan[]" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                        <?php foreach($formri->result() as $row) { ?>
                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                    <button type="submit" class="btn green">Submit</button>
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<div id="cari" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cari No Rekam Medis</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('klpcm/hasil_klpcm') ?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">No. Rekam Medis</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cari" autocomplete="off" id="nip">
                                <span class="input-group-btn">
                                    <button class="btn blue" type="submit">Cari</button>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="import" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <?php echo form_open_multipart('pasien/import_pasien', array("class" => "form-control")) ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Import Data Pasien</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Upload File (.xls)</label>
                            <div class="input-group">
                                <input type="file" name="import">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload!</button>
                </div>
            </div>
        <?php echo form_close() ?>
    </div>
</div>

<script type="text/javascript">
    let identitas = $('[name="tl_identitas[]"]');
    let otentifikasi = $('[name="tl_otentifikasi[]"]');
    let laporan = $('[name="tl_laporan[]"]');
    let pencatatan = $('[name="tl_pencatatan[]"]');

    let f_iden = $('input[name="iden"]:checked').val();
    let f_oten = $('input[name="oten"]:checked').val();
    let f_lap = $('input[name="lap"]:checked').val();
    let f_catat = $('input[name="catat"]:checked').val();

    if(f_iden == "T") enableForm("iden");
    if(f_oten == "T") enableForm("oten");
    if(f_lap == "T") enableForm("lap");
    if(f_catat == "T") enableForm("catat");

    function insertFormTL(id) {
        let TL_iden = identitas.val();
        let TL_oten = otentifikasi.val();
        let TL_lap = laporan.val();
        let TL_catat = pencatatan.val();

        let f_iden = $('input[name="iden"]:checked').val();
        let f_oten = $('input[name="oten"]:checked').val();
        let f_lap = $('input[name="lap"]:checked').val();
        let f_catat = $('input[name="catat"]:checked').val();

        $.ajax({
            url : "<?php echo site_url('klpcm/update_form_tl') ?>/" + id,
            type: "POST",
            data: {
                f_identitas: f_iden,
                f_otentifikasi: f_oten,
                f_laporan: f_lap,
                f_pencatatan: f_catat,
                identitas: TL_iden,
                otentifikasi: TL_oten,
                laporan: TL_lap,
                pencatatan: TL_catat
            },
            
            dataType: "JSON"
        });

        alert('Data berhasil disimpan!');
    }

    function disableForm(val) {
        if(val == "iden") {
            identitas.attr("disabled","on");
            identitas.attr("required","off");
            identitas.val('').trigger('change');
        } else if(val == "oten") {
            otentifikasi.attr("disabled","on");
            otentifikasi.attr("required","off");
            otentifikasi.val('').trigger('change');
        } else if(val == "lap") {
            laporan.attr("disabled","on");
            laporan.attr("required","off");
            laporan.val('').trigger('change');
        } else if(val == "catat") {
            pencatatan.attr("disabled","on");
            pencatatan.attr("required","off");
            pencatatan.val('').trigger('change');
        }
    }

    function enableForm(val) {
        if(val == "iden") {
            identitas.removeAttr("disabled","off");
            identitas.attr("required","on");
        } else if(val == "oten") {
            otentifikasi.removeAttr("disabled","off");
            otentifikasi.attr("required","on");
        } else if(val == "lap") {
            laporan.removeAttr("disabled","off");
            laporan.attr("required","on");
        } else if(val == "catat") {
            pencatatan.removeAttr("disabled","off");
            pencatatan.attr("required","on");
        }
    }

    $(document).ready(function() {
        $("#pRuang").hide();
        $("#pDokter").hide();

        $("input[type='radio']").on("change", function() {
            let pil = $(this).val();
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

        $("button[name='rm']").on("click", function() {
            let rm = $("#norm").val();
            let np = $('input[name="nama_pasien"]');
            if(rm) {
                $.ajax({
                    url: "<?php echo site_url('pasien/get_pasien_by_norm') ?>/"+rm,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data != false) {
                            np.prop("readonly","on");
                            np.val(data.nama_pasien);
                            toastr.info("Data RM Tersedia");
                        } else {
                            np.removeAttr("readonly");
                            np.val("");
                            toastr.info("Silahkan isi Nama Pasien","Data RM Tidak Tersedia");
                        }
                    }
                });
            }
        });
    });
</script>