<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                <button type="submit" class="btn btn-success bg-gradient btn-sm<?= ($akses['import'] == 0) ? ' d-none' : '' ?>" data-toggle="modal" data-target="#modalimport">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Data</span>
                </button>
                <button type="button" class="btn btn-primary bg-gradient btn-sm btn-add<?= ($akses['add'] == 0) ? ' d-none' : '' ?>" data-toggle="modal" data-target="#modalform">
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
                            <th width="25%">Nama</th>
                            <th width="15%">Tempat/Tgl Lahir</th>
                            <th width="10%">Jenis PTK</th>
                            <th width="10%">Email</th>
                            <th width="15%">NUPTK</th>
                            <th width="12%" class="noshort"></th>
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
                            <div class="col-xs-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Identitas</h3>
                                        <button type="button" class="btn bg-gradient btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Satuan Pendidikan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select form-select-sm satuanpendidikan" id="satuanpendidikan" name="satuanpendidikan" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <?php foreach ($satuanpendidikan as $sp) : ?>
                                                        <option value="<?= $sp['npsn'] ?>" <?= (session()->npsn == $sp['npsn']) ? 'selected' : '' ?>><?= $sp['sp'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div class="invalid-feedback satuanpendidikan-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>
                                                    Nama <small class="text-red">(Tanpa gelar)</small>
                                                    <span class="text-red">*</span>
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="nama" name="nama">
                                                <div class="invalid-feedback nama-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Jenis Kelamin<span class="text-red">*</span></label>
                                            </div>
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
                                            <div class="col-lg-3">
                                                <label>Tempat lahir <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="tempatlahir" name="tempatlahir">
                                                <div class="invalid-feedback tempatlahir-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Tanggal lahir <span class="text-red">*</span></label>
                                            </div>
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
                                            <div class="col-lg-3">
                                                <label>Nama ibu kandung <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="ibukandung" name="ibukandung">
                                                <div class="invalid-feedback ibukandung-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Pribadi</h3>
                                        <button type="button" class="btn bg-gradient btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Alamat <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="alamat" name="alamat">
                                                <div class="invalid-feedback alamat-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>RT / RW</label>
                                            </div>
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
                                            <div class="col-lg-3">
                                                <label>Provinsi <span class="text-red">*</span></label>
                                            </div>
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
                                            <div class="col-lg-3">
                                                <label>Kabupaten <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select kabupaten" id="kabupaten" name="kabupaten" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                </select>
                                                <div class="invalid-feedback kabupaten-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Kecamatan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select kecamatan" id="kecamatan" name="kecamatan" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                </select>
                                                <div class="invalid-feedback kecamatan-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Desa/Kelurahan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select kelurahan" id="kelurahan" name="kelurahan" data-placeholder="Pilih">
                                                    <option disabled selected></option>
                                                </select>
                                                <div class="invalid-feedback kelurahan-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Dusun</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="dusun" name="dusun">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Kode Pos</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="kodepos" name="kodepos" maxlength="5">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Agama <span class="text-red">*</span></label>
                                            </div>
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
                                            <div class="col-lg-3">
                                                <label>Kewarganegaraan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="warganegara" name="warganegara" value="Indonesia" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>NIK <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="nik" name="nik" maxlength="16">
                                                <div class="invalid-feedback nik-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Status nikah <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select statusnikah" id="statusnikah" name="statusnikah" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <option value="Belum Menikah">Belum Menikah</option>
                                                    <option value="Menikah">Menikah</option>
                                                    <option value="Bercerai">Janda/Duda</option>
                                                </select>
                                                <div class="invalid-feedback statusnikah-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kepegawaian</h3>
                                        <button type="button" class="btn btn-tool bg-gradient" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Jenis PTK <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select jenisptk" id="jenisptk" name="jenisptk" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <option value="Guru BK">Guru BK</option>
                                                    <option value="Guru Kelas">Guru Kelas</option>
                                                    <option value="Guru Mapel">Guru Mapel</option>
                                                    <option value="Guru Pembimbing Khusus">Guru Pembimbing Khusus</option>
                                                    <option value="Guru Pendamping Khusus">Guru Pendamping Khusus</option>
                                                    <option value="Guru Pengganti">Guru Pengganti</option>
                                                    <option value="Guru TIK">Guru TIK</option>
                                                    <option value="Tutor">Tutor</option>
                                                </select>
                                                <div class="invalid-feedback jenisptk-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Status Kepegawaian <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select statuspegawai" id="statuspegawai" name="statuspegawai" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <option value="GTT/PTT">GTT/PTT</option>
                                                    <option value="GTY/PTY">GTY/PTY</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="Guru Honor Sekolah">Guru Honor Sekolah</option>
                                                    <option value="CPNS">CPNS</option>
                                                    <option value="PNS">PNS</option>
                                                </select>
                                                <div class="invalid-feedback statuspegawai-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>NIP</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="nip" name="nip" maxlength="18">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>NUPTK</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="nuptk" name="nuptk" maxlength="16">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>SK Pengangkatan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="skkerja" name="skkerja">
                                                <div class="invalid-feedback skkerja-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>TMT Pengangkatan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <div class="input-group tmtkerja" data-target-input="nearest">
                                                    <input type="text" id="tmtkerja" name="tmtkerja" class="form-control datetimepicker-input" />
                                                    <div class="input-group-append" data-target="#tmtkerja" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                    <div class="invalid-feedback tmtkerja-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Lembaga Pengangkatan <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select lembagapengangkatan" id="lembagapengangkatan" name="lembagapengangkatan" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <option value="Ketua Yayasan">Ketua Yayasan</option>
                                                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                                                    <option value="Gubernur">Gubernur</option>
                                                    <option value="Walikota">Walikota</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                                <div class="invalid-feedback lembagapengangkatan-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Sumber Gaji <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <select class="form-select sumbergaji" id="sumbergaji" name="sumbergaji" data-placeholder="Pilih">
                                                    <option selected disabled></option>
                                                    <option value="Ketua Yayasan">APBN</option>
                                                    <option value="Kepala Sekolah">APBD Provinsi</option>
                                                    <option value="APDB Kabupaten/Kota">APDB Kabupaten/Kota</option>
                                                    <option value="Yayasan">Yayasan</option>
                                                    <option value="Sekolah">Sekolah</option>
                                                    <option value="Lembaga Donor">Lembaga Donor</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                                <div class="invalid-feedback sumbergaji-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kontak</h3>
                                        <button type="button" class="btn btn-tool bg-gradient" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>No. Telp. Rumah</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="notelp" name="notelp">
                                                <small style="font-size: 12px">Cth: <strong class="text-red">kode_area-nomor_telepon</strong></small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>No. HP <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="handphone" name="handphone">
                                                <div class="invalid-feedback handphone-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                                <label>Email Aktif <span class="text-red">*</span></label>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="email" name="email">
                                                <div class="invalid-feedback email-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" class="btn btn-primary bg-gradient">Simpan</button>
                        <button type="button" class="btn btn-secondary bg-gradient closed" data-dismiss="modal">Keluar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalimport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalimportLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content card-outline card-info">
                <form action="/gtk/import" class="modalimport" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalimportLabel">Import <?= $titlecontent ?></h5>
                        <button type="button" class="close closed bg-gradient" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-0" style="max-height: 370px; overflow-y: auto">
                        <input type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback file-feedback"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="import" class="btn btn-primary bg-gradient">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
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
            "processing": true,
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

        $('#satuanpendidikan, #provinsi, #kabupaten, #kecamatan, #kelurahan, #agama, #statusnikah, #jenisptk, #statuspegawai, #lembagapengangkatan, #sumbergaji').select2({
            theme: 'bootstrap4',
            placeholder: $(this).data('placeholder')
        });

        $('#nama, #tempatlahir, #ibukandung').inputmask({
            placeholder: '',
            regex: "[a-zA-Z\\s]+$"
        });

        $('#alamat, #dusun').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\s\\./-]+$"
        });

        $('#tgllahir, #tmtkerja').inputmask({
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

        $('#rt, #rw, #kodepos, #nik, #nuptk, #nip').inputmask({
            placeholder: '',
            regex: '\\d+$'
        });

        $('#skkerja').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\s\-/_]+$"
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
            $('#modalform').find('form').attr('action', '/gtk/save');
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
                        })
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
                statusCode: {
                    404: function(error) {
                        toastr.error('Data tidak tersedia!!!');
                    }
                },
                success: function(response) {
                    $('#modalform').find('form').attr('action', response.action);

                    $.each(response, function(fi, va) {
                        $("#" + fi).val(va);
                        $("#" + fi).val(va).trigger('change');
                    });

                    $('#' + response.kelamin).trigger('click');

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