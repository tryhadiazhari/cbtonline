<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class='animate__animated animate__swing col-md-4'>
                        <div class='small-box bg-green'>
                            <div class="inner">
                                <h3><?= count($datasiswa) ?></h3>

                                <p>Siswa</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-person-add"></i>
                            </div>
                            <a href="/pd" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class='animate__animated animate__swing col-md-4'>
                        <div class='small-box bg-blue'>
                            <div class="inner">
                                <h3><?= count($datarombel) ?></h3>

                                <p>Rombel</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-business"></i>
                            </div>
                            <a href="/rombel" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class='animate__animated animate__swing col-md-4'>
                        <div class='small-box bg-purple'>
                            <div class="inner">
                                <h3><?= count($datamapel) ?></h3>
                                <p>Mata Pelajaran</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-book"></i>
                            </div>
                            <a href="#" class="small-box-footer"></a>
                        </div>
                    </div>
                    <div class='animate__animated animate__swing col-md-4'>
                        <div class='small-box bg-info'>
                            <div class="inner">
                                <h3><?= count($databanksoal) ?></h3>
                                <p>Bank Soal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-briefcase"></i>
                            </div>
                            <a href="/banksoal" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class='animate__animated animate__swing col-md-4'>
                        <div class='small-box bg-secondary'>
                            <div class="inner">
                                <h3><?= count($datasoal) ?></h3>
                                <p>Soal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-briefcase"></i>
                            </div>
                            <a href="#" class="small-box-footer"></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class='animate__animated animate__flipInX col-md-12'>
                        <div class="box box-default">
                            <div class="box-header with-border alert-info" data-toggle="collapse" data-target=".infocollapse" aria-expanded="false" aria-controls="infocollapse" role="button">
                                <i class='fas fa-bullhorn'></i>
                                <h3 class="box-title">Pengumuman</h3>
                            </div>
                            <div class="collapse show infocollapse" id="infocollapse">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div id="pengumuman">
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
            <div class="col">
                <div class='animate__animated animate__flipInX btn-log'>
                    <div class='box box-solid direct-chat direct-chat-warning'>
                        <div class='box-header with-border' data-toggle="collapse" data-target=".logcollapse" aria-expanded="false" aria-controls="logcollapse" role="button">
                            <h3 class='box-title'><i class='fas fa-history'></i> Log Aktifitas</h3>
                        </div><!-- /.box-header -->
                        <div class="collapse show logcollapse" id="logcollapse" style="max-height: 100%; overflow: auto;">
                            <div class="box-body">
                                <div id="log-list">
                                    <p class='text-center'>
                                        <i class='fas fa-spin fa-spinner fa-circle-o-notch'></i> Loading....
                                    </p>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection(); ?>