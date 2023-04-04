<!DOCTYPE html>
<html>

<head>
    <title> Print Soal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <style>
        @page {
            size: legal
        }

        * {
            margin: auto;
            line-height: 100%;
        }

        td {
            padding: 1px 3px 1px 3px;
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
    <!-- <div style='margin-bottom: 5px'>
        <img src="/assets/dist/img/header.png" class="" width="100%">
    </div> -->
    <section class="sheet padding-10mm">
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
            <div>
                <b>Soal Pilihan Ganda</b>
                <table width='100%'>
                    <tbody>
                        <?php foreach ($tampilsoalpg as $soalpg) : ?>
                            <tr>
                                <td width="1%" valign="top">
                                    <?= $soalpg['nomor'] . "." ?>
                                </td>

                                <td style="vertical-align: text-top;">
                                    Jawaban : <?= $soalpg['jawaban'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            Data tidak tersedia...
        <?php endif; ?>
    </section>
</body>

</html>