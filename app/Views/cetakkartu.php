<?php
$this->db = \Config\Database::connect();

if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}

?>
<style>

</style>

<?php if ($pg == '') : ?>
    <div class="row">
        <div class="card">
            <div class="card-header px-3">
                <div class="row">
                    <div class="col-auto ms-auto">
                        <button class="btn-cetak btn btn-success btn-xs" onclick="frames['frameresult'].print()"><i class="fa fa-print"></i> <span class="d-none d-lg-inline">Cetak</span></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="printableArea" class="cetak page">
                    <table border='0' width='100%' align='center' cellpadding='6'>
                        <tr>
                            <?php $no = 0;
                            foreach ($datasiswa as $siswa) : $no++ ?>
                                <td width='50%' style='height: 200px'>
                                    <div style='width:10.4cm; border: 1px solid #666'>
                                        <table border='0' width='100%' align='center' class="table">
                                            <tr>
                                                <td align='center' style='width: 20%; padding-left: 0; padding-right: 0'>
                                                    <img src="/assets/dist/img/tutwuri.jpg" width="60px" style="padding: 2px 0" />
                                                </td>
                                                <td align='center' style='width: 60%; padding-left: 0; padding-right: 0'>
                                                    <b style='font-size: 12px'>KARTU UJIAN<br /><?= strtoupper($jenisujian['nama']) . "<br /> T.P. " . $ajaran ?></b>
                                                </td>
                                                <td style="width: 15%;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <hr style='margin-top: 0'>
                                        <table border='0' width='100%' align='center' style="font-size: 11pt; padding-left: 5px">
                                            <tr>
                                                <td valign='top' style='width: 32%' style="padding: 0">No. Peserta</td>
                                                <td valign="top" style="width: 1%; padding: 0">:</td>
                                                <td valign='top' style='text-transform: capitalize; padding: 0' colspan="2"><?= $siswa['no_peserta']; ?></td>
                                            </tr>
                                            <tr>
                                                <td valign='top' style='width: 32%; padding: 3px 0'>Nama Peserta</td>
                                                <td valign='top' style="padding: 3px 0">:</td>
                                                <td valign='top' style='text-transform: uppercase; padding: 3px 0' colspan="3"><?= strtolower($siswa['nama']); ?></td>
                                            </tr>
                                            <tr>
                                                <td valign='top' style='padding: 3px 0 7px'>Username</td>
                                                <td valign='top' style="padding: 3px 0 7px">:</td>
                                                <td valign='top' style='padding: 3px 0 7px' colspan='3'><b><?= $siswa['uname']; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td valign='top' style="line-height: 0; padding: 7px 0 5px">Password</td>
                                                <td valign='top' style="line-height: 0; padding: 7px 0 5px">:</td>
                                                <td valign='top' style="line-height: 0; padding: 7px 0 5px"><b><?= $siswa['pword']; ?></b></td>
                                                <td rowspan="3" align='right' style="padding: 0 5px 5px">
                                                    <img src="/assets/uploads/qrcode/<?= $siswa['npsn'] . '_' . str_replace(" ", "_", $siswa['nama']) . '.png' ?>" width="100px" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign='top' style="line-height: 0; padding: 5px 0 3px">Satuan Pendidikan</td>
                                                <td valign='top' style="line-height: 0; padding: 5px 0 3px">:</td>
                                                <td valign='top' style="line-height: 0; padding: 5px 0 3px"><?= $lembaga['sp'] ?></td>
                                            </tr>
                                            <tr>
                                                <td valign='top' style="padding: 5px 0">ID SERVER</td>
                                                <td valign='top' style="padding: 5px 0">:</td>
                                                <td valign='top' style="padding: 5px 0"><?= $server['kode_server'] ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php if (($no % 8) == 0) { ?>
                                        <div style='page-break-before:always;'></div>
                                    <?php } ?>
                                </td>
                                <td style='margin: 0'>&nbsp;</td>
                                <?php if (($no % 2) == 0) {
                                    echo "</tr><tr>";
                                } ?>
                            <?php endforeach ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <iframe id='loadkartu' name='frameresult' src='/kartuujian/cetak/<?= $rombel ?>/<?= $tingkatan ?>' style='border:none;width:0px;height:0px;'></iframe>

