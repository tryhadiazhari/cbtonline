<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
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
        <div class="row row-cols-1 row-cols-md-3 g-4" id="list-users"></div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(function() {
        $('#list-users').slimScroll({
            height: '464px'
        });
    });

    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');

        $.ajax({
            url: '<?= $_SERVER['REQUEST_URI'] ?>/status',
            success: function(response) {
                $('#list-users').html(response)
                $.each(response, function(field, val) {
                    $('.list-nama').html(val.nama).addClass('label label-primary bg-gradient rounded-pill');
                    $('.list-state').html(val.state).addClass('btn btn-info bg-gradient text-uppercase rounded-pill');

                    var countDownDate = Date.parse(val.formattime);

                    var x = setInterval(function() {

                        var now = new Date().getTime();

                        var distance = countDownDate - now;

                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        hours = hours < 10 ? '0' + hours : hours;
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        seconds = seconds < 10 ? '0' + seconds : seconds;

                        $('#' + val.id_siswa).html(hours + ':' + minutes + ':' + seconds).addClass('label label-success rounded-pill bg-gradient text-white fw-bold');

                        if (distance < 0) {
                            clearInterval(x);
                            $('.list-state').html('Selesai Ujian').removeClass('label-info').addClass('label label-success rounded-pill bg-gradient');
                            $('#' + val.id_siswa).html('00:00:00');
                        }
                    }, 1000);
                })
            }
        })
    });
</script>
<?= $this->endSection(); ?>