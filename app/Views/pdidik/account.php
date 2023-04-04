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
                <button type="button" class="btn btn-primary bg-gradient btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
                <button type="button" class="btn btn-success bg-gradient btn-sm btn-import <?= ($akses['import'] = count($datasiswa) == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Data</span>
                </button>
                <button type="button" class="btn bg-maroon bg-gradient btn-sm btn-export <?= ($akses['export'] = count($datasiswa) == 0) ? 'd-none' : '' ?>" onclick="window.location='/pdaccount/export'">
                    <i class="fas fa-upload"></i> <span class="d-none d-md-inline">Export Data</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12 bg-gradient">
            <div class="card-body">
                <table id="datatabel" class="table table-hover table-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Nama</th>
                            <th>No Peserta</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Sesi</th>
                            <th width="0" class="noshort"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalform" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalformLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content card-outline card-info bg-gradient">
                <form action="#" class="modalform" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalformLabel"></h5>
                    </div>
                    <div class="modal-body m-0" style="max-height: 370px; overflow-y: auto">
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">
                                Nama <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control" id="nama" name="nama" disabled>
                                <div class="invalid-feedback nama-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">
                                No Peserta <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control" id="nopes" name="nopes">
                                <div class="invalid-feedback nopes-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">
                                Username <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control" id="username" name="username">
                                <div class="invalid-feedback username-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">
                                Password <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-eye fa-fw showpassword"></i></span>
                                    </div>
                                    <div class="invalid-feedback password-feedback"></div>
                                </div>
                                <button type="button" class="btn btn-link" id="generate">Generate Password</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">
                                Sesi <span class="text-red">*</span>
                            </label>
                            <div class="col">
                                <select class="form-select" id="sesi" name="sesi">
                                    <option disabled selected></option>
                                    <?php foreach ($datasesi as $sesi) : ?>
                                        <option value="<?= $sesi['nama_sesi'] ?>"><?= $sesi['nama_sesi'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback sesi-feedback"></div>
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
                <form action="/pdaccount/import" class="modalimport" method="POST" enctype="multipart/form-data" autocomplete="off">
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
            "lengthMenu": [
                [10, 20, 25, 30, 35, 40, 45, 50, -1],
                [10, 20, 25, 30, 35, 40, 45, 50, "Semua"]
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["noshort"]
            }],
            "ajax": {
                "url": "/pdaccount/viewdata",
                "type": "POST",
                "data": function(data) {
                    return data.data;
                }
            },
        });

        $('.form-select').select2({
            theme: 'bootstrap4',
            placeholder: $(this).data('placeholder')
        });

        $('#username').inputmask({
            placeholder: '',
            regex: '[A-Z\\d]+$'
        });

        $('#password').inputmask({
            placeholder: '',
            regex: '[A-Z\\d]*[*]'
        });


        $('.showpassword').on('click', function() {
            if ($(this).hasClass('fa-eye')) {
                $('#password').attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#password').attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#generate').click(function() {
            $.ajax({
                url: '/pdaccount/generatepass',
                success: function(data) {
                    $('#password').val(data.pass);
                }
            })
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
                            $('#' + field + ', .' + field).addClass('is-invalid');
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
                        $('#password').attr('type', 'password');
                        $('.showpassword').removeClass('fa-eye-slash').addClass('fa-eye');
                    });
                }
            });
        });

        $('.closed').click(function() {
            $("#modalform").modal('hide').on('hidden.bs.modal', function() {
                $('#datatabel').DataTable().ajax.reload();
                $(this).find('form')[0].reset();
                $(this).find('.form-control, .form-select').removeClass('is-invalid');
                $(".form-select").trigger("change");
                $('#password').attr('type', 'password');
                $('.showpassword').removeClass('fa-eye-slash').addClass('fa-eye');
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