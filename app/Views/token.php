<?= $this->extend('layout/template'); ?>
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
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="isi_token"><?= $token; ?></h3>
                <p class="fs-6">Token Ujian</p>
            </div>
            <div class="icon">
                <i class="fa fa-barcode"></i>
            </div>
        </div>
        <button type="submit" id="generate" name="generate" class="btn btn-block btn-flat bg-maroon bg-gradient">Generate</button>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        function loadtoken() {
            $.ajax({
                url: '/token/check',
                success: function(response) {
                    $('#isi_token').html(response.token)
                }
            });
        }

        $('#generate').on('click', function() {
            $.ajax({
                url: '/token/check/generate',
                success: function(response) {
                    $('#isi_token').html(response.token)
                }
            });
        });

        setInterval(function() {
            loadtoken();
        }, 900000);
    })
</script>
<?= $this->endSection(); ?>