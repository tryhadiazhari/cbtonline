<?php
if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}
?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class='form-group'>
                    <label>Pilih Rombel</label>
                    <select id="datarombel" class="form-control" data-placeholder="Pilih">
                        <option disabled selected></option>
                        <?php foreach ($datarombel as $rombel) : ?>
                            <option value="<?= $rombel['nama'] ?>" data-tingkatan="<?= $rombel['tingkatan'] ?>"><?= $rombel['nama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>

        <div id="view"></div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Select/js/dataTables.select.min.js"></script>
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#datarombel').select2({
            theme: 'bootstrap4',
            placeholder: $(this).data('placeholder')
        });

        $('#datarombel').change(function() {
            $.ajax({
                url: '<?= $_SERVER['REQUEST_URI'] ?>/checked/' + $(this).val() + '/' + $('#datarombel option:selected').data('tingkatan'),
                type: 'POST',
                error: function(error) {
                    console.log(error)
                },
                success: function(response) {
                    console.log(response);
                    $('#view').html(response).hide();

                    $('.btn-cetak').click()
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>