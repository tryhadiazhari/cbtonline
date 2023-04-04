<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <form action="/pd/save/edit" method="POST" class="formpd">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $pd['id_siswa'] ?>">

                <div class="col-12 mb-2" align="right">
                    <button type="submit" id="simpan" class="btn btn-success btn-sm"><i class="fas fa-save fa-fw"></i> <span class="hidden-xs">Simpan</span></button>
                    <button type="button" onclick="window.location='/pd/'" class="btn btn-secondary btn-sm"><i class="fas fa-times fa-fw"></i></button>
                </div>
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
                        <div class="mb-3 row" <?= (session()->get('level') == 2) ? 'hidden' : ''; ?>>
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Satuan Pendidikan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="form-select form-select-sm satuanpendidikan" id="satuanpendidikan" name="satuanpendidikan">
                                    <option selected disabled></option>
                                    <?php foreach ($resultLembaga as $lm) : ?>
                                        <option value="<?= $lm->lembaga ?>" <?= ($pd['npsn'] == $lm->lembaga) ? "selected" : ""; ?>><?= $lm->lembaga ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback satuanpendidikan-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Nama <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="nama" name="nama" autocomplete="off" value="<?= $pd['nama'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Jenis Kelamin
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <div class="row checkbox">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input jk" id="man" name="jk" value="L" <?= ($pd['jk'] == "L") ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="man">Laki-laki</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input jk" id="woman" name="jk" value="P" <?= ($pd['jk'] == "P") ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="woman">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                NISN
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="nisn" name="nisn" autocomplete="off" value="<?= $pd['nisn'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Kewarganegaraan
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="warganegara" name="warganegara" autocomplete="off" value="Indonesia" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                NIK
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="nik" name="nik" autocomplete="off" value="<?= $pd['nik'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tempat lahir
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="tempatlahir" name="tempatlahir" autocomplete="off" value="<?= $pd['tempat_lahir'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tanggal lahir
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <div class="input-group date" id="date" data-target-input="nearest">
                                    <input type="text" name="tgllahir" class="form-control datetimepicker-input form-control-sm" data-target="#date" autocomplete="off" value="<?= $pd['tanggal_lahir'] ?>" />
                                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Agama <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="form-select agama form-select-sm" id="agama" name="agama">
                                    <option selected disabled></option>
                                    <?php foreach ($resultAgama as $ag) : ?>
                                        <option value="<?= $ag->agama ?>" <?= ($pd['agama'] == $ag->agama) ? "selected" : "" ?>><?= $ag->agama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback form-select-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Alamat
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="alamat" name="alamat" autocomplete="off" value="<?= $pd['alamat'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                RT
                            </label>
                            <div class="col">
                                <div class="invalid-feedback"></div>
                                <input type="text" class="form-control form-input form-control-sm" id="rt" name="rt" autocomplete="off" value="<?= $pd['rt'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                RW
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="rw" name="rw" autocomplete="off" value="<?= $pd['rw'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Dusun
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="dusun" name="dusun" autocomplete="off" value="<?= $pd['dusun'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Desa/Kelurahan
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="kelurahan" name="kelurahan" autocomplete="off" value="<?= $pd['kelurahan'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Kecamatan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="form-select form-select-sm kecamatan" id="kecamatan" name="kecamatan">
                                    <option selected disabled></option>
                                    <?php foreach ($resultKecamatan as $k) : ?>
                                        <option value="<?= $k->nama ?>" <?= ($pd['kecamatan'] == $k->nama) ? "selected" : "" ?>><?= $k->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback kecamatan-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Kode Pos
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="kodepos" name="kodepos" autocomplete="off" value="<?= $pd['kode_pos'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tempat Tinggal <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="jenis-tinggal form-select form-select-sm" id="jenistinggal" name="jenistinggal">
                                    <option selected disabled></option>
                                    <?php foreach ($resultTinggal as $jt) : ?>
                                        <option value="<?= $jt->jenis_tinggal ?>" <?= ($pd['jenis_tinggal'] == $jt->jenis_tinggal) ? "selected" : "" ?>><?= $jt->jenis_tinggal ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback jenistinggal"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Transportasi <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="transportasi form-select form-select-sm" id="transportasi" name="transportasi">
                                    <option selected disabled></option>
                                    <?php foreach ($resultTransport as $tr) : ?>
                                        <option value="<?= $tr->transportasi ?>" <?= ($pd['alat_transportasi'] == $tr->transportasi) ? "selected" : "" ?>><?= $tr->transportasi ?></option>
                                    <?php endforeach; ?>
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
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Nama Ayah <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="namaayah" name="namaayah" autocomplete="off" value="<?= $pd['nama_ayah'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tahun Lahir
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="thnayah" name="thnayah" autocomplete="off" value="<?= $pd['tahun_ayah'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pendidikan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pendidikanayah form-select form-select-sm" id="pendidikanayah" name="pendidikanayah">
                                    <option selected disabled></option>
                                    <?php foreach ($resultPendidikan as $pdAyah) : ?>
                                        <option value="<?= $pdAyah->pendidikan ?>" <?= ($pd['pendidikan_ayah'] == $pdAyah->pendidikan) ? "selected" : "" ?>><?= $pdAyah->pendidikan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback pendidikanayah-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pekerjaan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pekerjaanayah form-select form-select-sm" id="pekerjaanayah" name="pekerjaanayah">
                                    <option selected disabled></option>
                                    <?php foreach ($resultPekerjaan as $pkAyah) : ?>
                                        <option value="<?= $pkAyah->pekerjaan ?>" <?= ($pd['pekerjaan_ayah'] == $pkAyah->pekerjaan) ? "selected" : "" ?>><?= $pkAyah->pekerjaan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback pekerjaanayah-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Penghasilan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="penghasilanayah form-select form-select-sm" id="penghasilanayah" name="penghasilanayah">
                                    <option selected disabled></option>
                                    <?php foreach ($resultHasil as $hsAyah) : ?>
                                        <option value="<?= $hsAyah->penghasilan ?>" <?= ($pd['penghasilan_ayah'] == $hsAyah->penghasilan) ? "selected" : "" ?>><?= $hsAyah->penghasilan ?></option>
                                    <?php endforeach; ?>
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
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Nama ibu kandung <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="ibukandung" name="ibukandung" autocomplete="off" value="<?= $pd['nama_ibu'] ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tahun Lahir
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="thnibu" name="thnibu" autocomplete="off" value="<?= $pd['tahun_ibu'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pendidikan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pendidikanibu form-select form-select-sm" id="pendidikanibu" name="pendidikanibu">
                                    <option selected disabled></option>
                                    <?php foreach ($resultPendidikan as $pdIbu) : ?>
                                        <option value="<?= $pdIbu->pendidikan ?>" <?= ($pd['pendidikan_ibu'] == $pdIbu->pendidikan) ? "selected" : "" ?>><?= $pdIbu->pendidikan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback pendidikanibu-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pekerjaan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pekerjaanibu form-select form-select-sm" id="pekerjaanibu" name="pekerjaanibu">
                                    <option selected disabled></option>
                                    <?php foreach ($resultPekerjaan as $pkIbu) : ?>
                                        <option value="<?= $pkIbu->pekerjaan ?>" <?= ($pd['pekerjaan_ibu'] == $pkIbu->pekerjaan) ? "selected" : "" ?>><?= $pkIbu->pekerjaan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback pekerjaanibu-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Penghasilan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="penghasilanibu form-select form-select-sm" id="penghasilanibu" name="penghasilanibu">
                                    <option selected disabled></option>
                                    <?php foreach ($resultHasil as $hsIbu) : ?>
                                        <option value="<?= $hsIbu->penghasilan ?>" <?= ($pd['penghasilan_ibu'] == $hsIbu->penghasilan) ? "selected" : "" ?>><?= $hsIbu->penghasilan ?></option>
                                    <?php endforeach; ?>
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
                        <?php
                        if ($pd['nama_wali'] == "" && $pd['pendidikan_wali'] == "" && $pd['pekerjaan_wali'] == "" && $pd['penghasilan_wali'] == "") {
                            $check = "checked";
                        } else {
                            $checks = "checked";
                        }
                        ?>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Mempunyai Wali?
                            </label>
                            <div class="col">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input availabelwali" id="ada" name="wali" value="Ya">
                                            <label class="form-check-label" for="ada">Ya</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input availabelwali" id="tidak" name="wali" value="Tidak" <?= $check ?>>
                                            <label class="form-check-label" for="tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-wali px-0 pb-0" style="display: none">
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Nama Wali <span class="text-red">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control form-input form-control-sm" id="namawali" name="namawali" autocomplete="off" value="<?= $pd['nama_wali'] ?>">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Tahun Lahir
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control form-input form-control-sm" id="thnwali" name="thnwali" autocomplete="off" value="<?= $pd['tahun_wali'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Pendidikan <span class="text-red">*</span>
                                </label>
                                <div class="col">
                                    <select class="pendidikanwali form-select form-select-sm" id="pendidikanwali" name="pendidikanwali">
                                        <option selected disabled></option>
                                        <?php foreach ($resultPendidikan as $pdWali) : ?>
                                            <option value="<?= $pdWali->pendidikan ?>" <?= ($pd['pendidikan_wali'] == $pdWali->pendidikan) ? "selected" : "" ?>><?= $pdWali->pendidikan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback pendidikanwali-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Pekerjaan <span class="text-red">*</span>
                                </label>
                                <div class="col">
                                    <select class="pekerjaanwali form-select form-select-sm" id="pekerjaanwali" name="pekerjaanwali">
                                        <option selected disabled></option>
                                        <?php foreach ($resultPekerjaan as $pkWali) : ?>
                                            <option value="<?= $pkWali->pekerjaan ?>" <?= ($pd['pekerjaan_wali'] == $pkWali->pekerjaan) ? "selected" : "" ?>><?= $pkWali->pekerjaan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback pekerjaanwali-feedback"></div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Penghasilan <span class="text-red">*</span>
                                </label>
                                <div class="col">
                                    <select class="penghasilanwali form-select form-select-sm" id="penghasilanwali" name="penghasilanwali">
                                        <option selected disabled></option>
                                        <?php foreach ($resultHasil as $hsWali) : ?>
                                            <option value="<?= $hsWali->penghasilan ?>" <?= ($pd['penghasilan_wali'] == $hsWali->penghasilan) ? "selected" : "" ?>><?= $hsWali->penghasilan ?></option>
                                        <?php endforeach; ?>
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
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                No. Telp. Rumah
                            </label>
                            <div class="col">
                                <input type="number" class="form-control form-input form-control-sm" id="notelp" name="notelp" autocomplete="off" value="<?= $pd['telepon'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                No. HP
                            </label>
                            <div class="col">
                                <input type="number" class="form-control form-input form-control-sm" id="handphone" name="handphone" autocomplete="off" value="<?= $pd['hp'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Email Aktif
                            </label>
                            <div class="col">
                                <input type="email" class="form-control form-input form-control-sm" id="email" name="email" autocomplete="off" value="<?= $pd['email'] ?>">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection(); ?>