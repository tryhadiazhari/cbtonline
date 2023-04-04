<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-outline card-primary col-12">
                <div class="card-header px-3">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-header p-0 m-0" style="border: none"><?= $titlecontent . " " . $tampildata['nama'] . " | " . $tampildata['rombel'] ?></h5>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href='/banksoal/pg/<?= $tampildata['idbsoal'] ?>/1/1' class="btn btn-sm btn-primary" <?= ($tampildata['jml_soal'] == 0) ? "hidden" : "" ?>><i class='fa fa-plus'></i> <span class='d-none d-lg-inline'>Edit PG</span></a>

                            <a href='/banksoal/essai/<?= $tampildata['idbsoal'] ?>/2/1' class="btn btn-sm btn-primary" <?= ($tampildata['jml_esai'] == 0) ? "hidden" : "" ?>><i class='fa fa-plus'></i> <span class='d-none d-lg-inline'>Edit Essai</span></a>

                            <a class='btn btn-sm btn-primary' href='soal_excel.php?m=68'><i class='fa fa-file-excel'></i> <span class='d-none d-lg-inline'>Excel</span></a>

                            <button class='btn btn-sm btn-primary' onclick="frames['frameresult'].print()" title="Cetak Soal"><i class='fa fa-print'></i> <span class='d-none d-lg-inline'>Cetak</span></button>

                            <button class='btn btn-sm btn-primary' onclick="frames['frameresultkey'].print()" title="Cetak Jawaban"><i class='fa fa-print'></i> <span class='d-none d-lg-inline'>Jawaban</span></button>

                            <button data-href="/banksoal/deleteall/<?= $tampildata['idbsoal'] ?>" class='btn btn-sm bg-maroon delete-all' title="Kosongkan Soal"><i class='fa fa-trash'></i> <span class='d-none d-lg-inline'>Kosongkan</span></button>

                            <iframe id="cetaksoal" name='frameresult' src='/banksoal/cetaksoal/<?= $tampildata['idbsoal'] ?>' style='display: none; border:none;width:1px;height:1px;'></iframe>

                            <iframe id="cetaksoalkunci" name='frameresultkey' src='/banksoal/cetaksoalkunci/<?= $tampildata['idbsoal'] ?>' style='display: none; border:none;width:1px;height:1px;'></iframe>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <?php if (count($tampilsoalpg) > 0) : ?>
                            <div>
                                <b>Soal Pilihan Ganda</b>
                                <table class=" table table-bordered">
                                    <tbody>
                                        <?php foreach ($tampilsoalpg as $soalpg) : ?>
                                            <tr>
                                                <td style='width:30px'>
                                                    <?= $soalpg['nomor'] ?>
                                                </td>
                                                <td style="text-align:justify">
                                                    <?php
                                                    if ($soalpg['file'] <> '') :
                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                        $ext = explode(".", $soalpg['file']);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo '<p style="margin-bottom: 5px"><img src="' . base_url() . '/assets/files/' . $soalpg['file'] . '" style="max-width: 200px;"/></p>';
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo '<p style="margin-bottom: 5px"><audio controls><source src="' . base_url() . '/assets/files/' . $soalpg['file'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio></p>';
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    endif;
                                                    ?>

                                                    <?= $soalpg['soal'] ?>

                                                    <?php
                                                    if ($soalpg['file1'] <> '') :
                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                        $ext = explode(".", $soalpg['file1']);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo '<p style="margin-bottom: 5px"><img src="' . base_url() . '/assets/files/' . $soalpg['file1'] . '" style="max-width: 200px;"/></p>';
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo '<p style="margin-bottom: 5px"><audio controls><source src="' . base_url() . '/assets/files/' . $soalpg['file1'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio></p>';
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    endif;
                                                    ?>

                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                                                            <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                <?= ($soalpg['pilA'] == "") ? "" : $soalpg['pilA'] ?>
                                                                <?php
                                                                if ($soalpg['fileA'] <> '') {
                                                                    $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                    $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                    $ext = explode(".", $soalpg['fileA']);
                                                                    $ext = end($ext);
                                                                    if (in_array($ext, $image)) {
                                                                        echo '<img src="' . base_url() . '/assets/files/ ' . $soalpg['fileA'] . '" style="max-width: 100px;" />';
                                                                    } elseif (in_array($ext, $audio)) {
                                                                        echo '<audio controls><source src="' . base_url() . '/files/' . $soalpg['fileA'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                                    } else {
                                                                        echo "File tidak didukung!";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
                                                            <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                <?= ($soalpg['pilC'] == "") ? "" : $soalpg['pilC'] ?>
                                                                <?php
                                                                if ($soalpg['fileC'] <> '') {
                                                                    $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                    $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                    $ext = explode(".", $soalpg['fileC']);
                                                                    $ext = end($ext);
                                                                    if (in_array($ext, $image)) {
                                                                        echo '<img src="' . base_url() . '/assets/files/ ' . $soalpg['fileC'] . '" style="max-width: 100px;" />';
                                                                    } elseif (in_array($ext, $audio)) {
                                                                        echo '<audio controls><source src="' . base_url() . '/files/' . $soalpg['fileC'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                                    } else {
                                                                        echo "File tidak didukung!";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php if ($tampildata['opsi'] == 5) : ?>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
                                                                <td style="padding: 3px; vertical-align: text-top;">
                                                                    <?= ($soalpg['pilE'] == "") ? "" : $soalpg['pilE'] ?>
                                                                    <?php
                                                                    if ($soalpg['fileE'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soalpg['fileE']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo '<img src="' . base_url() . '/assets/files/ ' . $soalpg['fileE'] . '" style="max-width: 100px;" />';
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo '<audio controls><source src="' . base_url() . '/files/' . $soalpg['fileE'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
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
                                                                <?= ($soalpg['pilB'] == "") ? "" : $soalpg['pilB'] ?>
                                                                <?php
                                                                if ($soalpg['fileB'] <> '') {
                                                                    $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                    $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                    $ext = explode(".", $soalpg['fileB']);
                                                                    $ext = end($ext);
                                                                    if (in_array($ext, $image)) {
                                                                        echo '<img src="' . base_url() . '/assets/files/ ' . $soalpg['fileB'] . '" style="max-width: 100px;" />';
                                                                    } elseif (in_array($ext, $audio)) {
                                                                        echo '<audio controls><source src="' . base_url() . '/files/' . $soalpg['fileB'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
                                                                    } else {
                                                                        echo "File tidak didukung!";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php if ($tampildata['opsi'] <> 3) : ?>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?= ($soalpg['pilD'] == "") ? "" : $soalpg['pilD'] ?>
                                                                    <?php
                                                                    if ($soalpg['fileD'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soalpg['fileD']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo '<img src="' . base_url() . '/assets/files/ ' . $soalpg['fileD'] . '" style="max-width: 100px;" />';
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo '<audio controls><source src="' . base_url() . '/files/' . $soalpg['fileD'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio>';
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
                                                                Kunci : <?= $soalpg['jawaban'] ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style='width:30px'>
                                                    <button class='btn bg-danger btn-sm delete-soal' data-href="/banksoal/deletesoal/<?= $soalpg['id_soal'] ?>"><i class='fas fa-trash-alt'></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            Data tidak tersedia...
                        <?php endif; ?>

                        <?php if (count($tampilsoalessai) > 0) : ?>
                            <div>
                                <b>Soal Essai</b>
                                <table class=" table table-bordered">
                                    <tbody>
                                        <?php foreach ($tampilsoalessai as $soalessai) : ?>
                                            <tr>
                                                <td style='width:30px'>
                                                    <?= $soalessai['nomor'] ?>
                                                </td>
                                                <td style="text-align:justify">
                                                    <?php
                                                    if ($soalessai['file'] <> '') :
                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                        $ext = explode(".", $soalessai['file']);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo '<p style="margin-bottom: 5px"><img src="' . base_url() . '/assets/files/' . $soalessai['file'] . '" style="max-width: 200px;"/></p>';
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo '<p style="margin-bottom: 5px"><audio controls><source src="' . base_url() . '/assets/files/' . $soalessai['file'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio></p>';
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    endif;
                                                    ?>

                                                    <?= $soalessai['soal'] ?>

                                                    <?php
                                                    if ($soalessai['file1'] <> '') :
                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                        $ext = explode(".", $soalessai['file1']);
                                                        $ext = end($ext);
                                                        if (in_array($ext, $image)) {
                                                            echo '<p style="margin-bottom: 5px"><img src="' . base_url() . '/assets/files/' . $soalessai['file1'] . '" style="max-width: 200px;"/></p>';
                                                        } elseif (in_array($ext, $audio)) {
                                                            echo '<p style="margin-bottom: 5px"><audio controls><source src="' . base_url() . '/assets/files/' . $soalessai['file1'] . '" type="audio/$ext">Your browser does not support the audio tag.</audio></p>';
                                                        } else {
                                                            echo "File tidak didukung!";
                                                        }
                                                    endif;
                                                    ?>

                                                    <div>Kunci : <?= $soalessai['jawab_esai'] ?></div>
                                                </td>
                                                <td style='width:30px'>
                                                    <button class='btn bg-danger btn-sm delete-soal' data-href="/banksoal/deletesoal/<?= $soalessai['id_soal'] ?>"><i class='fas fa-trash-alt'></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection(); ?>