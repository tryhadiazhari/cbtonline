<?= $this->extend('layout/template'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<style>
    table.table-pg,
    table.table-essay {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        padding: 0 !important;
    }

    table.table-pg tr.soal-primary>td,
    table.table-essay tr.soal-primary>td {
        border-right: 1px solid #dee2e6 !important;
        border-bottom: 1px solid #dee2e6 !important;
    }

    table.table-pg tr.soal-primary>td:first-child,
    table.table-essay tr.soal-primary>td:first-child {
        border-left: 1px solid #dee2e6 !important;
    }

    table.table-pg tr.soal-primary>td,
    table.table-essay tr.soal-primary>td {
        border-top: 1px solid #dee2e6 !important;
    }

    table.table-pg tr:first-child>td:first-child,
    table.table-essay tr:first-child>td:first-child {
        border-top-left-radius: 0.25rem !important;
    }

    table.table-pg tr:first-child>td:last-child,
    table.table-essay tr:first-child>td:last-child {
        border-top-right-radius: 0.25rem !important;
    }

    table.table-pg tr:last-child>td:first-child,
    table.table-essay tr:last-child>td:first-child {
        border-bottom-left-radius: 0.25rem !important;
    }

    table.table-pg tr:last-child>td:last-child,
    table.table-essay tr:last-child>td:last-child {
        border-bottom-right-radius: 0.25rem !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row my-2">
            <div class="col">
                <h1 style='text-shadow: 2px 2px 4px #827e7e;'>
                    <?= $titlecontent . $mapel['mapel'] ?> <?= (empty($mapel['rombel'])) ? '<small>(' . $mapel['tingkatan'] . ')</small>' : '<small>(' . $mapel['rombel'] . ')</small>' ?>
                </h1>
            </div>
            <div class="col-auto ms-auto">
                <a href='<?= $_SERVER['REQUEST_URI'] ?>/1/1' class="btn btn-sm btn-primary" <?= ($mapel['jml_pg'] == 0) ? "hidden" : "" ?>><i class='fa fa-plus'></i> <span class='d-none d-lg-inline'>Edit PG</span></a>

                <a href='<?= $_SERVER['REQUEST_URI'] ?>/2/1' class="btn btn-sm btn-primary" <?= ($mapel['jml_esai'] == 0) ? "hidden" : "" ?>><i class='fa fa-plus'></i> <span class='d-none d-lg-inline'>Edit Essay</span></a>

                <a class='btn btn-sm btn-primary' href=''><i class='fa fa-file-excel'></i> <span class='d-none d-lg-inline'>Excel</span></a>

                <button class='btn btn-sm btn-primary' onclick="frames['frameresult'].print()" title="Cetak Soal"><i class='fa fa-print'></i> <span class='d-none d-lg-inline'>Cetak</span></button>

                <button class='btn btn-sm btn-primary' onclick="frames['frameresultkey'].print()" title="Cetak Jawaban"><i class='fa fa-print'></i> <span class='d-none d-lg-inline'>Jawaban</span></button>

                <button data-href="/banksoal/question/deleteall/<?= $mapel['uid_banksoal'] ?>" class='btn btn-sm bg-maroon delete-all' title="Kosongkan Soal"><i class='fa fa-trash'></i> <span class='d-none d-lg-inline'>Kosongkan</span></button>

                <iframe id="cetaksoal" name='frameresult' src='/banksoal/cetaksoal' style='display: none; border:none;width:1px;height:1px;'></iframe>

                <iframe id="cetaksoalkunci" name='frameresultkey' src='/banksoal/cetaksoalkunci' style='display: none; border:none;width:1px;height:1px;'></iframe>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary col-12">
            <div class="card-body">
                <div class="row">
                    <label><i class="fas fa-stars"></i> Soal Pilihan Ganda</label>
                    <?php if (count($soalpg) > 0) : ?>
                        <table class="table-pg table table-borderless table-responsive nowrap rounded" width="100%">
                            <tbody>
                                <?php foreach ($soalpg as $nomor => $val) : ?>
                                    <tr class="soal-primary">
                                        <td width="20px">
                                            <?= ($nomor + 1) . '.' ?>
                                        </td>
                                        <td class="text-justify">
                                            <?= $val['soal'] ?>
                                            <?php
                                            if ($val['file_audio'] <> '') :
                                                $audio = array('mp3');
                                                $ext = explode(".", $val['file_audio']);
                                                $ext = end($ext);
                                                if (in_array($ext, $audio)) {
                                                    echo '<audio controls><source src="/assets/uploads/audio/' . $val['file_audio'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                } else {
                                                    echo "File tidak didukung!";
                                                }
                                            endif;
                                            ?>

                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                                                    <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                        <?= ($val['pilA'] == "") ? "" : $val['pilA'] ?>
                                                        <?php
                                                        if ($val['fileA'] <> '') {
                                                            $audio = array('mp3');
                                                            $ext = explode(".", $val['fileA']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $audio)) {
                                                                echo '<audio controls><source src="/assets/uploads/audio/' . $val['fileA'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
                                                    <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                        <?= ($val['pilC'] == "") ? "" : $val['pilC'] ?>
                                                        <?php
                                                        if ($val['fileC'] <> '') {
                                                            $audio = array('mp3');
                                                            $ext = explode(".", $val['fileC']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $audio)) {
                                                                echo '<audio controls><source src="/assets/uploads/audio/' . $val['fileC'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php if ($mapel['opsi'] == 5) : ?>
                                                        <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
                                                        <td style="padding: 3px; vertical-align: text-top;">
                                                            <?= ($val['pilE'] == "") ? "" : $val['pilE'] ?>
                                                            <?php
                                                            if ($val['fileE'] <> '') {
                                                                $audio = array('mp3');
                                                                $ext = explode(".", $val['fileE']);
                                                                $ext = end($ext);
                                                                if (in_array($ext, $audio)) {
                                                                    echo '<audio controls><source src="/assets/uploads/audio/' . $val['fileE'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                                } else {
                                                                    echo "File tidak didukung!";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
                                                    <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                        <?= ($val['pilB'] == "") ? "" : $val['pilB'] ?>
                                                        <?php
                                                        if ($val['fileB'] <> '') {
                                                            $audio = array('mp3');
                                                            $ext = explode(".", $val['fileB']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $audio)) {
                                                                echo '<audio controls><source src="/assets/uploads/audio/' . $val['fileB'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php if ($mapel['opsi'] <> 3) : ?>
                                                        <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
                                                        <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                            <?= ($val['pilD'] == "") ? "" : $val['pilD'] ?>
                                                            <?php
                                                            if ($val['fileD'] <> '') {
                                                                $audio = array('mp3');
                                                                $ext = explode(".", $val['fileD']);
                                                                $ext = end($ext);
                                                                if (in_array($ext, $audio)) {
                                                                    echo '<audio controls><source src="/assets/uploads/audio/' . $val['fileD'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                                } else {
                                                                    echo "File tidak didukung!";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td colspan='2' style="padding: 3px;vertical-align: text-top;">
                                                        Kunci : <?= $val['jawaban'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="align-middle" width="10px">
                                            <button class='btn bg-danger btn-sm delete-soal' data-href="/banksoal/question/deletesoal/<?= $val['uid_soal'] ?>"><i class='fas fa-trash-alt'></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="col-12">Tidak ada data tersedia...</div>
                    <?php endif ?>
                </div>
                <div class="row mt-3" <?= ($mapel['jml_esai'] == 0) ? 'style="display: none"' : '' ?>>
                    <label><i class="fas fa-stars"></i> Soal Essay</label>
                    <?php if (count($soalessay) > 0) : ?>
                        <table class="table-essay table table-borderless table-responsive-xs nowrap rounded" width="100%">
                            <tbody>
                                <?php foreach ($soalessay as $nomor => $val) : ?>
                                    <tr class="soal-primary">
                                        <td width="20px">
                                            <?= ($nomor + 1) . '.' ?>
                                        </td>
                                        <td class="text-justify"><?= $val['soal'] ?></td>
                                        <td class="align-middle" width="10px">
                                            <button class='btn bg-danger btn-sm delete-soal' data-href="/banksoal/question/deletesoal/<?= $val['uid_soal'] ?>"><i class='fas fa-trash-alt'></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="col-12">Tidak ada data tersedia...</div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('plugins'); ?>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('.delete-all').on('click', function(e) {
            Swal.fire({
                title: 'Anda ingin semua soal ini?',
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
                            },
                            404: function(error) {
                                console.log(error.responseJSON)
                            }
                        },
                        success: function(response) {
                            toastr.success(response.success);

                            location.reload()
                        }
                    });
                }
            });
        });

        $(document).on('click', '.delete-soal', function(e) {
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
                            },
                            404: function(error) {
                                console.log(error.responseJSON)
                            }
                        },
                        success: function(response) {
                            toastr.success(response.success);

                            location.reload()
                        }
                    });
                }
            });
        })
    })
</script>
<?= $this->endSection(); ?>