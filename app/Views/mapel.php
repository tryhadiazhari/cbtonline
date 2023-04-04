<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
                <button type="button" class="btn btn-primary bg-gradient btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
                <button type="button" class="btn btn-success bg-gradient btn-sm btn-import <?= ($akses['import'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Data</span>
                </button>
                <button type="button" class="btn bg-maroon bg-gradient btn-sm btn-export <?= ($akses['export'] == 0) ? 'd-none' : '' ?>" onclick="window.location='<?= $_SERVER['REQUEST_URI'] ?>/export'">
                    <i class="fas fa-upload"></i> <span class="d-none d-md-inline">Export Data</span>
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
                            <th>Mata Pelajaran</th>
                            <th>Jenjang / Tingkatan</th>
                            <th>Kurikulum</th>
                            <th>GTK</th>
                            <th>JJM</th>
                            <th>SK Mengajar</th>
                            <th>Tgl SK</th>
                            <th>Status Mapel</th>
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
                        <div class="card m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Jenjang Pendidikan</label>
                                    <select name="jenjang" id="jenjang" class="form-select" data-placeholder="Pilih">
                                        <option disabled selected></option>
                                        <?php foreach ($datalayanan as $layanan) : ?>
                                            <option value="<?= $layanan['jenjang'] ?>"><?= $layanan['jenjang'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback jenjang-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tingkatan</label>
                                    <select name="tingkatan" id="tingkatan" class="form-select" data-placeholder="Pilih">
                                        <option selected disabled></option>
                                    </select>
                                    <div class="invalid-feedback tingkatan-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <input type="text" name="mapel" id="mapel" class="form-control form-input-sm text-sm">
                                    <div class="invalid-feedback mapel-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Alias</label>
                                    <input type="text" name="alias" id="alias" class="form-control form-input-sm text-sm">
                                    <div class="invalid-feedback alias-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Kurikulum</label>
                                    <input type="text" name="kurikulum" id="kurikulum" class="form-control form-input-sm text-sm" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jam Mengajar</label>
                                            <input type="text" name="jjm" id="jjm" class="form-control form-input-sm text-sm" maxlength="2">
                                            <div class="invalid-feedback jjm-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>SK Mengajar</label>
                                            <input type="text" name="skajar" id="skajar" class="form-control form-input-sm text-sm">
                                            <div class="invalid-feedback skajar-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Tanggal SK</label>
                                            <div class="input-group tglsk" data-target-input="#tglsk">
                                                <input type="text" id="tglsk" name="tglsk" class="form-control datetimepicker-input" />
                                                <div class="input-group-append" data-target="#tglsk" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <div class="invalid-feedback tglsk-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Mapel</label>
                                    <select id="status" name="status" class="form-select" data-placeholder="Pilih">
                                        <option disabled selected></option>
                                        <option value="Mapel Wajib">Mapel Wajib</option>
                                        <option value="Mapel Umum A">Mapel Umum A</option>
                                        <option value="Mapel Umum B">Mapel Umum B</option>
                                        <option value="Mapel Tambahan">Mapel Tambahan</option>
                                    </select>
                                    <div class="invalid-feedback status-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Guru Pengampu</label>
                                    <select id="guru" name="guru" class="form-select" data-placeholder="Pilih">
                                        <option disabled selected></option>
                                        <?php foreach ($datagtk as $gtk) : ?>
                                            <option value="<?= $gtk['nama'] ?>"><?= $gtk['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback guru-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" name="simpan" class="btn btn-primary bg-gradient">Simpan</button>
                        <button type="button" class="btn btn-secondary bg-gradient closed" data-dismiss="modal">Keluar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalimport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalimportLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content card-outline card-info bg-gradient">
                <form action="<?= $_SERVER['REQUEST_URI'] ?>/import" class="modalimport" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalimportLabel">Import <?= $titlecontent ?></h5>
                        <button type="button" class="close closed bg-gradient" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-0" style="max-height: 370px; overflow-y: auto">
                        <div class="info-import"></div>
                        <input type="file" name="file" id="file" class="form-control" accept=".xlsx">
                        <div class="invalid-feedback file-feedback"></div>
                        <p class="mt-2 mb-0 py-0">
                            Silahkan download format excel untuk import data pembelajaran <a class="p-0 btn-link" onclick="window.location='<?= $_SERVER['REQUEST_URI'] ?>/download'" style="cursor: pointer">Disini</a>
                        </p>
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
                [1, "desc"]
            ],
            "lengthMenu": [
                [10, 20, 25, 30, 35, 40, 45, 50, -1],
                [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"],
            }],
            "ajax": {
                "url": "<?= $_SERVER['REQUEST_URI']; ?>/viewdata",
                "type": "POST",
                "data": function(data) {
                    return data.data;
                }
            },
        });

        $('#jjm').inputmask({
            placeholder: '',
            regex: "\\d+$"
        });

        $('#skajar').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\-\/\.]+$"
        });

        $('#tglsk').inputmask({
            placeholder: '',
            alias: 'datetime',
            inputFormat: 'yyyy-mm-dd',
        }).datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('.form-select').select2({
            theme: 'bootstrap4',
            placeholder: $(this).data('placeholder')
        });

        $("#jenjang").change(function() {
            $('#tingkatan').html('<option disabled selected></option>');

            $.ajax({
                url: '/api/tingkatan/' + $(this).val(),
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#tingkatan').append('<option value="' + val.tingkatan + '">' + val.tingkatan + '</option>');
                    });
                }
            });
        });

        $("#tingkatan").change(function() {
            $('#kurikulum').val('');
            $.ajax({
                url: '<?= $_SERVER['REQUEST_URI'] ?>/rombel/' + $("#jenjang option:selected").val() + '/' + $(this).val(),
                type: "post",
                success: function(kurikulum) {
                    $('#kurikulum').val(kurikulum.kurikulum);
                }
            });
        });

        $('.btn-add').click(function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Tambah <?= $titlecontent ?>');
            $('#modalform').find('form').attr('action', '<?= $_SERVER['REQUEST_URI'] ?>/save');
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

                    $.ajax({
                        url: '/api/tingkatan/' + response.jenjang,
                        success: function(data) {
                            $('#tingkatan').html('<option disabled selected></option>');
                            $.each(data, function(field, val) {
                                if (response.tingkatan == val.tingkatan) {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '" selected>' + val.tingkatan + '</option>').trigger('change');
                                } else {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '">' + val.tingkatan + '</option>');
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
                    $('.form-control, .form-select').removeClass('is-invalid');
                },
                complete: function() {
                    $('#simpan').html('Simpan');
                },
                statusCode: {
                    404: function(errors) {
                        $.each(errors.responseJSON, function(field, val) {
                            $('#' + field).addClass('is-invalid');
                            $('.' + field + '-feedback').text(val);
                        });
                    },
                    400: function(errors) {
                        toastr.error(errors.responseJSON.error);
                    },
                },
                success: function(response) {
                    toastr.success(response.success);
                    $("#modalform").modal('hide').on('hidden.bs.modal', function() {
                        $('#datatabel').DataTable().ajax.reload();
                        $(this).find('.form-control, .form-select').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $(".form-select").trigger("change");
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
                            $('.closed').trigger('click');
                        }
                    });
                }
            });
        });

        $('.closed').click(function() {
            $("#modalform").modal('hide').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#datatabel').DataTable().ajax.reload();
                $(this).find('.form-control, .form-select').removeClass('is-invalid');
                $(".form-select").trigger("change");
            });
            $("#modalimport").modal('hide').on('hidden.bs.modal', function() {
                $('.info-import').html('')
                $(this).find('.form-control').removeClass('is-invalid');
                $(this).find('form')[0].reset();
                $('#datatabel').DataTable().ajax.reload();
            });
        });

        $('.btn-import').click(function() {
            $('#modalimport').modal('show')
        });

        $('.modalimport').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                cache: false,
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function() {
                    $('#import').html('<i class="fas fa-spin fa-spinner-third"></i>');
                    $('.modalimport').find('.form-control').removeClass('is-invalid');
                },
                complete: function() {
                    $('#import').html('Import');
                },
                statusCode: {
                    404: function(errors) {
                        $('.modalimport').find('.form-control').addClass('is-invalid');
                        $('.modalimport').find('.file-feedback').html(errors.responseText);
                    },
                    400: function(errors) {
                        toastr.error(errors.responseJSON.error);
                        $('.info-import').html(errors.responseJSON.data);
                    },
                    500: function(errors) {
                        $('.info-import').html(errors.responseJSON.error);
                    }
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('.info-import').html(response.data);
                    setTimeout(() => {
                        $("#modalimport").modal('hide').on('hidden.bs.modal', function() {
                            $('.info-import').html('')
                            $(this).find('.form-control').removeClass('is-invalid');
                            $(this).find('form')[0].reset();
                            $('#datatabel').DataTable().ajax.reload();
                        });
                    }, 5000);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>