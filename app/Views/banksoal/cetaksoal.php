<!DOCTYPE html>
<html>

<head>
    <title> Print Soal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <style>
        * {
            margin: 0 0 2px 0;
            padding: 0 0 2px 0;
            line-height: normal;
        }

        @page {
            size: legal;
            margin: 1cm 1cm 1cm 1.5cm;
        }

        body {
            margin: 0;
        }

        .sheet {
            margin: 0;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            * {
                margin: 0 0 2px 0;
                padding: 0 0 2px 0;
                line-height: normal;
                font-size: 14pt;
            }

            tr.break {
                page-break-inside: avoid;
                page-break-after: auto
            }

            body.A3.landscape {
                width: 420mm
            }

            body.A3,
            body.A4.landscape {
                width: 297mm
            }

            body.A4,
            body.A5.landscape {
                width: 210mm
            }

            body.A5 {
                width: 148mm
            }

            body.letter,
            body.legal {
                width: 215mm;
                height: 330mm;
            }

            body.letter.landscape {
                width: 280mm
            }

            body.legal.landscape {
                width: 357mm
            }
        }
    </style>
    <style>
        .garis {
            border: 1px solid #000;
            border-left: 0px;
            border-right: 0px;
            padding: 1px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body class="legal">
    <section class="sheet padding-10mm">
        <!-- <div style='margin-bottom: 5px'>
        <img src="/assets/dist/img/header.png" class="" width="100%">
    </div> -->

        <table width='100%' style="font-size: 14pt">
            <tr>
                <td width="20%" style="padding: 5px 0">Mata Pelajaran </td>
                <td width="35%" style="padding: 5px 0">:
                    <?php
                    if ($tampilsoal[0]['kode_soal'] == 'PAI') {
                        echo "Pendidikan Agama Islam";
                    } elseif ($tampilsoal[0]['kode_soal'] == 'PAK') {
                        echo "Pendidikan Agama Kristen";
                    } else {
                        echo $tampildata['nama'];
                    }
                    ?>
                </td>
                <td width="20%" style="padding: 5px 0">Hari / Tanggal Ujian</td>
                <td width="35%" style="padding: 5px 0">: </td>
            </tr>
            <tr>
                <td style="padding: 5px 0">Kelas / Tingkat </td>
                <td>: </td>
                <td>Jumlah Soal</td>
                <td>: <?= count($tampilsoal) ?> Soal</td>
            </tr>
            <tr>
                <td style="padding: 5px 0">Guru Mata Pelajaran</td>
                <td>: </td>
                <td>Satuan Pendidikan</td>
                <td>: </td>
            </tr>
        </table>

        <div class='garis'></div>
        <br />

        <?php if (count($tampilsoalpg) > 0) : ?>
            <div>
                <b>Soal Pilihan Ganda</b>
                <table width='100%'>
                    <tbody>
                        <?php foreach ($tampilsoalpg as $soalpg) : ?>
                            <tr class="break">
                                <td width="1%" valign="top">
                                    <?= $soalpg['nomor'] . "." ?>
                                </td>
                                <td valign='top'>
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

                                    <table width="100%" style="margin-bottom: 2px;">
                                        <tr>
                                            <td style="width: 1%; vertical-align: text-top;">A.</td>
                                            <td style="width: 35%; vertical-align: text-top;">
                                                <?php
                                                if ($soalpg['pilA'] <> '') {
                                                    echo $soalpg['pilA'];
                                                }
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
                                            <?php if ($tampildata['opsi'] <> 3) : ?>
                                                <td style="width: 1%; vertical-align: text-top;">D.</td>
                                                <td style="width: 35%; vertical-align: text-top;">
                                                    <?php
                                                    if (!$soalpg['pilD'] == "") {
                                                        echo $soalpg['pilD'];
                                                    }
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
                                            <td style="width: 1%; vertical-align: text-top;">B.</td>
                                            <td style="width: 35%; vertical-align: text-top;">
                                                <?php
                                                if (!$soalpg['pilB'] == "") {
                                                    echo $soalpg['pilB'];
                                                }
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
                                            <?php if ($tampildata['opsi'] == 5) : ?>
                                                <td style="width: 1%; vertical-align: text-top;">E.</td>
                                                <td style="width: 35%; vertical-align: text-top;">
                                                    <?php
                                                    if (!$soalpg['pilE'] == "") {
                                                        echo $soalpg['pilE'];
                                                    }
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
                                            <td style="width: 1%; vertical-align: text-top;">C.</td>
                                            <td style="width: 35%; vertical-align: text-top;">
                                                <?php
                                                if (!$soalpg['pilC'] == "") {
                                                    echo $soalpg['pilC'];
                                                }
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
                                        </tr>
                                    </table>
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
            <div style="margin-top: 20px;">
                <b>Soal Uraian</b>
                <table width='100%' style="margin-top: 5px">
                    <tbody>
                        <?php foreach ($tampilsoalessai as $soalessai) : ?>
                            <tr class="break">
                                <td width="1%" valign="top" style="padding-bottom: 10px;">
                                    <?= $soalessai['nomor'] . "." ?>
                                </td>
                                <td valign='top'>
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
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</body>

</html>