<!DOCTYPE html>
<html>

<head>
    <title> Print Soal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <style>
        * {
            margin: auto;
            line-height: 100%;
        }

        td {
            padding: 1px 3px 1px 3px;
        }

        @page {
            size: legal
        }

        body {
            margin: 0
        }

        .sheet {
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm
        }

        body.A4.landscape .sheet {
            width: 297mm;
            height: 209mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        body.letter .sheet {
            width: 216mm;
            height: 279mm
        }

        body.letter.landscape .sheet {
            width: 280mm;
            height: 215mm
        }

        body.legal .sheet {
            width: 216mm;
            height: 356mm
        }

        body.legal.landscape .sheet {
            width: 357mm;
            height: 215mm
        }

        /** Padding area **/
        .sheet.padding-10mm {
            padding: 10mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
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
                width: 216mm
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

        <table width='100%'>
            <tr>
                <td>Mata Pelajaran </td>
                <td>: <?= $tampildata['nama'] ?></td>
                <td>Hari / Tanggal Ujian</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Kelas / Tingkat </td>
                <td>: <?= $tampildata['rombel'] . " / " . $tampildata['tingkatan'] ?></td>
                <td>Jumlah Soal</td>
                <td>: <?= count($tampilsoal) ?> Soal</td>
            </tr>
            <tr>
                <td>Guru Mata Pelajaran</td>
                <td>: <?= ucwords(strtolower($tampilguru['nama'])) ?></td>
                <td>Satuan Pendidikan</td>
                <td>: </td>
            </tr>
        </table>

        <div class='garis'></div>
        <br />

        <?php if (count($tampilsoalpg) > 0) : ?>
            <div style="page-break-after: always;">
                <b>Soal Pilihan Ganda</b>
                <table width='100%'>
                    <tbody>
                        <?php foreach ($tampilsoalpg as $soalpg) : ?>
                            <tr>
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
                                            <td style="width: 30%; vertical-align: text-top;">
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
                                                <td style="width: 30%; vertical-align: text-top;">
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
                                            <td style="width: 30%; vertical-align: text-top;">
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
                                                <td style="width: 30%; vertical-align: text-top;">
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
                                            <td style="width: 30%; vertical-align: text-top;">
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
                <b>Soal Essai</b>
                <table width='100%' style="margin-top: 5px">
                    <tbody>
                        <?php foreach ($tampilsoalessai as $soalessai) : ?>
                            <tr>
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