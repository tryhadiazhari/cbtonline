<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row my-2">
            <div class="col">
                <h1 style='text-shadow: 2px 2px 4px #827e7e;'>
                    <?= ($mapel['kategori'] == '') ? $titlecontent . " " . $mapel['mapel'] . " <small>(" . $mapel['rombel'] . ")</small>" : $titlecontent . " " . $mapel['mapel'] . " " . $mapel['kategori'] . " <small>(" . $mapel['rombel'] . ")</small>" ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12">
            <form class="formsoal" action="#" method="POST">
                <div class="card-header px-3">
                    <div class="row">
                        <div class="col-auto ms-auto">
                            <button type="submit" class="btn btn-success btn-sm btn-soal-save">
                                <i class="fas fa-save"></i> <span class="d-none d-lg-inline">Simpan</span>
                            </button>
                            <button type="button" class="btn btn-info btn-sm" onclick="window.location='../'"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="idmapel" value="<?= $mapel['uid_banksoal'] ?>">
                        <input type="hidden" name="jenis" value="<?= service('uri')->getSegment(4) ?>">
                        <input type="hidden" name="nomor" id="nomor">
                        <input type="hidden" name="urls" id="urls" value="<?= $_SERVER['REQUEST_URI'] ?>">

                        <?php if (service('uri')->getSegment(4) == 1) : ?>
                        <?php endif; ?>
                        <div class="col-12 px-0">
                            <div class="mb-3 text-justify" style="border-bottom: 2px silver solid">
                                <?php for ($i = 1; $i <= (service('uri')->getSegment(4) == 1 ? $mapel['jml_pg'] : $mapel['jml_esai']); $i++) : ?>
                                    <button type="button" class="btn <?= ($i == service('uri')->getSegment(5)) ? "btn-primary" : "btn-default" ?> btn-xs nomsoal mb-3 mr-1 px-2" data-id="<?= $mapel['uid_banksoal'] ?>" data-soal="<?= $i ?>" data-href="/banksoal/question/<?= $mapel['uid_banksoal'] . '/' . service('uri')->getSegment(4) . '/' . $i ?>"><?= $i ?></button>
                                <?php endfor; ?>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <textarea name='soal' id="soal" class='editor' rows='10' cols='80' style='resize: none; width:100%;'></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">File Audio</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                                <div class="col-12">
                                    <div class="accordion" id="accordionFlushExample" <?= (service('uri')->getSegment(4) == 2) ? 'style="display: none"' : '' ?>>
                                        <?php $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];
                                        for ($ii = 1; $ii <= $mapel['opsi']; $ii++) : ?>
                                            <div class="accordion-item">
                                                <div class="accordion-header">
                                                    <button id="acc-<?= $array[$ii]; ?>" class="accordion-button collapsed" type="button">
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input jawaban" type="radio" name="jawaban" id="check<?= $array[$ii]; ?>" value="<?= $array[$ii]; ?>">
                                                                <label class="form-check-label col-12 px-0 py-0" style="cursor: pointer" data-toggle="collapse" data-target="#flush-<?= $array[$ii]; ?>">
                                                                    <h4 class="btn px-0 m-0 py-0">
                                                                        Jawaban <?= $array[$ii]; ?>
                                                                    </h4>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto ms-auto kunci-jawaban px-0 py-0" id="key<?= $array[$ii]; ?>"></div>
                                                    </button>
                                                </div>
                                                <div id="flush-<?= $array[$ii]; ?>" class="accordion-collapse collapse" data-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <textarea name="pil<?= $array[$ii] ?>" id="pil<?= $array[$ii] ?>" class="pilihan form-control" data-id="<?= $array[$ii] ?>" style="resize: none" placeholder="Isi jawaban disini"></textarea>
                                                        <div class="col-12 px-0" id="files<?= $array[$ii] ?>" data-id="<?= $array[$ii] ?>"></div>
                                                        <div class="col-12 mt-2">
                                                            <label class="form-label">File Audio</label>
                                                            <input type="file" name="file<?= $array[$ii] ?>" id="file<?= $array[$ii] ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src='/assets/plugins/tinymce/tinymce.min.js'></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '#soal, .pilihan',
            resize: false,
            branding: false,
            themes: "mobile",
            menubar: false,
            statusbar: false,
            plugins: [
                'lists link image charmap hr  searchreplace insertdatetime table responsivefilemanager',
                'textcolor colorpicker textpattern imagetools uploadimage paste formula code'
            ],
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            toolbar: 'undo redo | searchreplace paste cut | styleselect | hr | alignleft aligncenter alignright | bullist numlist | indent outdent | backcolor forecolor | formula link charmap insertdatetime | table | image | responsivefilemanager code',
            paste_data_images: true,

            images_upload_handler: function(blobInfo, success, failure) {
                success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
            },
            image_class_list: [{
                title: 'Responsive',
                value: 'img-fluid'
            }],
            setup: function(editor) {
                editor.on('init', function() {
                    openURL($('#urls').val());
                });
            }
        });

        openURL($('#urls').val());

        function openURL(href) {
            var str = href.split("/");

            $.ajax({
                url: '/api/soal/' + str[3] + '/' + str[4] + '/' + str[5],
                success: function(result) {
                    $('.nomsoal[data-soal="' + str[5] + '"]').removeClass('btn-default').addClass('btn-primary');

                    tinymce.get('soal').setContent(result.soal);

                    $('#nomor').val(str[5]);

                    result.opsi.forEach(function(value) {
                        $.each(value, function(a, b) {
                            $('#' + a).val(b);
                            tinymce.get(a).setContent(b);

                            if ($('#' + a).data('id') == result.kunci) {
                                $('#flush-' + $('#' + a).data('id')).addClass('show');
                                $('#check' + $('#' + a).data('id')).prop('checked', true);
                                $('#key' + $('#' + a).data('id')).html('<label class="label label-success rounded-pill">Kunci</label>');
                                $('#acc-' + $('#' + a).data('id')).removeClass('collapsed');
                            } else {
                                $('#acc-' + $('#' + a).data('id')).addClass('collapsed');
                                $('#flush-' + $('#' + a).data('id')).removeClass('show');
                                $('#check' + $('#' + a).data('id')).prop('checked', false);
                                $('#key' + $('#' + a).data('id')).html('');
                                $('#file').val('');
                            }
                            $('#file' + $('#' + a).data('id')).val('');
                        });
                    });

                    result.file.forEach(function(value) {
                        $.each(value, function(a, b) {
                            var replace = a.split('file');

                            if ($('#files' + replace[1]).data('id') == result.kunci) {
                                if (b != '') {
                                    $('#files' + replace[1]).html('<div class="mt-3"><audio controls><source src="/assets/uploads/audio/' + b + '" type="audio/mpeg">Your browser does not support the audio tag.</audio></div>');
                                } else {
                                    $('#files' + replace[1]).html('')
                                }
                            } else {
                                if (b != '') {
                                    $('#files' + replace[1]).html('<div class="mt-3"><audio controls><source src="/assets/uploads/audio/' + b + '" type="audio/mpeg">Your browser does not support the audio tag.</audio></div>');
                                } else {
                                    $('#files' + replace[1]).html('')
                                }
                            }
                        });
                    });
                }
            });

            window.history.pushState({
                href: href
            }, '', href);
        }

        $(document).on('click', '.nomsoal', function() {
            $('#urls').val($(this).data("href"))

            openURL($('#urls').val());

            $('.nomsoal').removeClass('btn-primary').addClass('btn-default');

            return false;
        });

        window.addEventListener('popstate', function(e) {
            if (e.state)
                openURL(e.state.href);
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/banksoal/question/save/' + str[5] + '/' + str[6] + '/' + str[7],
                type: "POST",
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                error: function(error) {
                    toastr.error($(this).attr('action'));
                },
                success: function(response) {
                    toastr.success(response.success);
                    openURL($('#urls').val());
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>