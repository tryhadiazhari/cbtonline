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
    <!-- <div style='margin-bottom: 5px'>
        <img src="/assets/dist/img/header.png" class="" width="100%">
    </div> -->
    <section class="sheet padding-10mm">
        <h4 style="text-decoration: underline; margin-bottom: 20px">
            Kunci Jawaban
            <?php
            if ($tampilsoal[0]['kode_soal'] == 'PAI') {
                echo "Pendidikan Agama Islam";
            } elseif ($tampilsoal[0]['kode_soal'] == 'PAK') {
                echo "Pendidikan Agama Kristen";
            } else {
                echo $tampildata['nama'];
            }
            ?>
            -
            <?php
            if ($tampildata['tingkatan'] == "Tingkatan 5" || $tampildata['tingkatan'] == "Tingkatan 6") {
                echo "Paket C";
            } elseif ($tampildata['tingkatan'] == "Tingkatan 3" || $tampildata['tingkatan'] == "Tingkatan 4") {
                echo "Paket B";
            } else {
                echo "Paket A";
            }
            ?>
        </h4>

        <?php if (count($tampilsoalpg) > 0) : ?>
            <div>
                <b>Soal Pilihan Ganda</b>
                <table width='100%'>
                    <tbody>
                        <tr>
                            <td width="1%" valign="top">
                                <?php for ($i = 0; $i < 20; $i++) : ?>
                                    <div><?= $tampilsoalpg[$i]['nomor']++ . ". " . $tampilsoalpg[$i]['jawaban'] ?></div>
                                <?php endfor ?>
                            </td>
                            <td width="1%" valign="top">
                                <?php for ($ii = 20; $ii < count($tampilsoalpg); $ii++) : ?>
                                    <div><?= $tampilsoalpg[$ii]['nomor']++ . ". " . $tampilsoalpg[$ii]['jawaban'] ?></div>
                                <?php endfor ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            Data tidak tersedia...
        <?php endif; ?>

        <?php if (count($tampilsoalessai) > 0) : ?>
            <div style="margin-top: 20px;">
                <b>Soal Uraian</b>
                <table width='100%'>
                    <tbody>
                        <?php foreach ($tampilsoalessai as $soalessai) : ?>
                            <tr>
                                <td width="1%" valign="top">
                                    <?= $soalessai['nomor'] . "." ?>
                                </td>

                                <td style="vertical-align: text-top;">
                                    <?php
                                    if ($soalessai['jawab_esai'] == "") {
                                        if ($soalessai['jawaban'] == "A") {
                                            echo $soalessai['pilA'];
                                        } else if ($soalessai['jawaban'] == "B") {
                                            echo $soalessai['pilB'];
                                        } else if ($soalessai['jawaban'] == "C") {
                                            echo $soalessai['pilC'];
                                        } else if ($soalessai['jawaban'] == "D") {
                                            echo $soalessai['pilD'];
                                        } else if ($soalessai['jawaban'] == "E") {
                                            echo $soalessai['pilE'];
                                        }
                                    } else {
                                        echo $soalessai['jawab_esai'];
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </section>
</body>

</html>