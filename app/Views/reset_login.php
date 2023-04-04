<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables/extensions/Select/css/select.dataTables.min.css">
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
                <button type="button" class="btn btn-primary bg-gradient btn-sm btn-reset">
                    <i class="fas fa-redo-alt"></i>
                    <span class="d-none d-md-inline">Reset</span>
                </button>
                <button type="button" class="btn btn-secondary bg-gradient btn-sm btn-refresh">
                    <i class="fas fa-redo-alt"></i>
                    <span class="d-none d-md-inline">Refresh</span>
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
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Tingkatan / Rombel</th>
                            <th class="noshort">IP Address</th>
                            <th class="noshort">Waktu Login</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Select/js/dataTables.select.min.js"></script>
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

        $('.btn-reset').on('click', function(e) {
            e.preventDefault();
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
                $.ajax({
                    url: "<?= $_SERVER['REQUEST_URI']; ?>/request",
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
                        $('.form-check-input').prop('checked', false);
                    }
                });
            }
        });

        $('.btn-refresh').click(function() {
            $('#datatabel').DataTable().ajax.reload();
            $('.form-check-input').prop('checked', false);
        })
    });
</script>
<?= $this->endSection(); ?>