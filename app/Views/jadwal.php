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
                <button type="submit" class="btn btn-success btn-sm <?= ($akses['import'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Soal</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-delete-banksoal <?= ($akses['del'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus Jadwal</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12">
            <div class="card-body">
                <table id="datatabel" class="table table-hover table-responsive nowrap " width="100%">
                    <thead>
                        <tr>
                            <th width="1%" class="noshort">
                                <div class="form-check form-check-inline">
                                    <input type='checkbox' class='form-check-input' id='ceksemua'>
                                </div>
                            </th>
                            <th>Mata Pelajaran</th>
                            <th>Rombel/Tingkatan/Jur</th>
                            <th>Durasi</th>
                            <th>Tgl/Jam Ujian</th>
                            <th>Sesi</th>
                            <th>Acak/Token</th>
                            <th>Status</th>
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
                                    <select name="jenjang" id="jenjang" class="form-select" data-placeholder="Pilih Jenjang">
                                        <option disabled selected></option>
                                        <?php foreach ($datalayanan as $layanan) : ?>
                                            <option value="<?= $layanan['jenjang'] ?>"><?= $layanan['jenjang'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback jenjang-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tingkatan</label>
                                    <select name="tingkatan" id="tingkatan" class="form-select" data-placeholder="Pilih Tingkatan">
                                        <option disabled selected></option>
                                    </select>
                                    <div class="invalid-feedback tingkatan-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Rombel</label><br>
                                    <select name="romble" id="romble" class="form-select" data-placeholder="Pilih Rombel">
                                        <option disabled selected></option>
                                    </select>
                                    <div class="invalid-feedback romble-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <select name="mapel" id="mapel" class="form-select" data-placeholder="Pilih Mapel">
                                        <option disabled selected></option>
                                    </select>
                                    <div class="invalid-feedback mapel-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Ujian</label>
                                    <select id="jenisujian" name="jenisujian" class="form-select" data-placeholder="Pilih Jenis Ujian">
                                        <option disabled selected></option>
                                        <?php foreach ($datajenisujian as $jenisujian) : ?>
                                            <option value="<?= $jenisujian['alias'] ?>"><?= $jenisujian['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback jenisujian-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Sesi</label>
                                    <select id='sesi' name='sesi' class='form-select' data-placeholder='Pilih Sesi Ujian'>
                                        <option disabled selected></option>
                                        <?php foreach ($datasesi as $sesi) : ?>
                                            <option value="<?= $sesi['nama_sesi'] ?>"><?= $sesi['nama_sesi'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback sesi-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tanggal Ujian</label>
                                            <div class="input-group tglujian" data-target-input="nearest">
                                                <input type="text" id="tglujian" name="tglujian" class="form-control datetimepicker-input" />
                                                <div class="input-group-append" data-target="#tglujian" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <div class="invalid-feedback tglujian-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jam Mulai</label>
                                            <div class="input-group timer" data-target-input="nearest">
                                                <input type="text" id="timer" name="timer" class="form-control datetimepicker-input" />
                                                <div class="input-group-append" data-target="#timer" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                </div>
                                                <div class="invalid-feedback timer-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Masa Akhir Jadwal</label>
                                            <div class="input-group tglexpired" data-target-input="nearest">
                                                <input type="text" id="tglexpired" name="tglexpired" class="form-control datetimepicker-input" />
                                                <div class="input-group-append" data-target="#tglexpired" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <div class="invalid-feedback tglexpired-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label>Lama Ujian</label>
                                            <input type="text" id="durasi" name="durasi" class="form-control" maxlength="3">
                                            <div class="invalid-feedback durasi-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <label>Nilai KKM</label>
                                            <input type="text" id="kkm" name="kkm" class="form-control" maxlength="3">
                                            <div class="invalid-feedback kkm-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="acak" class="form-check-input" name="acak" value="1">
                                            <label class="form-check-label fw-bold" for="acak">Acak Soal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="token" class="form-check-input" name="token" value="1">
                                            <label class="form-check-label fw-bold" for="token">Token Soal</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary closed">Keluar</button>
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
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(function() {
        $('#tglujian').inputmask({
            alias: 'datetime',
            inputFormat: 'yyyy-mm-dd',
        }).datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('#timer').inputmask({
            alias: 'datetime',
            inputFormat: 'HH:MM:ss',
        }).datetimepicker({
            format: 'HH:mm:00'
        });

        $('#tglexpired').inputmask({
            alias: 'datetime',
            inputFormat: 'yyyy-mm-dd HH:MM:ss',
        }).datetimepicker({
            format: 'YYYY-MM-DD HH:mm:00',
            sideBySide: true,
        });
    });

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
                "url": "<?= $_SERVER['REQUEST_URI']; ?>/viewdata",
                "type": "POST",
                "data": function(data) {
                    return data.data;
                }
            },
            createdRow: function(row, data, dataIndex, cells) {
                $(row).attr('id', data.id);
            },
        });

        $('.form-select').select2({
            placeholder: $(this).data('placeholder'),
            theme: 'bootstrap4',
        });

        $('#durasi, #kkm').inputmask({
            placeholder: '',
            regex: '\\d+$'
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
            $('#romble').html('<option disabled selected></option>');

            $.ajax({
                url: '/api/rombel/' + $(this).val() + '/' + $("#jenjang option:selected").val(),
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#romble').append('<option value="' + val.romble + '">' + val.romble + '</option>');
                    });
                }
            });

            $.ajax({
                url: '/api/banksoal/' + $("#jenjang option:selected").val() + '/' + $(this).val(),
                success: function(data) {
                    data.forEach(function(val) {
                        $('#mapel').append('<option value="' + val.kode + '">' + val.mapel + '</option>');
                    })
                }
            });
        });

        $('.btn-add').click(function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Tambah <?= $titlecontent ?>');
            $('#modalform').find('form').attr('action', '/jadwal/save');
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#simpan").html('<i class="fa fa-spinner-third fa-spin"></i>');
                    $(".form-control, .form-select").removeClass('is-invalid');
                },
                complete: function() {
                    $("#simpan").html('Simpan');
                },
                statusCode: {
                    404: function(errors) {
                        $.each(errors.responseJSON, function(field, val) {
                            $('#' + field).addClass('is-invalid');
                            $('.' + field + '-feedback').text(val);
                        })
                    },
                    400: function(errors) {
                        toastr.error(errors.responseJSON.error);
                    },
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('#datatabel').DataTable().ajax.reload();
                    $(".modal").modal('hide').on('hidden.bs.modal', function() {
                        $(this).find('.form-control, .form-select').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $(".form-select").trigger("change");
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Edit <?= $titlecontent ?>');
            var url = $(this).data('href');

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
                    $('#modalform').find('form').attr('action', url + '/save');

                    $.each(response, function(fi, va) {
                        $("input[type='text']#" + fi).val(va);
                        $("select#" + fi).val(va).trigger('change');
                    });

                    $('#acak').prop('checked', (response.acak == 1) ? true : false);
                    $('#token').prop('checked', (response.token == 1) ? true : false);

                    $('#acak').change(function() {
                        if ($(this).is(':checked') == true) {
                            $(this).val(1)
                        } else {
                            $(this).val(0)
                        }
                    });
                    $('#token').change(function() {
                        if ($(this).is(':checked') == true) {
                            $(this).val(1)
                        } else {
                            $(this).val(0)
                        }
                    });

                    $("#jenjang").val(response.jenjang).trigger('change');

                    $.ajax({
                        url: '/api/tingkatan/' + response.jenjang,
                        success: function(data) {
                            $('#tingkatan').html('<option disabled selected></option>');

                            $.each(data, function(field, val) {
                                if (val.tingkatan == response.tingkatan) {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '" selected>' + val.tingkatan + '</option>').trigger('change');
                                } else {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '">' + val.tingkatan + '</option>');
                                }
                            });
                        }
                    });

                    $("#tingkatan").change(function() {
                        $.ajax({
                            url: '/api/rombel/' + $(this).val() + '/' + $("#jenjang option:selected").val(),
                            success: function(data) {
                                $('#romble').html('<option disabled selected></option>');

                                $.each(data, function(field, val) {
                                    if (val.romble == response.romble) {
                                        $('#romble').append('<option value="' + val.romble + '" selected>' + val.romble + '</option>').trigger('change');
                                    } else {
                                        $('#romble').append('<option value="' + val.romble + '">' + val.romble + '</option>');
                                    }
                                });
                            }
                        });

                        $.ajax({
                            url: '/api/banksoal/' + $("#jenjang option:selected").val() + '/' + $(this).val(),
                            success: function(data) {
                                $('#mapel').html('<option disabled selected></option>');

                                data.forEach(function(val) {
                                    if (val.kode == response.kode) {
                                        $('#mapel').append('<option value="' + val.kode + '" selected>' + val.mapel + '</option>');
                                    } else {
                                        $('#mapel').append('<option value="' + val.kode + '">' + val.mapel + '</option>');
                                    }
                                })
                            }
                        });
                    });
                }
            });
        });

        $('.closed').click(function() {
            $('#datatabel').DataTable().ajax.reload();
            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                $(this).find('.form-control, .form-select').removeClass('is-invalid');
                $(this).find('form')[0].reset();
                $(".form-select").trigger("change");
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
                                $(this).find('.form-control, .form-select').removeClass('is-invalid');
                                $(this).find('form')[0].reset();
                                $(".form-select").trigger("change");
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete-banksoal', function() {
            i = 0;
            id_array = new Array();
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });

            if (id_array.length == 0) {
                const swalWithBootstrapButtons = Swal.mixin({

                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'Peringatan!',
                    text: 'Pilih salah satu mata pelajaran untuk tambah soal!',
                    icon: 'warning',
                    showConfirmButton: false,
                    reverseButtons: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            } else {
                Swal.fire({
                    title: 'Anda ingin hapus data ini?',
                    text: 'Pilih data yang ingin dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak!',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= $_SERVER['REQUEST_URI']; ?>/deleteall",
                            data: {
                                id: id_array
                            },
                            type: "POST",
                            statusCode: {
                                400: function(error) {
                                    toastr.error(error.responseJSON.error);
                                }
                            },
                            success: function(response) {
                                toastr.success(response.success);

                                $('#datatabel').DataTable().ajax.reload();
                                $('#ceksemua').prop('checked', false);
                            }
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>