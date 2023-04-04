<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="my-2">
            <div class="col">
                <h1 style='text-shadow: 2px 2px 4px #827e7e;'>
                    <?= $titlecontent ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="col">
            <div class="animate__animated animate__swing">
                <div class="small-box bg-primary bg-gradient shadow">
                    <div class="inner">
                        <h3><?= $server['kode_server'] ?></h3>
                        <p>KODE SERVER</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-server"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $gtk ?></h3>
                            <p>GTK</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $datasiswa ?></h3>
                            <p>Siswa</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $datarombel ?></h3>
                            <p>Rombel</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users-class"></i>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $datamapel ?></h3>
                            <p>Mata Pelajaran</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-books"></i>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $databanksoal ?></h3>
                            <p>Bank Soal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__swing col-md-4">
                    <div class="small-box bg-primary bg-gradient shadow">
                        <div class="inner">
                            <h3><?= $datasoal ?></h3>
                            <p>Soal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="animate__animated animate__flipInX">
                <div class="card shadow">
                    <div class="card-header bg-primary bg-gradient" data-toggle="collapse" data-target=".infocollapse" aria-expanded="false" aria-controls="infocollapse" role="button">
                        <h3 class="card-title"><i class="fas fa-bullhorn">&nbsp;</i> Pengumuman</h3>
                    </div>
                    <div class="collapse <?= ($datapengumuman > 0) ? 'show' : '' ?> infocollapse" id="infocollapse">
                        <div class="card-body">
                            <div id="pengumuman">
                                <p class="text-center">
                                    <i class="fas fa-spin fa-spinner fa-circle-o-notch"></i> Loading....
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col pt-0 pb-2">
            <div class="animate__animated animate__flipInX btn-log shadow">
                <div class="card card-outline card-warning bg-gradient shadow">
                    <div class="card-header bg-warning bg-gradient" data-toggle="collapse" data-target=".logcollapse" aria-expanded="false" aria-controls="logcollapse" role="button">
                        <h3 class="card-title"><i class="fas fa-history">&nbsp;</i> Log Aktifitas</h3>
                    </div>
                    <div class="collapse show logcollapse" id="logcollapse" style="max-height: 100%; overflow: auto;">
                        <div class="card-body">
                            <div id="log-list">
                                <p class="text-center">
                                    <i class='fas fa-spin fa-spinner fa-circle-o-notch'></i> Loading....
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/chart.js/Chart.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<?= $this->endSection(); ?>