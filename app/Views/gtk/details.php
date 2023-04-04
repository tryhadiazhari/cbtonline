<?= $this->extend('layout/template'); ?>
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
                            <img class="profile-user-img img-fluid img-circle" src="<?= ($datagtk['foto'] == '') ? '/assets/dist/img/avatar_default.png' : 'data:image/jpeg; base64, ' . base64_encode($datagtk['foto']) ?>" alt="<?= $datagtk['nama'] ?>">
                        </div>

                        <h3 class="profile-username text-center"><?= $datagtk['nama'] ?></h3>

                        <p class="text-muted text-center"><?= $datagtk['jenis_ptk'] . ' | ' . $datagtk['status_gtk'] ?></p>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-barcode mr-1"></i> NUPTK</strong>
                        <p class="text-muted"><?= ($datagtk['nuptk'] == '' || $datagtk['nuptk'] == 0) ? '-' : $datagtk['nuptk'] ?></p>

                        <hr>
                        <strong><i class="fas fa-chalkboard-teacher mr-1"></i> Jenis PTK</strong>
                        <p class="text-muted"><?= $datagtk['jenis_ptk'] ?></p>

                        <hr>

                        <strong><i class="fas fa-graduation-cap mr-1"></i> Status PTK</strong>
                        <p class="text-muted"><?= $datagtk['status_gtk'] ?></p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted"><?= $datagtk['alamat'] . ', ' . ucwords(strtolower($datagtk['kelurahan'])) . ', ' . ucwords(strtolower($datagtk['kecamatan'])) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kepegawaian-tab" data-toggle="pill" href="#kepegawaian" role="tab" aria-controls="kepegawaian" aria-selected="true">Kepegawaian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pendidikan-tab" data-toggle="pill" href="#pendidikan" role="tab" aria-controls="rombel" aria-selected="false">Kependidikan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pembelajaran-tab" data-toggle="pill" href="#pembelajaran" role="tab" aria-controls="pembelajaran" aria-selected="false">Pembelarajan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <table class="table table-borderless table-responsive" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">Nama Lengkap</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['nama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>NIK</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['nik'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tempat/Tgl Lahir</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['tempatlahir'] . ', ' . $datagtk['tgllahir'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['jk'] == 'L') ? 'Laki-Laki' : 'Perempuan' ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Agama</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['agama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Ibu Kandung</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['namaibu'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Perkawinan</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['statuskawin'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify">
                                                        <?= $datagtk['alamat'] . ', ' . ucwords(strtolower($datagtk['kelurahan'])) . ', ' . ucwords(strtolower($datagtk['kecamatan'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>RT / RW</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['rt'] . " / " . $datagtk['rw'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Dusun</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['dusun'] == '') ? '-' : $datagtk['dusun'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kode Pos</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['kodepos'] == 0) ? '-' : $datagtk['kodepos'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Telp</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['telepon'] == '' || $datagtk['telepon'] == 0) ? '-' : $datagtk['telepon'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Hp</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['hp'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['email'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="kepegawaian" role="tabpanel" aria-labelledby="kepegawaian-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <table class="table table-borderless table-responsive" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">Status PTK</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['status_gtk'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis PTK</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['jenis_ptk'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>NUPTK</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['nuptk'] == '' || $datagtk['nuptk'] == 0) ? '-' : $datagtk['nuptk'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>NIP</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['status_gtk'] == 'PNS') ? $datagtk['status_gtk'] : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <td>SK Kerja</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['sk_kerja'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>TMT Kerja</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['tmt_kerja'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Lembaga Pengangkatan</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['lembagapengangkatan'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Sumber Gaji</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= $datagtk['sumbergaji'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tugas Tambahan</td>
                                                    <td width="1%" class="px-0 text-right">:</td>
                                                    <td class="text-justify"><?= ($datagtk['tugastambahan'] == '') ? '-' : $datagtk['tugastambahan'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <h4 class="text-center">Coming Soon</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pembelajaran" role="tabpanel" aria-labelledby="pembelajaran-tab">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <h4 class="text-center">Coming Soon</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                <div class="card my-0" id="formaccount">
                                    <form action="<?= (session()->lv == 1) ? '/admin/gtk' : '/gtk' ?>/account/<?= $datagtk['uid_gtk'] ?>" method="POST">
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
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('.showpass').on('click', function() {
            if ($(this).hasClass('fa-eye')) {
                $('#newpassword').attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#newpassword').attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('.showrepeatpass').on('click', function() {
            if ($(this).hasClass('fa-eye')) {
                $('#repeatpassword').attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#repeatpassword').attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#simpan').html('<i class="fa fa-spin fa-spinner-third"></i>');
                    $('.form-control').removeClass('is-invalid');
                },
                complete: function() {
                    $('#simpan').html('Simpan');
                },
                statusCode: {
                    404: function(errors) {
                        $.each(errors.responseJSON, function(field, val) {
                            $('#' + field).addClass('is-invalid');
                            $('.' + field + '-feedback').text(val);
                        })
                    },
                    400: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: errors.responseJSON.error,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.success,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('form')[0].reset();
                    $('.showpass, .showrepeatpass').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            })
        })
    });
</script>
<?= $this->endSection(); ?>