<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <form action="/pd/save/tambah" method="POST" class="formpd">
                <?= csrf_field(); ?>
                <div class="col-12 mb-2" align="right">
                    <button type="submit" id="simpan" class="btn btn-success btn-sm"><i class="fas fa-save fa-fw"></i> <span class="d-none d-lg-inline">Simpan</span></button>
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
                                        <option value="<?= $lm->npsn ?>" <?= ($lm->npsn == session()->get('username')) ? "selected" : "" ?>><?= $lm->lembaga ?></option>
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
                                <input type="text" class="form-control form-input form-control-sm" id="nama" name="nama" autocomplete="off">
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
                                            <input type="radio" class="form-check-input jk" id="man" name="jk" value="L">
                                            <label class="form-check-label" for="man">Laki-laki</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input jk" id="woman" name="jk" value="P">
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
                                <input type="text" class="form-control form-input form-control-sm" id="nisn" name="nisn" autocomplete="off">
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
                                <input type="text" class="form-control form-input form-control-sm" id="nik" name="nik" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tempat lahir
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="tempatlahir" name="tempatlahir" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tanggal lahir
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" id="date" name="tgllahir" class="form-control datetimepicker-input form-control-sm" autocomplete="off" />
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
                                <select class="form-control form-select agama form-select-sm" id="agama" name="agama">
                                    <option selected disabled></option>
                                    <?php foreach ($resultAgama as $ag) : ?>
                                        <option value="<?= $ag->agama ?>"><?= $ag->agama ?></option>
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
                                <input type="text" class="form-control form-input form-control-sm" id="alamat" name="alamat" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                RT
                            </label>
                            <div class="col">
                                <div class="invalid-feedback"></div>
                                <input type="text" class="form-control form-input form-control-sm" id="rt" name="rt" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                RW
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="rw" name="rw" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Dusun
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="dusun" name="dusun" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Desa/Kelurahan
                                <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="kelurahan" name="kelurahan" autocomplete="off">
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
                                        <option value="<?= $k->nama ?>"><?= $k->nama ?></option>
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
                                <input type="text" class="form-control form-input form-control-sm" id="kodepos" name="kodepos" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tempat Tinggal <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="jenis-tinggal form-select form-select-sm" id="jenistinggal" name="jenistinggal">
                                    <option selected disabled></option>
                                    <option value="Bersama orang tua">Bersama orang tua</option>
                                    <option value="Wali">Wali</option>
                                    <option value="Kost">Kost</option>
                                    <option value="Asrama">Asrama</option>
                                    <option value="Panti Asuhan">Panti Asuhan</option>
                                    <option value="Pesantren">Pesantren</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                    <option value="Jalan kaki">Jalan kaki</option>
                                    <option value="Angkutan umum/bus/pete-pete">Angkutan umum/bus/pete-pete</option>
                                    <option value="Mobil/bus antar jemput">Mobil/bus antar jemput</option>
                                    <option value="Kereta api">Kereta api</option>
                                    <option value="Ojek">Ojek</option>
                                    <option value="Andong/bendi/sado/dokar/delman/becak">Andong/bendi/sado/dokar/delman/becak</option>
                                    <option value="Perahu penyeberangan/rakit/getek">Perahu penyeberangan/rakit/getek</option>
                                    <option value="Kuda">Kuda</option>
                                    <option value="Sepeda">Sepeda</option>
                                    <option value="Sepeda motor">Sepeda motor</option>
                                    <option value="Mobil pribadi">Mobil pribadi</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                <input type="text" class="form-control form-input form-control-sm" id="namaayah" name="namaayah" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tahun Lahir
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="thnayah" name="thnayah" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pendidikan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pendidikanayah form-select form-select-sm" id="pendidikanayah" name="pendidikanayah">
                                    <option selected disabled></option>
                                    <option value="SD/Sederajat">SD / Sederajat</option>
                                    <option value="SMP/Sederajat">SMP / Sederajat</option>
                                    <option value="SMA/Sederajat">SMA / Sederajat</option>
                                    <option value="D1">D1</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Tidak sekolah">Tidak sekolah</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                    <option value="Tidak bekerja">Tidak bekerja</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Peternak">Peternak</option>
                                    <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                                    <option value="Karyawan swasta">Karyawan swasta</option>
                                    <option value="Pedagang kecil">Pedagang kecil</option>
                                    <option value="Pedagang besar">Pedagang besar</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                    <option value="Buruh">Buruh</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="TKI">Tenaga Kerja Indonesia</option>
                                    <option value="Tidak dapat diterapkan">Tidak dapat diterapkan</option>
                                    <option value="Sudah meninggal">Sudah meninggal</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                    <option value="Kurang dari Rp. 500.000">Kurang dari Rp. 500.000</option>
                                    <option value="Rp. 500.000 - Rp. 999.999">Rp. 500.000 - Rp. 999.999</option>
                                    <option value="Rp. 1.000.000 - Rp. 1.999.999">Rp. 1.000.000 - Rp. 1.999.999</option>
                                    <option value="Rp. 2.000.000 - Rp. 4.999.999">Rp. 2.000.000 - Rp. 4.999.999</option>
                                    <option value="Rp. 5.000.000 - Rp. 20.000.000">Rp. 5.000.000 - Rp. 20.000.000</option>
                                    <option value="Lebih dari Rp. 20.000.000">Lebih dari Rp. 20.000.000</option>
                                    <option value="Tidak ada">Tidak ada</option>
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
                                <input type="text" class="form-control form-input form-control-sm" id="ibukandung" name="ibukandung" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Tahun Lahir
                            </label>
                            <div class="col">
                                <input type="text" class="form-control form-input form-control-sm" id="thnibu" name="thnibu" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Pendidikan <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="pendidikanibu form-select form-select-sm" id="pendidikanibu" name="pendidikanibu">
                                    <option selected disabled></option>
                                    <option value="SD/Sederajat">SD / Sederajat</option>
                                    <option value="SMP/Sederajat">SMP / Sederajat</option>
                                    <option value="SMA/Sederajat">SMA / Sederajat</option>
                                    <option value="D1">D1</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    <option value="Tidak sekolah">Tidak sekolah</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                    <option value="Tidak bekerja">Tidak bekerja</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Peternak">Peternak</option>
                                    <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                                    <option value="Karyawan swasta">Karyawan swasta</option>
                                    <option value="Pedagang kecil">Pedagang kecil</option>
                                    <option value="Pedagang besar">Pedagang besar</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                    <option value="Buruh">Buruh</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="TKI">Tenaga Kerja Indonesia</option>
                                    <option value="Tidak dapat diterapkan">Tidak dapat diterapkan</option>
                                    <option value="Sudah meninggal">Sudah meninggal</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                    <option value="Kurang dari Rp. 500.000">Kurang dari Rp. 500.000</option>
                                    <option value="Rp. 500.000 - Rp. 999.999">Rp. 500.000 - Rp. 999.999</option>
                                    <option value="Rp. 1.000.000 - Rp. 1.999.999">Rp. 1.000.000 - Rp. 1.999.999</option>
                                    <option value="Rp. 2.000.000 - Rp. 4.999.999">Rp. 2.000.000 - Rp. 4.999.999</option>
                                    <option value="Rp. 5.000.000 - Rp. 20.000.000">Rp. 5.000.000 - Rp. 20.000.000</option>
                                    <option value="Lebih dari Rp. 20.000.000">Lebih dari Rp. 20.000.000</option>
                                    <option value="Tidak ada">Tidak ada</option>
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
                                            <input type="radio" class="form-check-input availabelwali" id="tidak" name="wali" value="Tidak">
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
                                    <input type="text" class="form-control form-input form-control-sm" id="namawali" name="namawali" autocomplete="off">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Tahun Lahir
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control form-input form-control-sm" id="thnwali" name="thnwali" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                    Pendidikan <span class="text-red">*</span>
                                </label>
                                <div class="col">
                                    <select class="pendidikanwali form-select form-select-sm" id="pendidikanwali" name="pendidikanwali">
                                        <option selected disabled></option>
                                        <option value="SD/Sederajat">SD / Sederajat</option>
                                        <option value="SMP/Sederajat">SMP / Sederajat</option>
                                        <option value="SMA/Sederajat">SMA / Sederajat</option>
                                        <option value="D1">D1</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="Tidak sekolah">Tidak sekolah</option>
                                        <option value="Lainnya">Lainnya</option>
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
                                        <option value="Tidak bekerja">Tidak bekerja</option>
                                        <option value="Nelayan">Nelayan</option>
                                        <option value="Petani">Petani</option>
                                        <option value="Peternak">Peternak</option>
                                        <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                                        <option value="Karyawan swasta">Karyawan swasta</option>
                                        <option value="Pedagang kecil">Pedagang kecil</option>
                                        <option value="Pedagang besar">Pedagang besar</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Wirausaha">Wirausaha</option>
                                        <option value="Buruh">Buruh</option>
                                        <option value="Pensiunan">Pensiunan</option>
                                        <option value="TKI">Tenaga Kerja Indonesia</option>
                                        <option value="Tidak dapat diterapkan">Tidak dapat diterapkan</option>
                                        <option value="Sudah meninggal">Sudah meninggal</option>
                                        <option value="Lainnya">Lainnya</option>
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
                                        <option value="Kurang dari Rp. 500.000">Kurang dari Rp. 500.000</option>
                                        <option value="Rp. 500.000 - Rp. 999.999">Rp. 500.000 - Rp. 999.999</option>
                                        <option value="Rp. 1.000.000 - Rp. 1.999.999">Rp. 1.000.000 - Rp. 1.999.999</option>
                                        <option value="Rp. 2.000.000 - Rp. 4.999.999">Rp. 2.000.000 - Rp. 4.999.999</option>
                                        <option value="Rp. 5.000.000 - Rp. 20.000.000">Rp. 5.000.000 - Rp. 20.000.000</option>
                                        <option value="Lebih dari Rp. 20.000.000">Lebih dari Rp. 20.000.000</option>
                                        <option value="Tidak ada">Tidak ada</option>
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
                                <input type="number" class="form-control form-input form-control-sm" id="notelp" name="notelp" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                No. HP
                            </label>
                            <div class="col">
                                <input type="number" class="form-control form-input form-control-sm" id="handphone" name="handphone" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-sm-3 col-lg-2 col-form-label">
                                Email Aktif
                            </label>
                            <div class="col">
                                <input type="email" class="form-control form-input form-control-sm" id="email" name="email" autocomplete="off">
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