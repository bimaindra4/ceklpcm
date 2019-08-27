<?php 
    date_default_timezone_set("Asia/Jakarta");
    $date = date("m/d/Y", strtotime($pasien->tanggal_mrs));
?>

<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Edit <small>Pasien</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="#">Pasien</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Edit Pasien</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-8">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-book-open font-dark"></i>
                        <span class="caption-subject uppercase"> Edit Form Pasien </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo form_open('pasien/edit_pasien/'.$pasien->id_pasien, array("class" => "form-horizontal")) ?>
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
                                    <input type="text" name="nama" class="form-control" value="<?php echo $pasien->nama_pasien ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tanggal MRS</label>
                                <div class="col-md-6">
                                <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tglmrs" autocomplete="off" value="<?php echo $date ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">DPJP</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="<?php echo $pasien->dpjp ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Dokter 1</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="dokter1">
                                        <option value="">-- Tidak ada --</option>
                                        <?php foreach($dokter->result() as $row_d1) { ?>
                                        <option value="<?php echo $row_d1->id_dokter ?>" 
                                            <?php if($row_d1->id_dokter == $pasien->dokter_1) { echo "selected"; } ?>>
                                            <?php echo $row_d1->nama_dokter ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Dokter 2</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="dokter2">
                                        <option value="">-- Tidak ada --</option>
                                        <?php foreach($dokter->result() as $row_d2) { ?>
                                        <option value="<?php echo $row_d2->id_dokter ?>" 
                                            <?php if($row_d2->id_dokter == $pasien->dokter_2) { echo "selected"; } ?>>
                                            <?php echo $row_d2->nama_dokter ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ruang / Instalasi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="ruang">
                                        <?php foreach($ruang_ins->result() as $row_r) { ?>
                                        <option value="<?php echo $row_r->id_ruang ?>" 
                                            <?php if($row_r->id_ruang == $pasien->id_ruang) { echo "selected"; } ?>>
                                            <?php echo $row_r->nama_ruang ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-8">
                                    <button type="submit" class="btn green">Simpan</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>