<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12 px-0">
            <form action="<?= $_SERVER['REQUEST_URI'] ?>/save" id="formimport" method="POST">
                <div class="card-body">
                    <textarea name="soal" id="soal" rows="15"></textarea>
                    <textarea id="importsoal" name="importsoal" class="col-12" style="height: 100px"></textarea>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm btn-import">Import</button>
                </div>
            </form>
        </div>
        <div class="card card-outline card-primary col-12 px-0">
            <div class="card-body">
                <div id="datasoal"></div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/ckeditor/standart/ckeditor.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        CKEDITOR.replace('soal', {
            width: '100%',
            height: 300,
            removePlugins: 'resize',
            removeButtons: 'PasteFromWord'
        });

        $('#formimport').on('submit', function(e) {
            e.preventDefault();

            $('#importsoal').val(CKEDITOR.instances.soal.getData());

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache: false,
                timeout: 300000,
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#loader').fadeIn();
                },
                complete: function() {
                    $('#loader').fadeOut('slow');
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr.error(error.responseText);
                    }
                },
                success: function(response) {
                    var obj = $.parseJSON(response);
                    console.log(obj.soal);
                    $('#importsoal').val(obj.soal);
                    $('#datasoal').html(obj.soal)
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>