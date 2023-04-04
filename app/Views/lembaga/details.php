<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row my-2">
            <div class="col">
                <h1 style='text-shadow: 2px 2px 4px #827e7e;'>
                    <?= $titlecontent ?>
                </h1>
            </div>
            <div class="col-auto ml-auto">
                <button type="button" onclick="window.location='../'" class="btn btn-sm btn-danger">
                    <i class="fas fa-arrow-left fa-fw"></i> <span class="d-none d-md-inline">Kembali</span></button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= ($datalembaga['logo'] == '') ? '/assets/dist/img/7.png' : 'data:image/jpeg; base64, ' . base64_encode($datalembaga['logo']) ?>" alt="<?= $datalembaga['sp'] ?>">
                        </div>

                        <h3 class="profile-username text-center"><?= $datalembaga['sp'] ?></h3>

                        <p class="text-muted text-center"><?= $datalembaga['jenis'] . ' | ' . $datalembaga['status'] ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Tenaga Pendidik</b> <a class="float-right"><?= count($resultgtk) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Peserta Didik</b> <a class="float-right"><?= count($resultpd) ?></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Bentuk Pendidikan</strong>
                        <p class="text-muted"><?= $datalembaga['jenis'] ?></p>

                        <hr>

                        <strong><i class="fas fa-book mr-1"></i> Status</strong>
                        <p class="text-muted"><?= $datalembaga['status'] ?></p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted"><?= $datalembaga['alamat'] . ', ' . ucwords(strtolower($datalembaga['kelurahan'])) . ', ' . ucwords(strtolower($datalembaga['kecamatan'])) . ', ' . ucwords(strtolower($datalembaga['kabupaten'])) . ', ' . ucwords(strtolower($datalembaga['provinsi'])) ?></p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Program Pendidikan</strong>
                        <p class="text-muted">
                            <?= $datalembaga['jenjang'] ?>
                        </p>
                        <hr>

                        <strong><i class="fas fa-user-alt mr-1"></i> Operator</strong>
                        <p class="text-muted mb-0">
                            <?= $operator['fname'] ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-profile-tab" data-toggle="pill" href="#custom-tabs-profile" role="tab" aria-controls="custom-tabs-profile" aria-selected="false">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-ruang-tab" data-toggle="pill" href="#custom-tabs-ruang" role="tab" aria-controls="custom-tabs-ruang" aria-selected="true">Ruang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-pd-tab" data-toggle="pill" href="#custom-tabs-pd" role="tab" aria-controls="custom-tabs-pd" aria-selected="false">Peserta Didik</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-gtk-tab" data-toggle="pill" href="#custom-tabs-gtk" role="tab" aria-controls="custom-tabs-gtk" aria-selected="false">GTK</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-rombel-tab" data-toggle="pill" href="#custom-tabs-rombel" role="tab" aria-controls="custom-tabs-rombel" aria-selected="false">Rombel</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-profile" role="tabpanel" aria-labelledby="custom-tabs-profile-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <table class="table table-borderless table-responsive" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="26%">NPSN</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['npsn'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Satuan Pendidikan</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['sp'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Bentuk Satuan Pendidikan</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['jenis'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['status'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Program/Jenjang</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['jenjang'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kepala Sekolah/Pengelola</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['kepsek'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['alamat'] . ', ' . ucwords(strtolower($datalembaga['kelurahan'])) . ', ' . ucwords(strtolower($datalembaga['kecamatan'])) . ', ' . ucwords(strtolower($datalembaga['kabupaten'])) . ', ' . ucwords(strtolower($datalembaga['provinsi'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Telp</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['telp'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['email'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Website</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datalembaga['website'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Operator</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $operator['fname'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $operator['eml'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Hp</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $operator['hp'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-ruang" role="tabpanel" aria-labelledby="custom-tabs-ruang-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <h4 class="text-center">Coming Soon...</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-pd" role="tabpanel" aria-labelledby="custom-tabs-pd-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <h4 class="text-center">Coming Soon...</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-gtk" role="tabpanel" aria-labelledby="custom-tabs-gtk-tab">
                                <div class="row">
                                    <?php foreach ($resultgtk as $gtks) : ?>
                                        <div class="col-12 col-md-6 d-flex align-items-stretch">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="lead"><b><?= $gtks['nama'] ?></b></h2>
                                                            <p class="text-muted text-sm"><?= $gtks['jenis_ptk'] . ' - ' . $gtks['status_gtk'] . ' - ' . $gtks['nuptk'] ?></p>
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <img src="/assets/dist/img/avatar_default.png" alt="user-avatar" class="img-circle img-fluid">
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                <li class="text-sm mb-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?= ($gtks['alamat'] == '') ? '-' : $gtks['alamat'] . ', ' . ucwords(strtolower($gtks['kelurahan'] . ', ' . $gtks['kecamatan'] . ', ' . $datalembaga['kabupaten'] . ', ' . $datalembaga['provinsi'])) ?></li>
                                                                <li class="text-sm"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <?= ($gtks['hp'] == '') ? '-' : $gtks['hp'] ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-rombel" role="tabpanel" aria-labelledby="custom-tabs-rombel-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <table id="tabelrombel" class="table table-hover table-responsive nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">#</th>
                                                    <th style="width: 200px">Program/Kompetensi</th>
                                                    <th style="width: 200px">Tingkatan Pendidikan</th>
                                                    <th style="width: 200px">Kurikulum</th>
                                                    <th style="width: 200px">Nama Rombel</th>
                                                    <th style="width: 200px">Wali Kelas</th>
                                                    <th style="width: 200px">Ruang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($resultrombel as $nomor => $val) : ?>
                                                    <tr>
                                                        <td><?= $nomor + 1 ?></td>
                                                        <td><?= $val['jenjang'] ?></td>
                                                        <td><?= $val['tingkatan'] ?></td>
                                                        <td><?= $val['kurikulum'] ?></td>
                                                        <td><?= $val['nama'] ?></td>
                                                        <td><?= $val['wali_kelas'] ?></td>
                                                        <td><?= $val['ruang'] ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-setting" role="tabpanel" aria-labelledby="custom-tabs-setting-tab">
                                <div class="card my-0" id="formaccount">
                                    <form action="<?= (session()->lv == 1) ? '/admin/sp' : '/sp' ?>/account/<?= $operator['uid'] ?>" method="POST">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control col-md-4" id="newpassword" name="newpassword">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-eye fa-fw showpass"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback newpassword-feedback" style="font-size: 12px"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Ulangi Kata Sandi</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control col-md-4" id="repeatpassword" name="repeatpassword">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-eye fa-fw showrepeatpass"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback repeatpassword-feedback" style="font-size: 12px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#tabelrombel').DataTable({
            "paging": true,
            "info": true,
            "ordering": true,
            "lengthMenu": [
                [10, 20, 25, 30, 35, 40, 45, 50, -1],
                [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
            ],
        });
    });
</script>
<?= $this->endSection(); ?>