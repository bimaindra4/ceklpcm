<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Beranda</h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <span class="active">Beranda</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-body">
                    <form id="cetak_form" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">Cari Berdasarkan</label>
                                <div class="col-md-8">
                                    <div class="mt-radio-inline center-block">
                                        <label class="mt-radio">
                                            <input type="radio" name="cari" value="rm" onclick="changeCari(this.value)" style="margin-right: 5px"> RM
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="cari" value="ruang" onclick="changeCari(this.value)" style="margin-right: 5px"> Ruang
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden" id="filter_rm">
                                <label class="control-label col-md-4">No. RM</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_rm"/>
                                </div>
                            </div>
                            <div class="form-group hidden" id="filter_ruang">
                                <label class="control-label col-md-4">Ruangan</label>
                                <div class="col-md-8">
                                    <select name="ruangan" class="form-control">
                                        <option value="semua">-- Semua Ruangan --</option>
                                        <?php foreach($ruangan->result() as $row) { ?>
                                            <option value="<?php echo $row->id_ruang ?>"><?php echo $row->nama_ruang ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button onclick="filterRekap()" class="btn green">Tampilkan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-users font-dark"></i>
                        <span class="caption-subject uppercase"> Data Rekam Medis </span>
                    </div>
                </div>
                <div class="portlet-body" id="result-rm">
                    <table class="table table-striped table-bordered table-hover order-column" id="sample_3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dokter</th>
                                <th>Total Cek DRM</th>
                                <th>DRM Lengkap</th>
                                <th>DRM Tidak Lengkap</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($dokter_lap as $row) { ?>
                            <tr class="odd gradeX">
                                <td width="50"><?php echo $no ?></td>
                                <td width="250"><?php echo $row['nama_dokter'] ?></td>
                                <td width="50" class="text-center"><?php echo $row['total_drm'] ?></td>
                                <td width="50" class="text-center"><?php echo $row['drm_lengkap'] ?></td>
                                <td width="50" class="text-center"><?php echo $row['drm_tdk_lengkap'] ?></td>
                                <td>
                                    <a href="#" 
                                       class="btn btn-outline btn-xs blue detailRM" 
                                       data-id="<?php echo $row['id_dokter'] ?>" 
                                       data-nama="<?php echo $row['nama_dokter'] ?>">Detail</a>
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

<div id="detail_rm" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Detail RM</h4>
            </div>
            <div class="modal-body">
                <div class="hasil"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function changeCari(val) {
        if(val == "rm") {
            $("#filter_rm").removeClass("hidden");
            $("#filter_ruang").addClass("hidden");
        } else if(val == "ruang") {
            $("#filter_rm").addClass("hidden");
            $("#filter_ruang").removeClass("hidden");
        }
    }

    function filterRekap() {
        event.preventDefault();

        let cari = $('input[name="cari"]:checked').val();
        let rm = $('[name="no_rm"]').val();
        let ruang = $('[name="ruangan"]').val();

        if(cari == "rm") {
            $.post("<?php echo site_url('beranda/getSearchByRM') ?>", {
                rm: rm
            }, function(result) {
                $("#result-rm").html(result);
            });
        } else if(cari == "ruang") {
            if(ruang == "semua") {
                alert("Pilih salah satu ruang!");
            } else {
                $.post("<?php echo site_url('beranda/getSearchByRuang') ?>", {
                    ruang: ruang
                }, function(result) {
                    $("#result-rm").html(result);
                });
            }
                
        }
    }
</script>