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
                <button type="submit" class="btn btn-success btn-sm <?= ($akses['import'] == 0) ? 'd-none' : '' ?>" data-toggle="modal" data-target="#modalimport">
                    <i class="fas fa-download"></i>
                    <span class="d-none d-md-inline">Import Data</span>
                </button>
                <button type="button" id="myBtn" class="btn btn-primary btn-sm btn-add <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Tambah</span>
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-rombel <?= ($akses['add'] == 0) ? 'd-none' : '' ?>">
                    <i class="fas fa-users"></i> <span class="d-none d-md-inline">Anggota Rombel</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <form action="/rombel/save" class="formrombel" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <table id="datatabel" class="table table-hover table-responsive nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th style="width: 200px">Jenis Rombel</th>
                                <th style="width: 200px">Program/Kompetensi</th>
                                <th style="width: 200px">Tingkatan Pendidikan</th>
                                <th style="width: 200px">Kurikulum</th>
                                <th style="width: 200px">Nama Rombel</th>
                                <th style="width: 200px">Wali Kelas</th>
                                <th style="width: 200px">Ruang</th>
                                <th width="0" class="noshort"></th>
                            </tr>
                        </thead>
                    </table>
                </form>
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
                    <div class="modal-body m-0" style="max-height: 415px; overflow-y: auto">
                        <div class="row">

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

    <div class="modal fade" id="modalrombel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalrombelLabel" aria-hidden="false">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content card-outline card-info">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalrombelLabel"></h5>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-lg-6 py-3" style="border-left: 2px silver outset; border-right: 1px silver outset">
                            <div class="row mb-1">
                                <label class="col-auto col-form-label">Pendaftaran</label>
                                <div class="col px-0">
                                    <select name="tipedaftar" id="tipedaftar" class="form-select form-select-sm">
                                        <option value="Lanjut Semester" selected>Lanjut Semester</option>
                                        <option value="Naik Kelas">Naik Kelas</option>
                                    </select>
                                </div>
                                <div class="col-auto me-auto">
                                    <button class="btn btn-danger btn-sm btn-out-rombel">
                                        <i class="fas fa-trash"></i>
                                        <span class="d-none d-block-sm">Keluarkan dari Rombel</span>
                                    </button>
                                </div>
                            </div>
                            <table id="tabelrombel" class="table table-striped table-responsive-lg nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Peserta Didik</th>
                                        <th>Jenis Pendaftaran</th>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-lg-6 py-3" style="border-left: 1px silver outset; border-right: 2px silver outset">
                            <table id="tabelrombel2" class="table table-striped nowrap table-responsive-lg" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tgl Lahir</th>
                                        <th>Agama</th>
                                        <th>Kelas Terakhir</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()" data-dismiss="modal">Keluar</button>
                </div>
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
        var selected = [];

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
            "columns": [{
                    "data": 0
                },
                {
                    "data": "jenis_rombel"
                },
                {
                    "data": "jenjang"
                },
                {
                    "data": "tingkatan"
                },
                {
                    "data": "kurikulum"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "wali_kelas"
                },
                {
                    "data": "ruang"
                },
                {
                    "data": "action"
                },
            ],
            "rowCallback": function(row, data) {
                if ($.inArray(data.DT_RowId, selected) !== -1) {
                    $(row).addClass('selected');
                }
            },
        });

        $('#datatabel tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $('#datatabel').DataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $(document).on("click", '#myBtn', function(e) {
            e.preventDefault();
            $('.btn-edit').addClass('disabled');
            $('.btn-delete').addClass('disabled');

            var html = '<tr class="rows">';

            html += '<td>&nbsp;<input type="hidden" id="npsn" name="npsn" value="<?= session()->npsn ?>" readonly></td>';
            html +=
                '<td><input type="text" id="jenisrombel" class="form-control form-control-sm" name="jenisrombel" value="Kelas" style="height: 34px" readonly></td>';
            html +=
                '<td>' +
                '<select id="jenjang" class="form-select form-select-sm" name="jenjang"><option disabled selected></option></select>' +
                '<div class="invalid-feedback jenjang-feedback"></div>' +
                '</td>';
            html +=
                '<td>' +
                '<select id="tingkatan" class="form-select form-select-sm" name="tingkatan" style="width: 200px"><option disabled selected></option></select>' +
                '<div class="invalid-feedback tingkatan-feedback"></div>' +
                '</td>';
            html +=
                '<td>' +
                '<select id="kurikulum" class="form-select form-select-sm" name="kurikulum" style="width: 200px"><option disabled selected></option></select>' +
                '<div class="invalid-feedback kurikulum-feedback"></div>' +
                '</td>';
            html +=
                '<td>' +
                '<input type="text" id="namarombel" class="form-control form-control-sm" name="namarombel" style="width: 200px; height: 34px">' +
                '<div class="invalid-feedback namarombel-feedback"></div>' +
                '</td>';
            html +=
                '<td>' +
                '<select id="walikelas" class="form-select form-select-sm" name="walikelas" style="width: 200px"><option disabled selected></option></select>' +
                '<div class="invalid-feedback walikelas-feedback"></div>' +
                '</td>';
            html +=
                '<td>' +
                '<input type="text" id="ruang" class="form-control form-control-sm" name="ruang" style="width: 200px; height: 34px">' +
                '<div class="invalid-feedback ruang-feedback"></div>' +
                '</td>';
            html +=
                '<td class="px-0 text-center"><button type="submit" name="save" id="save" class="btn btn-primary btn-sm mr-2 px-2"><i class="fas fa-save"></i></button><button type="button" name="cancel" id="cancel" class="btn btn-secondary btn-sm px-2"><i class="fas fa-times"></i></button></td>';
            html += "</tr>";

            $("#datatabel > tbody").prepend(html);

            $('.formrombel').attr('action', '/rombel/save');

            $('#jenjang, #tingkatan, #kurikulum, #walikelas').select2({
                theme: 'bootstrap4'
            });

            $('#namarombel, #ruang').inputmask({
                placeholder: '',
                regex: "[a-zA-Z\\s\\d]+$"
            });

            $.ajax({
                url: '/api/jenjang/<?= session()->npsn ?>',
                type: "post",
                success: function(reques) {
                    $("#jenjang").html("<option disabled selected></option>");

                    reques.forEach(function(e) {
                        $("#jenjang").append('<option value="' + e.jenjang + '">' + e.jenjang + '</option>');
                    });
                },
            });

            $("#jenjang").change(function() {
                $("#tingkatan").html("<option disabled selected></option>");
                $("#kurikulum").html("<option disabled selected></option>");

                $.ajax({
                    url: '/api/tingkatan/' + $(this).val(),
                    type: "post",
                    success: function(tingkatan) {
                        tingkatan.forEach(function(ee) {
                            $("#tingkatan").append('<option value="' + ee.tingkatan + '">' + ee.tingkatan + "</option>");
                        });
                    }
                });
            });

            $("#tingkatan").change(function() {
                $("#kurikulum").html("<option disabled selected></option>");

                $.ajax({
                    url: '/api/kurikulum/' + $("#jenjang option:selected").val() + '/' + $(this).val(),
                    type: "post",
                    success: function(tingkatan) {
                        $("#kurikulum").append('<option value="' + tingkatan.kurikulum + '">' + tingkatan.kurikulum + "</option>");
                    }
                });
            });

            $.ajax({
                url: '/api/gtk/<?= session()->npsn ?>',
                type: "post",
                success: function(gtk) {
                    gtk.forEach(function(e) {
                        $("#walikelas").append('<option value="' + e.nama + '">' + e.nama + "</option>");
                    });
                }
            });
        });

        $('.formrombel').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function(action) {
                    $('.form-select, .form-control').removeClass('is-invalid');
                },
                statusCode: {
                    404: function(error) {
                        $.each(error.responseJSON, function(field, va) {
                            $('#' + field).addClass('is-invalid');
                            $('.' + field + '-feedback').text(va);
                        });
                    },
                    400: function(error) {
                        toastr.error(error.responseJSON.error);
                    },
                },
                success: function(response) {
                    $('#datatabel').DataTable().ajax.reload();
                    toastr.success(response.success);
                    $(".btn-add").removeClass("disabled");
                }
            });
        });

        $(document).on('click', '.btn-edit', function(e) {
            $('.btn-add').addClass('disabled');

            $('.formrombel').attr('action', $(this).data('href') + '/save');

            $.ajax({
                url: $(this).data("href"),
                type: "post",
                success: function(data) {
                    $('.btn-edit').addClass('disabled');

                    var html = '<td>&nbsp;<input type="hidden" id="npsn" name="npsn" value="<?= session()->npsn ?>" readonly></td>';
                    html +=
                        '<td><input type="text" id="jenisrombel" class="form-control form-control-sm" name="jenisrombel" value="Kelas" style="height: 34px" readonly></td>';
                    html +=
                        '<td>' +
                        '<select id="jenjang" class="form-select form-select-sm" name="jenjang"><option disabled selected></option></select>' +
                        '<div class="invalid-feedback jenjang-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td>' +
                        '<select id="tingkatan" class="form-select form-select-sm" name="tingkatan" style="width: 200px"><option disabled selected></option></select>' +
                        '<div class="invalid-feedback tingkatan-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td>' +
                        '<select id="kurikulum" class="form-select form-select-sm" name="kurikulum" style="width: 200px"><option disabled selected></option></select>' +
                        '<div class="invalid-feedback kurikulum-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td>' +
                        '<input type="text" id="namarombel" class="form-control form-control-sm" name="namarombel" style="width: 200px; height: 34px">' +
                        '<div class="invalid-feedback namarombel-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td>' +
                        '<select id="walikelas" class="form-select form-select-sm" name="walikelas" style="width: 200px"><option disabled selected></option></select>' +
                        '<div class="invalid-feedback walikelas-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td>' +
                        '<input type="text" id="ruang" class="form-control form-control-sm" name="ruang" style="width: 200px; height: 34px">' +
                        '<div class="invalid-feedback ruang-feedback"></div>' +
                        '</td>';
                    html +=
                        '<td class="px-0 text-center"><button type="submit" name="save" id="save" class="btn btn-primary btn-sm mr-2 px-2"><i class="fas fa-save"></i></button><button type="button" name="cancel" id="cancel" class="btn btn-secondary btn-sm px-2"><i class="fas fa-times"></i></button></td>';

                    $("#datatabel > tbody tr#" + data.id).html(html);
                    $('#jenjang, #tingkatan, #kurikulum, #walikelas').select2({
                        theme: 'bootstrap4'
                    });

                    $('#namarombel, #ruang').inputmask({
                        placeholder: '',
                        regex: "[a-zA-Z\\s\\d]+$"
                    });


                    $.ajax({
                        url: '/api/jenjang/<?= session()->npsn ?>',
                        type: "post",
                        success: function(reques) {
                            $("#jenjang").html("<option disabled selected></option>");

                            reques.forEach(function(e) {
                                if (e.jenjang == data.kompetensi) {
                                    $("#jenjang").append('<option value="' + e.jenjang + '" selected>' + e.jenjang + '</option>').trigger('change');
                                } else {
                                    $("#jenjang").append('<option value="' + e.jenjang + '">' + e.jenjang + '</option>');
                                }
                            });
                        },
                    });

                    $("#jenjang").change(function() {
                        $("#tingkatan").html("<option disabled selected></option>");
                        $("#kurikulum").html("<option disabled selected></option>");

                        $.ajax({
                            url: '/api/tingkatan/' + $(this).val(),
                            type: "post",
                            success: function(tingkatan) {
                                tingkatan.forEach(function(ee) {
                                    if (ee.tingkatan == data.tingkatan) {
                                        $("#tingkatan").append('<option value="' + ee.tingkatan + '" selected>' + ee.tingkatan + "</option>").trigger('change');
                                    } else {
                                        $("#tingkatan").append('<option value="' + ee.tingkatan + '">' + ee.tingkatan + "</option>");
                                    }
                                });
                            }
                        });
                    });

                    $("#tingkatan").change(function() {
                        $("#kurikulum").html("<option disabled selected></option>");

                        $.ajax({
                            url: '/api/kurikulum/' + $("#jenjang option:selected").val() + '/' + $(this).val(),
                            type: "post",
                            success: function(tingkatan) {
                                if (tingkatan.kurikulum == data.kurikulum) {
                                    $("#kurikulum").append('<option value="' + tingkatan.kurikulum + '" selected>' + tingkatan.kurikulum + "</option>");
                                } else {
                                    $("#kurikulum").append('<option value="' + tingkatan.kurikulum + '">' + tingkatan.kurikulum + "</option>");
                                }
                            }
                        });
                    });

                    $('#namarombel').val(data.rombel);
                    $('#ruang').val(data.ruang);

                    $.ajax({
                        url: '/api/gtk/<?= session()->npsn ?>',
                        type: "post",
                        success: function(gtk) {
                            gtk.forEach(function(e) {
                                if (e.nama == data.wali) {
                                    $("#walikelas").append('<option value="' + e.nama + '" selected>' + e.nama + "</option>");
                                } else {
                                    $("#walikelas").append('<option value="' + e.nama + '">' + e.nama + "</option>");
                                }
                            });
                        }
                    });
                }
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

        $('.btn-rombel').click(function() {

            if (!$('#datatabel tbody tr.selected').attr('id')) {
                alert("Silahkan pilih salah satu rombel tujuan!");
            } else {
                $('#datatabel').DataTable().ajax.reload();
                $('#modalrombel').modal('show');

                $.ajax({
                    url: "<?= $_SERVER['REQUEST_URI'] ?>/anggotarombel/" + $('#datatabel tbody tr.selected').attr('id'),
                    success: function(response) {
                        $('#modalrombelLabel').html(response.title);

                        var dragSrcRow = null;
                        var selectedRows = null;
                        var srcTable = '';
                        var rows = [];
                        var rows2 = [];

                        var table = $('#tabelrombel').DataTable({
                            ajax: '/api/pd/<?= session()->npsn ?>/' + response.rombel,
                            searching: false,
                            paging: false,
                            info: true,
                            scrollY: 280,
                            order: [
                                [0, 'asc']
                            ],
                            columns: [{
                                data: 'nama',
                            }, {
                                data: 'jenis',
                            }, {
                                data: 'nisn',
                            }, {
                                data: 'nis',
                            }],
                            select: {
                                style: 'os',
                                selector: 'td:first-child'
                            },
                            createdRow: function(row, data, dataIndex, cells) {
                                $(row).attr('draggable', 'true');
                                $(row).attr('id', data.id);
                            },
                            drawCallback: function() {
                                rows = document.querySelectorAll('#tabelrombel tbody tr');
                                [].forEach.call(rows, function(row) {
                                    row.addEventListener('dragover', handleDragOver, false);
                                    row.addEventListener('drop', handleDrop, false);
                                });
                            }
                        });

                        var table2 = $('#tabelrombel2').DataTable({
                            ajax: '/api/pd/<?= session()->npsn ?>',
                            searching: true,
                            paging: true,
                            scrollY: 280,
                            info: true,
                            order: [
                                [0, 'asc']
                            ],
                            columns: [{
                                data: 'nama',
                            }, {
                                data: 'tanggal_lahir',
                            }, {
                                data: 'agama',
                            }, {
                                data: 'rombel',
                            }],
                            select: {
                                style: 'os',
                                selector: 'td:first-child'
                            },
                            createdRow: function(row, data, dataIndex, cells) {
                                $(row).attr('draggable', 'true');
                            },
                            drawCallback: function() {
                                rows2 = document.querySelectorAll('#tabelrombel2 tbody tr');
                                [].forEach.call(rows2, function(row) {
                                    row.addEventListener('dragstart', handleDragStart, false);
                                    row.addEventListener('dragenter', handleDragEnter, false)
                                    row.addEventListener('dragover', handleDragOver, false);
                                    row.addEventListener('dragleave', handleDragLeave, false);
                                    row.addEventListener('drop', handleDrop, false);
                                    row.addEventListener('dragend', handleDragEnd, false);
                                });
                            }
                        });

                        function handleDragStart(e) {
                            this.style.opacity = '0.4';

                            dragSrcRow = this;
                            srcTable = this.parentNode.parentNode.id

                            selectedRows = $('#' + srcTable).DataTable().rows({
                                selected: true
                            });

                            e.dataTransfer.effectAllowed = 'move';
                            e.dataTransfer.setData('text/plain', e.target.outerHTML);
                        }

                        function handleDragOver(e) {
                            if (e.preventDefault) {
                                e.preventDefault();
                            }

                            e.dataTransfer.dropEffect = 'move';

                            return false;
                        }

                        function handleDragEnter(e) {
                            var currentTable = this.parentNode.parentNode.id

                            if (currentTable !== srcTable) {
                                this.classList.add('over');
                            }
                        }

                        function handleDragLeave(e) {
                            this.classList.remove('over');
                        }

                        function handleDrop(e) {
                            if (e.stopPropagation) {
                                e.stopPropagation();
                            }

                            var dstTable = $(this.closest('table')).attr('id');

                            if (srcTable !== dstTable) {
                                if (selectedRows.count() > 0 && $(dragSrcRow).hasClass('selected')) {
                                    $('#' + dstTable).DataTable().rows.add(selectedRows.data()).draw();
                                    $('#' + srcTable).DataTable().rows(selectedRows.indexes()).remove().draw();
                                } else {
                                    var srcData = e.dataTransfer.getData('text/plain');
                                    var data = $('#' + srcTable).DataTable().row(dragSrcRow).data();
                                    $('#' + dstTable).DataTable().row.add($(data)).draw();
                                    $('#' + srcTable).DataTable().row(dragSrcRow).remove().draw();
                                }

                            }
                            return false;
                        }

                        function handleDragEnd(e) {
                            this.style.opacity = '1.0';
                            [].forEach.call(rows, function(row) {
                                row.classList.remove('over');
                                row.style.opacity = '1.0';

                                i = 0;
                                id_array = new Array();
                                $(row).each(function() {
                                    id_array[i] = $(this).attr('id');
                                    i++;
                                });

                                $.ajax({
                                    url: '<?= $_SERVER['REQUEST_URI'] ?>/anggotarombel/' + response.id + '/save',
                                    method: 'POST',
                                    data: {
                                        id: id_array,
                                        jenis: $('#tipedaftar option:selected').val()
                                    },
                                    success: function(re) {
                                        $('#tabelrombel, #tabelrombel2').DataTable().ajax.reload();
                                        toastr.success(re.success)
                                    }
                                })
                            });

                            [].forEach.call(rows2, function(row) {
                                row.classList.remove('over');
                                row.style.opacity = '1.0';
                            });
                        }

                        $('.btn-out-rombel').click(function() {
                            i = 0;
                            id_array = new Array();
                            $('#tabelrombel tbody tr.selected').each(function() {
                                id_array[i] = $(this).attr('id');
                                i++;
                            });

                            $.ajax({
                                url: '<?= $_SERVER['REQUEST_URI'] ?>/anggotarombel/' + response.id + '/delete',
                                method: 'POST',
                                data: {
                                    id: id_array,
                                },
                                success: function(re) {
                                    [].forEach.call(rows, function(row) {
                                        row.classList.remove('over');
                                        row.style.opacity = '1.0';
                                        toastr.success(re.success);
                                        $('#tabelrombel2').DataTable().ajax.reload();
                                        table.row('.selected').remove().draw(false);
                                    });
                                }
                            })
                        });
                    }
                });
            }
        });

        $('.closed').click(function() {
            $('#datatabel').DataTable().ajax.reload();
        });

        $(document).on("click", "#cancel", function() {
            $('#datatabel').DataTable().ajax.reload();
            $(".btn-add").removeClass("disabled");
        });

    });
</script>
<?= $this->endSection(); ?>