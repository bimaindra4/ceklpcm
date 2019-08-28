<style type="text/css">
    .tgl-cetak, .tertanda {
        display: none;
    }

    th.align-middle {
        vertical-align: middle !important;
    }

    @media print {
        div.rowForm {
            display: none;
        }

        .tgl-cetak, .tertanda {
            display: block;
        }

        .breadcrumb {
            display: none;
        }
    }
</style>

<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Cetak <small>Data KLPCM</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="#">Pasien</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Cetak Data KLPCM</span>
        </li>
    </ul>

    <div class="rowForm">
        <div class="row">
            <div class="col-md-6">
                <div class="portlet light">
                    <div class="portlet-body">
                        <form class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Berdasarkan</label>
                                    <div class="col-md-8">
                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                <input type="radio" name="sort" value="dokter" style="margin-right: 5px" checked> Dokter
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="sort" value="ruang"> Ruangan
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Awal</label>
                                    <div class="col-md-8">
                                        <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="taw" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Akhir</label>
                                    <div class="col-md-8">
                                        <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="tak" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button class="btn green" id="showData">Tampilkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-printer font-dark"></i>
                        <span class="caption-subject uppercase"> Cetak Data KLPCM </span>
                    </div>
                    <div class="actions btn-cetak">
                        <a class="btn blue btn-xs btn-outline" href="#" onclick="window.print()">
                            <i class="fa fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">No</th>
                                <th rowspan="2" class="text-center align-middle" id="sortBy">Dokter</th>
                                <th colspan="2" class="text-center align-middle">Jumlah</th>
                                <th rowspan="2" class="text-center align-middle">Total</th>
                                <!-- <th rowspan="2" class="text-center align-middle">ID</th>
                                <th rowspan="2" class="text-center align-middle">OTF</th>
                                <th rowspan="2" class="text-center align-middle">LAP</th>
                                <th rowspan="2" class="text-center align-middle">DOK</th> -->
                                <th colspan="2" class="text-center align-middle">Presentase</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Lengkap</th>
                                <th class="text-center align-middle">Belum</th>
                                <th class="text-center align-middle">Lengkap</th>
                                <th class="text-center align-middle">Tidak Lengkap</th>
                            </tr>
                        </thead>
                        <tbody id="resultData">
                            <?php $no=1; foreach($dokter_lap as $row) { ?>
                            <tr class="odd gradeX">
                                <td width="25" class="text-center"><?php echo $no ?></td>
                                <td width="200"><?php echo $row['nama_dokter'] ?></td>
                                <td width="30" class="text-center"><?php echo $row['drm_lengkap'] ?></td>
                                <td width="30" class="text-center"><?php echo $row['drm_tdk_lengkap'] ?></td>
                                <td width="30" class="text-center"><?php echo $row['total_drm'] ?></td>
                                <!-- <td width="50" class="text-center"><?php //echo $row['iden'] ?></td>
                                <td width="50" class="text-center"><?php //echo $row['oten'] ?></td>
                                <td width="50" class="text-center"><?php //echo $row['lapp'] ?></td>
                                <td width="50" class="text-center"><?php //echo $row['catat'] ?></td> -->
                                <td width="50" class="text-center"><?php echo $row['persen_lengkap'] ?> %</td>
                                <td width="50" class="text-center"><?php echo $row['persen_tdk_lengkap'] ?> %</td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="tgl-cetak">
                Dicetak pada : <?php date_default_timezone_set("Asia/Jakarta"); echo date("d-m-Y H:i:s"); ?>
            </p>
            <p class="tertanda">
                Kepala Instalasi Rekam Medis
                <br><br><br><br><br><br>
                Putra Lestamana
            </p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#showData").click(function() {
            let sort = $("input[name='sort']:checked").val();
            let tanggal_awal = $("input[name='taw']").val();
            let tanggal_akhir = $("input[name='tak']").val();

            if(sort == "ruang") {
                $("th#sortBy").text("Ruang"); 
            } else if(sort == "dokter") {
                $("th#sortBy").text("Dokter"); 
            }

            $.post("<?php echo site_url('pasien/showData') ?>", {
                sortData : sort,
                taw: tanggal_awal,
                tak: tanggal_akhir
            }, function(result) {
                $("#resultData").html(result);
            });
        });
    });
</script>