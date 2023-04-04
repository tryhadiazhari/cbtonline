<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
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
            <div class="col-auto ms-auto">
                <button type="submit" class="btn btn-success btn-sm <?= ($akses['import'] == 0) ? 'd-none' : '' ?>" data-toggle="modal" data-target="#modalimport">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Data</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>" data-toggle="modal" data-target="#modalform">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12">
            <div class="card-body">
                <table id="datatabel" class="table table-hover table-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>NISN</th>
                            <th>Tingkatan</th>
                            <th>Rombel</th>
                            <th width="0" class="noshort"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalform" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalformLabel" aria-hidden="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content card-outline card-info">
                <form action="#" class="modalform" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalformLabel"></h5>
                    </div>
                    <div class="modal-body m-0" style="max-height: 370px; overflow-y: auto">
                        <div class="row">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Data Pribadi</h3>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Satuan Pendidikan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select satuanpendidikan" id="satuanpendidikan" name="satuanpendidikan" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($satuanpendidikan as $sp) : ?>
                                                    <option value="<?= $sp['npsn'] ?>" <?= (session()->npsn == $sp['npsn']) ? 'selected' : '' ?>><?= $sp['sp'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback satuanpendidikan-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Nama <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="nama" name="nama">
                                            <div class="invalid-feedback nama-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Jenis Kelamin
                                            <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input jk" id="L" name="jk" value="L">
                                                <label class="form-check-label" for="man">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input jk" id="P" name="jk" value="P">
                                                <label class="form-check-label" for="P">Perempuan</label>
                                            </div>
                                            <div class="invalid-feedback jk-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            NISN <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="nisn" name="nisn" maxlength="10">
                                            <div class="invalid-feedback nisn-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Kewarganegaraan
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="warganegara" name="warganegara" value="Indonesia" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            NIK <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="nik" name="nik" maxlength="16">
                                            <div class="invalid-feedback nik-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Tempat lahir
                                            <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir">
                                            <div class="invalid-feedback tempatlahir-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Tanggal lahir
                                            <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <div class="input-group tgllahir" data-target-input="nearest">
                                                <input type="text" id="tgllahir" name="tgllahir" class="form-control datetimepicker-input" />
                                                <div class="input-group-append" data-target="#tgllahir" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <div class="invalid-feedback tgllahir-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Agama <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select agama" id="agama" name="agama" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($dataagama as $agama) : ?>
                                                    <option value="<?= $agama['agama'] ?>"><?= $agama['agama']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback agama-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Alamat
                                            <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="alamat" name="alamat">
                                            <div class="invalid-feedback alamat-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            RT / RW
                                        </label>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-lg-2 col-6">
                                                    <input type="text" class="form-control" id="rt" name="rt" maxlength="3">
                                                </div>
                                                <div class="col-lg-2 col-6">
                                                    <input type="text" class="form-control" id="rw" name="rw" maxlength="3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Provinsi <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select provinsi" id="provinsi" name="provinsi" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($provinsi as $pr) : ?>
                                                    <option value="<?= $pr['name'] ?>" data-id="<?= $pr['id'] ?>"><?= $pr['name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback provinsi-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Kabupaten <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select kabupaten" id="kabupaten" name="kabupaten" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                            </select>
                                            <div class="invalid-feedback kabupaten-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Kecamatan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select kecamatan" id="kecamatan" name="kecamatan" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                            </select>
                                            <div class="invalid-feedback kecamatan-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Desa/Kelurahan
                                            <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-select kelurahan" id="kelurahan" name="kelurahan" data-placeholder="Pilih">
                                                <option disabled selected></option>
                                            </select>
                                            <div class="invalid-feedback kelurahan-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Dusun
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="dusun" name="dusun">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Kode Pos
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="kodepos" name="kodepos" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Tempat Tinggal <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="jenis-tinggal form-select" id="jenistinggal" name="jenistinggal" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datatinggal as $jenistinggal) : ?>
                                                    <option value="<?= $jenistinggal['jenis_tinggal'] ?>"><?= $jenistinggal['jenis_tinggal'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback jenistinggal-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-form-label">
                                            Transportasi <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="transportasi form-select" id="transportasi" name="transportasi" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datatransportasi as $transportasi) : ?>
                                                    <option value="<?= $transportasi['transportasi'] ?>"><?= $transportasi['transportasi'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback transportasi-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Ayah Kandung</h3>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Nama Ayah <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="namaayah" name="namaayah">
                                            <div class="invalid-feedback namaayah-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Tahun Lahir <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="thnayah" name="thnayah" maxlength="4">
                                            <div class="invalid-feedback thnayah-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Pendidikan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="pendidikanayah form-select" id="pendidikanayah" name="pendidikanayah" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapendidikan as $pendidikan) : ?>
                                                    <option value="<?= $pendidikan['pendidikan'] ?>"><?= $pendidikan['pendidikan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback pendidikanayah-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Pekerjaan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="pekerjaanayah form-select" id="pekerjaanayah" name="pekerjaanayah" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapekerjaan as $pekerjaan) : ?>
                                                    <option value="<?= $pekerjaan['pekerjaan'] ?>"><?= $pekerjaan['pekerjaan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback pekerjaanayah-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-form-label">
                                            Penghasilan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="penghasilanayah form-select" id="penghasilanayah" name="penghasilanayah" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapenghasilan as $penghasilan) : ?>
                                                    <option value="<?= $penghasilan['penghasilan'] ?>"><?= $penghasilan['penghasilan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback penghasilanayah-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Ibu Kandung</h3>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Nama Ibu Kandung <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="ibukandung" name="ibukandung">
                                            <div class="invalid-feedback ibukandung-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Tahun Lahir <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="thnibu" name="thnibu" maxlength="4">
                                            <div class="invalid-feedback thnibu-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Pendidikan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="pendidikanibu form-select" id="pendidikanibu" name="pendidikanibu" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapendidikan as $pendidikan) : ?>
                                                    <option value="<?= $pendidikan['pendidikan'] ?>"><?= $pendidikan['pendidikan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback pendidikanibu-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            Pekerjaan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="pekerjaanibu form-select" id="pekerjaanibu" name="pekerjaanibu" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapekerjaan as $pekerjaan) : ?>
                                                    <option value="<?= $pekerjaan['pekerjaan'] ?>"><?= $pekerjaan['pekerjaan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback pekerjaanibu-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-form-label">
                                            Penghasilan <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="penghasilanibu form-select" id="penghasilanibu" name="penghasilanibu" data-placeholder="Pilih">
                                                <option selected disabled></option>
                                                <?php foreach ($datapenghasilan as $penghasilan) : ?>
                                                    <option value="<?= $penghasilan['penghasilan'] ?>"><?= $penghasilan['penghasilan'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div class="invalid-feedback penghasilanibu-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Wali</h3>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-lg-2 col-form-label">
                                            Mempunyai Wali?
                                        </label>
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input wali" id="Ya" name="wali" value="Ya">
                                                <label class="form-check-label" for="Ya">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input wali" id="Tidak" name="wali" value="Tidak" checked>
                                                <label class="form-check-label" for="Tidak">Tidak</label>
                                            </div>
                                            <div class="invalid-feedback wali-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="card-body card-wali px-0 pb-0" style="display: none">
                                        <div class="mb-3 row">
                                            <label class="col-lg-2 col-form-label">
                                                Nama Wali <span class="text-red">*</span>
                                            </label>
                                            <div class="col">
                                                <input type="text" class="form-control" id="namawali" name="namawali">
                                                <div class="invalid-feedback namawali-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-2 col-form-label">
                                                Tahun Lahir <span class="text-red">*</span>
                                            </label>
                                            <div class="col">
                                                <input type="text" class="form-control" id="thnwali" name="thnwali" maxlength="4">
                                                <div class="invalid-feedback thnwali-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-2 col-form-label">
                                                Pendidikan <span class="text-red">*</span>
                                            </label>
                                            <div class="col">
                                                <select class="pendidikanwali form-select" id="pendidikanwali" name="pendidikanwali" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <?php foreach ($datapendidikan as $pendidikan) : ?>
                                                        <option value="<?= $pendidikan['pendidikan'] ?>"><?= $pendidikan['pendidikan'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback pendidikanwali-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-lg-2 col-form-label">
                                                Pekerjaan <span class="text-red">*</span>
                                            </label>
                                            <div class="col">
                                                <select class="pekerjaanwali form-select" id="pekerjaanwali" name="pekerjaanwali" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <?php foreach ($datapekerjaan as $pekerjaan) : ?>
                                                        <option value="<?= $pekerjaan['pekerjaan'] ?>"><?= $pekerjaan['pekerjaan'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback pekerjaanwali-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-lg-2 col-form-label">
                                                Penghasilan <span class="text-red">*</span>
                                            </label>
                                            <div class="col">
                                                <select class="penghasilanwali form-select" id="penghasilanwali" name="penghasilanwali" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <?php foreach ($datapenghasilan as $penghasilan) : ?>
                                                        <option value="<?= $penghasilan['penghasilan'] ?>"><?= $penghasilan['penghasilan'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback penghasilanwali-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Kontak</h3>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            No. Telp. Rumah
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="notelp" name="notelp">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-2 col-form-label">
                                            No. HP <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="handphone" name="handphone" maxlength="13">
                                            <div class="invalid-feedback handphone-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-form-label">
                                            Email Aktif <span class="text-red">*</span>
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="email" name="email">
                                            <div class="invalid-feedback email-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" name="simpan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary closed" data-dismiss="modal">Keluar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalimport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalimportLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content card-outline card-info">
                <form action="/pd/import" class="modalimport" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalimportLabel">Import <?= $titlecontent ?></h5>
                        <button type="button" class="close closed" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-0" style="max-height: 415px; overflow-y: auto">
                        <input type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback file-feedback"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="import" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#datatabel').DataTable({
            "paging": true,
            "info": true,
            "ordering": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [
                [10, 20, 25, 30, 35, 40, 45, 50, -1],
                [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
            "ajax": {
                "url": "<?= $_SERVER['REQUEST_URI']; ?>/viewdata",
                "dataSrc": function(data) {
                    return data.data;
                }
            }
        });

        $('.form-select').select2({
            theme: 'bootstrap4',
            placeholder: $(this).data('placeholder')
        });

        $('.wali').click(function() {
            if ($(this).val() == 'Ya') {
                $('.card-wali').removeAttr('style');
            } else {
                $('.card-wali').css('display', 'none');
            }
        });

        $('#nama, #tempatlahir, #namaayah, #ibukandung, #namawali').inputmask({
            placeholder: '',
            regex: "[a-zA-Z\\s]+$"
        });

        $('#alamat, #dusun').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\s\\./-]+$"
        });

        $('#tgllahir').inputmask({
            placeholder: '',
            alias: 'datetime',
            inputFormat: 'yyyy-mm-dd',
        }).datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $("#email").inputmask({
            placeholder: '',
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}][@]*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function(pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z]",
                    casing: "lower"
                }
            }
        });

        $('#notelp').inputmask({
            placeholder: '',
            regex: '\\d+$',
            mask: '[999-9999999]',
        });

        $('#handphone').inputmask({
            placeholder: '',
            regex: '\\d+$',
            mask: '[999999999999[9]]',
        });

        $('#rt, #rw, #kodepos, #nik, #thnayah, #thnibu, #thnwali, #nisn').inputmask({
            placeholder: '',
            regex: '\\d+$'
        });

        $("#provinsi").change(function() {
            $('#kabupaten').html('<option disabled selected></option>');
            $('#kecamatan').html('<option disabled selected></option>');
            $('#kelurahan').html('<option disabled selected></option>');

            $.ajax({
                url: '<?= base_url(); ?>/api/kabupaten/' + $('#provinsi option:selected').data('id'),
                type: 'GET',
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#kabupaten').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                    });
                }
            });
        });

        $("#kabupaten").change(function() {
            $('#kecamatan').html('<option disabled selected></option>');
            $('#kelurahan').html('<option disabled selected></option>');

            $.ajax({
                url: '<?= base_url(); ?>/api/kecamatan/' + $('#kabupaten option:selected').data('id'),
                type: 'GET',
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#kecamatan').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                    });
                }
            });
        });

        $("#kecamatan").change(function() {
            $('#kelurahan').html('<option disabled selected></option>');

            $.ajax({
                url: '<?= base_url(); ?>/api/kelurahan/' + $('#kecamatan option:selected').data('id'),
                type: 'GET',
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#kelurahan').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                    });
                }
            });
        });

        $('.btn-add').click(function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Tambah <?= $titlecontent ?>');
            $('#modalform').find('form').attr('action', '/pd/save');
        });

        $(document).on('click', '.btn-edit', function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Edit <?= $titlecontent ?>');

            $.ajax({
                url: $(this).data('href'),
                beforeSend: function() {
                    $('#loader').fadeIn();
                },
                complete: function() {
                    $('#loader').fadeOut('slow');
                },
                success: function(response) {
                    $('#modalform').find('form').attr('action', response.action);

                    $.each(response, function(fi, va) {
                        $("#" + fi).val(va);
                        $("#" + fi).val(va).trigger('change');
                    });

                    $('#' + response.kelamin).trigger('click');
                    $('#' + response.wali).trigger('click');

                    $("#satuanpendidikan").val(response.npsn).trigger('change');

                    $("#provinsi").val(response.provinsi).trigger('change');

                    $.ajax({
                        url: '<?= base_url(); ?>/api/kabupaten/' + $('#provinsi option:selected').data('id'),
                        type: 'GET',
                        success: function(data) {
                            $('#kabupaten').html('<option disabled selected></option>');
                            $.each(data, function(field, val) {
                                if (val.name == response.kabupaten) {
                                    $('#kabupaten').append('<option value="' + val.name + '" data-id="' + val.id + '" selected>' + val.name + '</option>').trigger('change');
                                } else {
                                    $('#kabupaten').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                                }
                            });

                            $.ajax({
                                url: '<?= base_url(); ?>/api/kecamatan/' + $('#kabupaten option:selected').data('id'),
                                type: 'GET',
                                success: function(data) {
                                    $('#kecamatan').html('<option disabled selected></option>');
                                    $.each(data, function(field, val) {
                                        if (val.name == response.kecamatan) {
                                            $('#kecamatan').append('<option value="' + val.name + '" data-id="' + val.id + '" selected>' + val.name + '</option>').trigger('change');
                                        } else {
                                            $('#kecamatan').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                                        }
                                    });

                                    $.ajax({
                                        url: '<?= base_url(); ?>/api/kelurahan/' + $('#kecamatan option:selected').data('id'),
                                        type: 'GET',
                                        success: function(data) {
                                            $('#kelurahan').html('<option disabled selected></option>');
                                            $.each(data, function(field, val) {
                                                if (val.name == response.kelurahan) {
                                                    $('#kelurahan').append('<option value="' + val.name + '" data-id="' + val.id + '" selected>' + val.name + '</option>').trigger('change');
                                                } else {
                                                    $('#kelurahan').append('<option value="' + val.name + '" data-id="' + val.id + '">' + val.name + '</option>');
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#simpan').html('<i class="fa fa-spinner-third fa-spin"></i>');
                    $('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                    $('.jk-feedback').html('');
                },
                complete: function() {
                    $('#simpan').html('Simpan');
                },
                statusCode: {
                    404: function(errors) {
                        $.each(errors.responseJSON, function(field, val) {
                            $('#' + field + ', .' + field).addClass('is-invalid');
                            $('.' + field + '-feedback').text(val);
                            $('.jk-feedback').addClass('d-block').text(errors.responseJSON.jk);
                        });
                    },
                    400: function(errors) {
                        toastr.error(errors.responseJSON.error);
                    },
                },
                success: function(response) {
                    toastr.success(response.success);
                    $(".modal").modal('hide').on('hidden.bs.modal', function() {
                        $('#datatabel').DataTable().ajax.reload();
                        $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $(".form-select").trigger("change");
                        $('.jk-feedback').removeClass('d-block');
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            swal.fire({
                icon: 'info',
                html: '<h3>Anda ingin hapus data ini?</h3>',
                confirmButtonText: 'Ya',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                cancelButtonColor: '#ff0000',
                width: 'auto'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: $(this).data('href'),
                        statusCode: {
                            400: function(error) {
                                toastr.error(error.responseJSON.error);
                            }
                        },
                        success: function(response) {
                            toastr.success(response.success);
                            $('#datatabel').DataTable().ajax.reload();
                            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                                $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                                $(this).find('form')[0].reset();
                                $(".form-select").trigger("change");
                                $('.jk-feedback').removeClass('d-block');
                            });
                        }
                    });
                }
            });
        });

        $('.closed').click(function() {
            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                $('#datatabel').DataTable().ajax.reload();
                $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                $(this).find('form')[0].reset();
                $(".form-select").trigger("change");
                $('.jk-feedback').removeClass('d-block');
            });
        });

        $('.modalimport').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#import').html('<i class="fas fa-spin fa-spinner-third"></i>');
                },
                complete: function() {
                    $('#import').html('Import');
                },
                statusCode: {
                    404: function(errors) {
                        $('.form-control').addClass('is-invalid');
                        $('.file-feedback').html(errors.responseText);
                    },
                    400: function(errors) {
                        console.log(errors)
                    }
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('#datatabel').DataTable().ajax.reload();
                    $(".modal").modal('hide').on('hidden.bs.modal', function() {
                        $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $(".form-select").trigger("change");
                        $('.jk-feedback').removeClass('d-block');
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>