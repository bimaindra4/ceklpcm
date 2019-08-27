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
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $numPasien ?>">
                            0
                        </span>
                    </div>
                    <div class="desc"> Jumlah Pasien </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $numDokter ?>">0</span>
                    </div>
                    <div class="desc"> Jumlah Dokter </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-folder-open-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $numRMLengkap ?>">
                            <?php echo $numRMLengkap ?>
                        </span>
                    </div>
                    <div class="desc"> RM Lengkap </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-folder-open"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $numRMTidakLengkap ?>">
                            <?php echo $numRMTidakLengkap ?>
                        </span> 
                    </div>
                    <div class="desc"> RM Tidak Lengkap </div>
                </div>
            </a>
        </div>
    </div>
</div>