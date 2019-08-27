<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Pengecekan <small>KLPCM</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="<?php echo site_url('klpcm/cek_data') ?>">Cek KLPCM</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Pengecekan KLPCM</span>
        </li>
    </ul>

    <style>
        .mt-radio-inline {
            padding: 0;
        }

        .tabel-catat {
            margin-top: 30px;
        }

        .row-form {
            width: 150px;
        }
    </style>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-book-open font-dark"></i>
                        <span class="caption-subject uppercase"> Cek KLPCM </span>
                    </div>
                </div>
                
                <p id="check"></p>
                <div class="portlet-body">
                    <form class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">No RM</label>
                                <div class="col-md-6">
                                    <input type="text" name="no_rm" class="form-control" value="<?php echo $klpcm->no_rm ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">DPJP</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="<?php echo $klpcm->dpjp ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Dokter 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="<?php echo $klpcm->dokter1 ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Dokter 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="<?php echo $klpcm->dokter2 ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ruangan / Instalasi</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="<?php echo $klpcm->nama_ruang ?>" readonly>
                                </div>
                            </div>
                            <div class="row tabel-catat">
                                <div class="col-md-11">
                                    <table class="table table-bordered table-hover order-column">
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td class="row-form">IDENTITAS</td>
                                                <td class="row-form">
                                                    <div class="mt-radio-inline center-block">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="iden" value="L" style="margin-right: 5px" onclick="disableForm('iden')"
                                                                <?php ($klpcm->identitas == "L") ? $out="checked" : $out=""; echo $out ?>> L
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="iden" value="T" style="margin-right: 5px" onclick="enableForm('iden')"
                                                                <?php ($klpcm->identitas == "T") ? $out="checked" : $out=""; echo $out ?>> T
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select id="multiple" name="tl_identitas" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                                        <?php foreach($formri->result() as $row) { ?>
                                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td class="row-form">OTENTIFIKASI</td>
                                                <td class="row-form">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="oten" value="L" style="margin-right: 5px" onclick="disableForm('oten')" 
                                                                <?php ($klpcm->otentifikasi == "L") ? $out="checked" : $out=""; echo $out ?>> L
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="oten" value="T" style="margin-right: 5px" onclick="enableForm('oten')"
                                                            <?php ($klpcm->otentifikasi == "T") ? $out="checked" : $out=""; echo $out ?>> T
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select id="multiple" name="tl_otentifikasi" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                                        <?php foreach($formri->result() as $row) { ?>
                                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td class="row-form">LAP. PENTING</td>
                                                <td class="row-form">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="lap" value="L" style="margin-right: 5px" onclick="disableForm('lap')"
                                                                <?php ($klpcm->lap_penting == "L") ? $out="checked" : $out=""; echo $out ?>> L
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="lap" value="T" style="margin-right: 5px" onclick="enableForm('lap')"
                                                                <?php ($klpcm->lap_penting == "T") ? $out="checked" : $out=""; echo $out ?>> T
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select id="multiple" name="tl_laporan" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                                        <?php foreach($formri->result() as $row) { ?>
                                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td class="row-form">KEJELASAN TULISAN</td>
                                                <td class="row-form">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="catat" value="L" style="margin-right: 5px" onclick="disableForm('catat')"
                                                                <?php ($klpcm->pencatatan == "L") ? $out="checked" : $out=""; echo $out ?>> L
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="catat" value="T" style="margin-right: 5px" onclick="enableForm('catat')"
                                                                <?php ($klpcm->pencatatan == "T") ? $out="checked" : $out=""; echo $out ?>> T
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select id="multiple" name="tl_pencatatan" class="form-control select2-multiple" data-placeholder="Pilih Form" multiple disabled>
                                                        <?php foreach($formri->result() as $row) { ?>
                                                            <option value="<?php echo $row->id_inap ?>"><?php echo $row->rawat_inap ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn green" onclick="insertFormTL('<?php echo $klpcm->no_rm ?>')">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let identitas = $('[name="tl_identitas"]');
    let otentifikasi = $('[name="tl_otentifikasi"]');
    let laporan = $('[name="tl_laporan"]');
    let pencatatan = $('[name="tl_pencatatan"]');

    let f_iden = $('input[name="iden"]:checked').val();
    let f_oten = $('input[name="oten"]:checked').val();
    let f_lap = $('input[name="lap"]:checked').val();
    let f_catat = $('input[name="catat"]:checked').val();

    if(f_iden == "T") enableForm("iden");
    if(f_oten == "T") enableForm("oten");
    if(f_lap == "T") enableForm("lap");
    if(f_catat == "T") enableForm("catat");

    identitas.val([<?php echo $tl_identitas; ?>]);
    otentifikasi.val([<?php echo $tl_otentifikasi ?>]);
    laporan.val([<?php echo $tl_laporan ?>]);
    pencatatan.val([<?php echo $tl_pencatatan ?>]);

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
</script>