<?php else : ?>
    <div id="printableArea" class="cetak page">
        <table border='0' width='100%' align='center' cellpadding='6'>
            <tr>
                <?php $no = 0;
                foreach ($datasiswa as $siswa) : $no++ ?>
                    <td width='50%' style='height: 200px'>
                        <div style='width:10.4cm; border: 1px solid #666'>
                            <table border='0' width='100%' align='center' class="table" style="padding: 3px 0">
                                <tr>
                                    <td align='center' style='width: 20%; padding-left: 0; padding-right: 0'>
                                        <img src="/assets/dist/img/tutwuri.jpg" width="60px" style="padding: 2px 0" />
                                    </td>
                                    <td align='center' style='width: 60%; padding-left: 0; padding-right: 0'>
                                        <b style='font-size: 12px'>KARTU UJIAN<br /><?= strtoupper($jenisujian['nama']) . "<br /> T.P. " . $ajaran ?></b>
                                    </td>
                                    <td style="width: 20%;">&nbsp;</td>
                                </tr>
                            </table>
                            <hr style='margin-top: 0'>
                            <table border='0' width='100%' align='center' style="font-size: 11pt; padding-left: 5px">
                                <tr>
                                    <td valign='top' style='width: 32%' style="padding: 0">No. Peserta</td>
                                    <td valign="top" style="width: 1%; padding: 0">:</td>
                                    <td valign='top' style='text-transform: capitalize; padding: 0' colspan="2"><?= $siswa['no_peserta']; ?></td>
                                </tr>
                                <tr>
                                    <td valign='top' style='width: 32%; padding: 3px 0'>Nama Peserta</td>
                                    <td valign='top' style="padding: 3px 0">:</td>
                                    <td valign='top' style='text-transform: uppercase; padding: 3px 0' colspan="3"><?= strtolower($siswa['nama']); ?></td>
                                </tr>
                                <tr>
                                    <td valign='top' style='padding: 3px 0 7px'>Username</td>
                                    <td valign='top' style="padding: 3px 0 7px">:</td>
                                    <td valign='top' style='padding: 3px 0 7px' colspan='3'><b><?= $siswa['uname']; ?></b></td>
                                </tr>
                                <tr>
                                    <td valign='top' style="line-height: 0; padding: 7px 0 5px">Password</td>
                                    <td valign='top' style="line-height: 0; padding: 7px 0 5px">:</td>
                                    <td valign='top' style="line-height: 0; padding: 7px 0 5px"><b><?= $siswa['pword']; ?></b></td>
                                    <td rowspan="3" align='right' style="padding: 0 5px 5px">
                                        <img src="/assets/uploads/qrcode/<?= $siswa['npsn'] . '_' . str_replace(" ", "_", $siswa['nama']) . '.png' ?>" width="100px" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign='top' style="line-height: 0; padding: 5px 0 3px">Satuan Pendidikan</td>
                                    <td valign='top' style="line-height: 0; padding: 5px 0 3px">:</td>
                                    <td valign='top' style="line-height: 0; padding: 5px 0 3px"><?= $lembaga['sp'] ?></td>
                                </tr>
                                <tr>
                                    <td valign='top' style="padding: 4px 0">ID SERVER</td>
                                    <td valign='top' style="padding: 4px 0">:</td>
                                    <td valign='top' style="padding: 4px 0"><?= $server['kode_server'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php if (($no % 8) == 0) { ?>
                            <div style='page-break-before:always;'></div>
                        <?php } ?>
                    </td>
                    <td style='margin: 0'>&nbsp;</td>
                    <?php if (($no % 2) == 0) {
                        echo "</tr><tr>";
                    } ?>
                <?php endforeach ?>
            </tr>
        </table>
    </div>
<?php endif ?>