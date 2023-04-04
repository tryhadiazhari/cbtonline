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
            <div class="col-auto ms-auto" <?= ($akses['add'] == 0) ? 'style="display: none"' : '' ?>>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modalform">
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
                            <th width="10%">NPSN</th>
                            <th>Satuan Pendidikan</th>
                            <th width="25%">Alamat</th>
                            <th width="20%">Kepsek</th>
                            <th width="1%" class="noshort">Status</th>
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
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Identitas Lembaga</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="npsn form-control" name="npsn" id="npsn" placeholder="NPSN">
                                                    <label for="npsn">NPSN</label>
                                                    <div class="text-bold invalid-feedback error-npsn"></div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="satuanpendidikan" class="satuanpendidikan form-control" id="satuanpendidikan" placeholder="Satuan Pendidikan">
                                                    <label for="satuanpendidikan">Nama Satuan Pendidikan</label>
                                                    <div class="text-bold invalid-feedback error-satuanpendidikan"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="kepsek" class="kepsek form-control" id="kepsek" placeholder="Nama Kepsek">
                                                    <label for="kepsek">Nama Kepsek</label>
                                                    <div class="text-bold invalid-feedback error-kepsek"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select name="jenis" id="jenis" class="form-select" data-placeholder="Jenjang Satuan Pendidikan">
                                                        <option disabled selected></option>
                                                        <?php foreach ($datajenjang as $jenjang) : ?>
                                                            <option value="<?= $jenjang['jenjang'] ?>"><?= $jenjang['jenjang'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-jenis"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="datajenjang" style="display: none">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select name="jenjang[]" id="jenjang" class="form-select" data-placeholder="Program Keahlian" multiple>
                                                        <option disabled selected></option>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-jenjang"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select name="status" id="status" class="form-select" data-placeholder="Pilih Status Sekolah">
                                                        <option disabled selected></option>
                                                        <option value="Negeri">Negeri</option>
                                                        <option value="Swasta">Swasta</option>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-status"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                                                    <label for="alamat">Alamat</label>
                                                    <div class="text-bold invalid-feedback error-alamat"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select name="provinsi" id="provinsi" class="form-select" data-placeholder="Pilih Provinsi">
                                                        <option disabled selected></option>
                                                        <?php foreach ($provinsi as $prov) : ?>
                                                            <option value="<?= $prov['name'] ?>" data-id="<?= $prov['id'] ?>"><?= $prov['name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-provinsi"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <select name="kabupaten" id="kabupaten" class="form-select" data-placeholder="Pilih Kabupaten">
                                                        <option disabled selected></option>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-kabupaten"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <select name="kecamatan" id="kecamatan" class="form-select" data-placeholder="Pilih Kecamatan">
                                                        <option disabled selected></option>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-kecamatan"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select name="kelurahan" class="form-select" id="kelurahan" data-placeholder="Desa/Kelurahan">
                                                        <option disabled selected></option>
                                                    </select>
                                                    <div class="text-bold invalid-feedback error-kelurahan"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Kontak Sekolah</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Nomor HP" maxlength="13">
                                                    <label for="telepon">No. Handphone</label>
                                                    <div class="text-bold invalid-feedback error-telepon"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email Lembaga" />
                                                    <label for="email">Email Lembaga</label>
                                                    <div class="text-bold invalid-feedback error-email"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="website" name="website" class="form-control" placeholder="Website" />
                                                    <label for="website">Website</label>
                                                    <small class="text-italic">Contoh: https://sekolahku.hazwebdevelopment.com</small>
                                                    <div class="text-bold invalid-feedback error-website"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Kontak Operator</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="namaoperator" name="namaoperator" class="form-control" placeholder="Nama Operator" data-mask />
                                                    <label for="namaoperator">Nama Operator</label>
                                                    <div class="text-bold invalid-feedback error-namaoperator"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="emailoperator" name="emailoperator" class="form-control" placeholder="Email Operator" />
                                                    <label for="emailoperator">Email Operator</label>
                                                    <div class="text-bold invalid-feedback error-emailoperator"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="telpoperator" name="telpoperator" class="form-control" placeholder="No HP Operator" maxlength="13" placeholder="Nomor HP" />
                                                    <label for="telpoperator">No. Hp Operator</label>
                                                    <div class="text-bold invalid-feedback error-telpoperator"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary closed" data-dismiss="modal">Keluar</button>
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
                "url": "<?= $_SERVER['REQUEST_URI']; ?>/dataview",
                "dataSrc": function(data) {
                    return data.data;
                }
            }
        });

        $('#jenis, #status, #jenjang, #kelurahan, #kecamatan, #kabupaten, #provinsi').select2({
            placeholder: $(this).data('placeholder'),
            theme: 'bootstrap4',
        });

        $("#email, #emailoperator").inputmask({
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

        $("#website").inputmask({
            placeholder: '',
            mask: "https://*{1,20}[.h\\azwebdevelopment\\.com]",
            greedy: false,
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z]",
                    casing: "lower"
                }
            }
        });

        $('#telepon, #telpoperator').inputmask({
            placeholder: '',
            regex: '\\d+$'
        });

        $('#alamat').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\s\\./-]+$"
        });

        $('#npsn').inputmask({
            placeholder: '',
            regex: "[A-Z0-9]+$"
        });

        $('#satuanpendidikan').inputmask({
            placeholder: '',
            regex: "[a-zA-Z0-9\\s]+$"
        });

        $('#kepsek, #namaoperator').inputmask({
            placeholder: '',
            mask: "*{1,20}[,*{1,2}][.*{1,8}]",
            greedy: false,
            definitions: {
                '*': {
                    validator: "[a-zA-Z\\s]",
                }
            }
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
            $('#modalform').find('form').attr('action', '/sp/save');

            $("#jenis").change(function() {
                $('#jenjang').html('<option disabled selected></option>');

                $.ajax({
                    url: '<?= base_url(); ?>/api/layanan/' + $(this).val(),
                    type: 'GET',
                    success: function(data) {
                        $('#jenjang').html('');

                        if (data.length == 0) {
                            $('#datajenjang').css('display', 'none');
                        } else {
                            $('#datajenjang').css('display', 'block');
                            data.forEach(function(val) {
                                if (val.jurusan != '') {
                                    $('#jenjang').append('<option value="' + val.jurusan + '">' + val.jurusan + '</option>');
                                } else {
                                    $('#jenjang').append('<option value="' + val.jenjang + '">' + val.jenjang + '</option>');
                                }
                            });
                        }
                    }
                });
            });
        });

        $("#jenis").change(function() {
            $('#jenjang').html('<option disabled selected></option>');

            $.ajax({
                url: '<?= base_url(); ?>/api/layanan/' + $(this).val(),
                type: 'GET',
                success: function(data) {
                    $('#jenjang').html('');

                    if (data.length == 0) {
                        $('#datajenjang').css('display', 'none');
                    } else {
                        $('#datajenjang').css('display', 'block');
                        data.forEach(function(val) {
                            if (val.jurusan != '') {
                                $('#jenjang').append('<option value="' + val.jurusan + '">' + val.jurusan + '</option>');
                            } else {
                                $('#jenjang').append('<option value="' + val.jenjang + '">' + val.jenjang + '</option>');
                            }
                        });
                    }
                }
            });
        })

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
                            $('.error-' + field).text(val);
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
                        $("#jenjang").html('');
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
                    });

                    $("#jenis").val(response.jenis).trigger('change');

                    $.ajax({
                        url: '<?= base_url(); ?>/api/layanan/' + $("#jenis option:selected").val(),
                        type: 'GET',
                        success: function(data) {
                            $('#jenjang').html('');

                            if (data.length == 0) {
                                $('#datajenjang').css('display', 'none').trigger('change');
                            } else {
                                $('#datajenjang').css('display', 'block').trigger('change');

                                data.forEach(function(val) {
                                    if (val.jurusan != '') {
                                        if (jQuery.inArray(val.jurusan, response.jenjang) != '-1') {
                                            $('#jenjang').append('<option value="' + val.jurusan + '" selected>' + val.jurusan + '</option>').trigger('change');
                                        } else {
                                            $('#jenjang').append('<option value="' + val.jurusan + '">' + val.jurusan + '</option>');
                                        }
                                    } else {
                                        if (jQuery.inArray(val.jenjang, response.jenjang) != '-1') {
                                            $('#jenjang').append('<option value="' + val.jenjang + '" selected>' + val.jenjang + '</option>').trigger('change');
                                        } else {
                                            $('#jenjang').append('<option value="' + val.jenjang + '">' + val.jenjang + '</option>');
                                        }
                                    }
                                });
                            }
                        }
                    });

                    $("#status").val(response.status).trigger('change');

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

        $('.closed').click(function() {
            $('#datatabel').DataTable().ajax.reload();
            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                $(this).find('.form-control, .form-select').removeClass('is-invalid');
                $(this).find('form')[0].reset();
                $(".form-select").trigger("change");
                $("#jenjang").html('');
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
                                $("#jenjang").html('');
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>