<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables/extensions/Select/css/select.dataTables.min.css">
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
                <button type="button" class="btn btn-success bg-gradient btn-sm btn-import <?= ($akses['import'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Soal</span>
                </button>
                <button type="button" class="btn btn-primary bg-gradient btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
                <button type="button" class="btn btn-secondary bg-gradient btn-sm btn-add-soal <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah Soal</span>
                </button>
                <button type="button" class="btn btn-danger bg-gradient btn-sm btn-delete-banksoal <?= ($akses['del'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus Bank Soal</span>
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
                            <th width="1%" class="noshort">
                                <div class="form-check form-check-inline">
                                    <input type='checkbox' class='form-check-input' id='ceksemua'>
                                </div>
                            </th>
                            <th>Mata Pelajaran</th>
                            <th>Soal PG</th>
                            <th>Soal Essay</th>
                            <th>Rombel/Tingkatan</th>
                            <th>Guru</th>
                            <th>Status/Total Soal</th>
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
                                    <label>Program Layanan</label>
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
                                    <label>Rombel</label>
                                    <select name="romble" id="romble" class="form-select" data-placeholder="Pilih">
                                        <option selected disabled></option>
                                    </select>
                                    <div class="invalid-feedback romble-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <select name="mapel" id="mapel" class="form-select" data-placeholder="Pilih">
                                        <option disabled selected></option>
                                        <?php foreach ($datamapel as $mapel) : ?>
                                            <option value="<?= $mapel['nama_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback mapel-feedback"></div>

                                </div>
                                <div class="divjenisagama form-group"></div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Jumlah Soal PG</label>
                                            <input type="number" id="soalpg" name="soalpg" class="form-control" />
                                            <div class="invalid-feedback soalpg-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Bobot Soal PG %</label>
                                            <input type="number" id="bobotpg" name="bobotpg" class="form-control" />
                                            <div class="invalid-feedback bobotpg-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Opsi</label>
                                            <select id="opsi" name="opsi" class="form-select" data-placeholder="Opsi Jawaban">
                                                <option disabled selected></option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <div class="invalid-feedback opsi-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jumlah Soal Essay</label>
                                            <input type="number" id="soalesai" name="soalesai" class="form-control" />
                                            <div class="invalid-feedback soalesai-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bobot Soal Essay %</label>
                                            <input type="number" id="bobotesai" name="bobotesai" class="form-control" />
                                            <div class="invalid-feedback bobotesai-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Paket Soal</label>
                                    <select id="paketsoal" name="paketsoal" class="form-select" data-placeholder="Paket Soal">
                                        <option disabled selected></option>
                                        <option value="Utama">Utama</option>
                                        <option value="Susulan">Susulan</option>
                                        <option>Tidak Ada</option>
                                    </select>
                                    <div class="invalid-feedback paketsoal-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Soal</label>
                                            <select id="status" name="status" class="form-select" data-placeholder="Pilih">
                                                <option disabled selected></option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                            <div class="invalid-feedback status-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" name="simpan" class="btn bg-gradient btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary bg-gradient closed">Keluar</button>
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
<script src="/assets/plugins/datatables/extensions/Select/js/dataTables.select.min.js"></script>
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
                "aTargets": ["noshort"],
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

        $('#datatabel tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $('#datatabel').DataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        }).css('cursor', 'default');

        $('.btn-add-soal').click(function() {
            if (!$('#datatabel tbody tr.selected').attr('id')) {
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
                window.open('<?= $_SERVER['REQUEST_URI'] ?>/question/' + $('#datatabel').DataTable().$('tr.selected').attr('id'), '_blank');
            }
        });

        $('.btn-import').click(function() {
            if (!$('#datatabel tbody tr.selected').attr('id')) {
                const swalWithBootstrapButtons = Swal.mixin({

                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'Peringatan!',
                    text: 'Pilih salah satu mata pelajaran untuk import soal!',
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
                window.open('<?= $_SERVER['REQUEST_URI'] ?>/importsoal/' + $('#datatabel').DataTable().$('tr.selected').attr('id'), '_blank');
            }
        })

        $('#modalform select').select2({
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
            $('#romble').html('<option disabled selected></option>');

            $.ajax({
                url: '/api/rombel/' + $(this).val() + '/' + $("#jenjang option:selected").val(),
                success: function(data) {
                    $.each(data, function(field, val) {
                        $('#romble').append('<option value="' + val.romble + '">' + val.romble + '</option>');
                    });
                }
            });
        });

        $('#mapel').change(function() {
            $('.divjenisagama').html('<label>Kategori Agama</label><select class="form-select" id="jenisagama" name="jenisagama"><option disabled selected></option></select>');

            if ($('#mapel option:selected').val() == 'Pendidikan Agama') {
                $.ajax({
                    url: '/api/religion',
                    success: function(data) {
                        data.forEach(function(v) {
                            $('#jenisagama').select2({
                                theme: 'bootstrap4'
                            }).append('<option value="' + v.agama + '">' + v.agama + '</option>');
                        })
                    }
                })
            } else {
                $('.divjenisagama').html('');
            }
        });

        $(document).on('click', '.btn-add', function() {
            $('#modalform').modal('show').find('#modalformLabel').html('Tambah <?= $titlecontent ?>');
            $('#modalform').find('form').attr('action', '/banksoal/save');
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
                success: function(response) {
                    $('#modalform').find('form').attr('action', url + '/save');

                    $.each(response, function(fi, va) {
                        $("#" + fi).val(va);
                        $("#" + fi).val(va).trigger('change');
                    });

                    $('#tingkatan').html('<option disabled selected></option>');

                    if (response.mapel == 'Pendidikan Agama') {
                        $('.divjenisagama').html('<label>Kategori Agama</label><select class="form-select" id="jenisagama" name="jenisagama"><option disabled selected></option></select>');

                        $.ajax({
                            url: '/api/religion',
                            success: function(data) {
                                $('#jenisagama').select2({
                                    theme: 'bootstrap4'
                                });

                                data.forEach(function(v) {
                                    if (response.categories == v.agama) {
                                        $('#jenisagama').append('<option value="' + v.agama + '" selected>' + v.agama + '</option>');
                                    } else {
                                        $('#jenisagama').append('<option value="' + v.agama + '">' + v.agama + '</option>');
                                    }
                                })
                            }
                        })
                    } else {
                        $('.divjenisagama').html('');
                    }

                    $.ajax({
                        url: '/api/tingkatan/' + response.jenjang,
                        success: function(data) {
                            $('#tingkatan').html('<option disabled selected></option>');

                            $.each(data, function(field, val) {
                                if (response.tingkatan == val.tingkatan) {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '" selected>' + val.tingkatan + '</option>');
                                } else {
                                    $('#tingkatan').append('<option value="' + val.tingkatan + '">' + val.tingkatan + '</option>');
                                }
                            });
                        }
                    });


                    $.ajax({
                        url: '/api/rombel/' + response.tingkatan + '/' + response.jenjang,
                        success: function(data) {

                            $.each(data, function(field, val) {
                                if (response.romble == val.romble) {
                                    $('#romble').append('<option value="' + val.romble + '" selected>' + val.romble + '</option>');
                                } else {
                                    $('#romble').append('<option value="' + val.romble + '">' + val.romble + '</option>');
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
                    $(".modal").modal('hide').on('hidden.bs.modal', function() {
                        $('#datatabel').DataTable().ajax.reload();
                        $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $(".form-select").trigger("change");
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            Swal.fire({
                title: 'Anda ingin hapus data ini?',
                text: "Data akan dihapus secara permanen!",
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
                        url: $(this).data('href'),
                        statusCode: {
                            400: function(error) {
                                toastr.error(error.responseJSON.error);
                            }
                        },
                        success: function(response) {
                            toastr.success(response.success);

                            $('#datatabel').DataTable().ajax.reload();
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

            console.log(id_array)
            if (id_array.length == 0) {
                const swalWithBootstrapButtons = Swal.mixin({

                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'Peringatan!',
                    text: 'Pilih data yang ingin dihapus!',
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
                    text: "Data akan dihapus secara permanen!",
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

        $('.closed').click(function() {
            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                $('#datatabel').DataTable().ajax.reload();
                $(this).find('.form-control, .form-select, .form-check-input').removeClass('is-invalid');
                $(this).find('form')[0].reset();
                $(".form-select").trigger("change");
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
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>