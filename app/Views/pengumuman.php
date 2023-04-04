<?= $this->extend('layout/template'); ?>

<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalform">
                    <i class="fas fa-plus"></i> <span class="hidden-xs">Tambah</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12">
            <div class="card-body">
                <table id="datatabel" class="table table-hover table-responsive-md nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Post By</th>
                            <th>Post Date</th>
                            <th class="noshort" width="10%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.box -->
    </div>

    <div class="modal fade" id="modalform" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalformLabel" aria-hidden="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="/pengumuman/save" class="formpengumuman" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalformLabel">Tambah Pengumuman</h5>
                    </div>
                    <div class="modal-body m-0">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" autocomplete="off">
                            <label for="judul" class="form-label">Judul</label>
                            <div class="invalid-feedback error-judul"></div>
                        </div>
                        <div>
                            <textarea id='teks' name='teks' class='form-control'></textarea>
                            <div class="invalid-feedback error-teks"></div>
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
<!-- /.content -->
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#teks').summernote({
            height: 150, //set editable area's height
            disableResize: true, // Does not work
            disableResizeEditor: true // Does not work either
        });

        $('#judul').inputmask({
            placeholder: '',
            regex: '[a-zA-Z0-9\\s\\?!,.]+$'
        });

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

        $('.formpengumuman').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#simpan').html('<i class="fa fa-spinner-third fa-spin"></i>');
                    $('.form-control').removeClass('is-invalid');
                },
                complete: function() {
                    $('#simpan').html('Simpan');
                },
                statusCode: {
                    404: function(errors) {
                        $.each(errors.responseJSON, function(field, val) {
                            $('#' + field).addClass('is-invalid');
                            $('.error-' + field).text(val);
                        });
                    },
                    400: function(errors) {
                        toastr.error(errors.responseJSON.error);
                    },
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('#datatabel').DataTable().ajax.reload();
                    $(".modal").modal('hide').on('hidden.bs.modal', function() {
                        $(this).find('.form-control').removeClass('is-invalid');
                        $(this).find('form')[0].reset();
                        $('#teks').summernote('code', '<p><br></p>');
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            $('#modalform').modal('show');

            $.ajax({
                url: $(this).data('href'),
                success: function(response) {
                    $('#modalformLabel').html(response.title);
                    $('#judul').val(response.data.judul);
                    $('#teks').summernote('code', response.data.text);
                    $('.formpengumuman').attr('action', response.action);
                }
            })
        });

        $(document).on('click', '.btn-delete', function() {
            swal.fire({
                icon: 'info',
                html: 'Anda ingin hapus data ini?',
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
                            400: function(errors) {
                                toastr.error(errors.responseJSON.error);
                            }
                        },
                        success: function(response) {
                            toastr.success(response.success);
                            $('#datatabel').DataTable().ajax.reload();
                            $(this).find('.form-control').removeClass('is-invalid');
                            $('form').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
                            $('#teks').summernote('code', '<p><br></p>');
                        }
                    });
                }
            });
        });

        $('.closed').click(function() {
            $('#datatabel').DataTable().ajax.reload();
            $(".modal").modal('hide').on('hidden.bs.modal', function() {
                $(this).find('.form-control').removeClass('is-invalid');
                $('form').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
                $('#teks').summernote('code', '<p><br></p>');
            });
        })
    });
</script>
<?= $this->endSection(); ?>