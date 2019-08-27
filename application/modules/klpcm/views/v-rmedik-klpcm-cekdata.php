<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Cek <small>KLPCM</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <span class="active">Cek KLPCM</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-body">
                    <?php echo form_open('klpcm/hasil_klpcm', array("class" => "form-horizontal")) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">No RM</label>
                                <div class="col-md-9">
                                    <input type="text" name="cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Cari</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>