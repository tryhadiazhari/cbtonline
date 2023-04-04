<?php
$db = \Config\Database::connect();

$provinsi = $db->query("SELECT wilayah_kecamatan.nama, wilayah_kabupaten.nama As kabupaten, wilayah_provinsi.nama As provinsi 
                FROM wilayah_kabupaten 
                    Inner Join wilayah_kecamatan On wilayah_kecamatan.kabupaten_id = wilayah_kabupaten.id 
                    Inner Join wilayah_provinsi On wilayah_kabupaten.provinsi_id = wilayah_provinsi.id 
                        WHERE wilayah_kecamatan.nama = '" . $tampildata->kecamatan . "'")->getRow();
?>
<div class="modal fade" id="detailview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="detailviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-outline card-primary mb-0">
                        <div class="row g-0">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailviewLabel">Detail Peserta Didik</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-3 px-0">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="<?= ($tampildata->foto == 0) ? "/assets/dist/img/avatar_default.png" : "'data:image/jpeg; base64, ' . base64_encode($tampildata->foto)" ?>" alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center"><?= $tampildata->nama ?></h3>
                                    <p class="text-muted text-center"><?= $tampildata->tingkatan . ' | ' . $tampildata->rombel . " | " . $tampildata->lembaga ?></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="card card-primary card-outline card-outline-tabs">
                                            <div class="card-header p-0 border-bottom-0">
                                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                    <li class="nav-item ">
                                                        <a class="nav-link active" id="custom-tabs-profile-tab" data-toggle="pill" href="#custom-tabs-profile" role="tab" aria-controls="custom-tabs-profile" aria-selected="false">Data Pribadi</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-ortu-tab" data-toggle="pill" href="#custom-tabs-ortu" role="tab" aria-controls="custom-tabs-ortu" aria-selected="false">Data Orang Tua</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-contacts-tab" data-toggle="pill" href="#custom-tabs-contacts" role="tab" aria-controls="custom-tabs-contacts" aria-selected="false">Kontak</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-tabs-profile" role="tabpanel" aria-labelledby="custom-tabs-profile-tab">
                                                        <table width="100%" class="table table-borderless table-sm mb-0">
                                                            <tr>
                                                                <td style="width: 32%"><label>Nama</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->nama ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Jenis Kelamin</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= ($tampildata->jk == "L") ? "Laki-laki" : "Perempuan" ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>NISN</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->nisn ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Kewarganegaraan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->warganegara ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>NIK</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->nik ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Tempat, Tanggal Lahir</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->tempat_lahir . ", " . $tampildata->tanggal_lahir ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Agama</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->agama ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Alamat</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?php
                                                                    if ($tampildata->kode_pos != 0) {
                                                                        echo $tampildata->alamat . ", " . $tampildata->kelurahan . ", " . $tampildata->kecamatan . ", " . $provinsi->kabupaten . ", " . $tampildata->kode_pos . ", " . $provinsi->provinsi;
                                                                    } else {
                                                                        echo $tampildata->alamat . ", " . $tampildata->kelurahan . ", " . $tampildata->kecamatan . ", " . $provinsi->kabupaten . ", " . $provinsi->provinsi;
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>RT / RW</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->rt . " / " . $tampildata->rw ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Dusun</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->dusun ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Tempat Tinggal</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->jenis_tinggal ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Transportasi</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <?= $tampildata->alat_transportasi ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-ortu" role="tabpanel" aria-labelledby="custom-tabs-ortu-tab">
                                                        <table width="100%" class="table table-borderless table-sm mb-0">
                                                            <tr>
                                                                <td style="width: 32%"><label>Nama Ayah / Ibu</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col"><?= $tampildata->nama_ayah ?></div>
                                                                        <div class="col-1">|</div>
                                                                        <div class="col"><?= $tampildata->nama_ibu ?></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Tahun Lahir</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col"><?= $tampildata->tahun_ayah ?></div>
                                                                        <div class="col-1">|</div>
                                                                        <div class="col"><?= $tampildata->tahun_ibu ?></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Pendidikan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col"><?= $tampildata->pendidikan_ayah ?></div>
                                                                        <div class="col-1">|</div>
                                                                        <div class="col"><?= $tampildata->pendidikan_ibu ?></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Pekerjaan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col"><?= $tampildata->pekerjaan_ayah ?></div>
                                                                        <div class="col-1">|</div>
                                                                        <div class="col"><?= $tampildata->pekerjaan_ibu ?></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Penghasilan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col"><?= $tampildata->penghasilan_ayah ?></div>
                                                                        <div class="col-1">|</div>
                                                                        <div class="col"><?= $tampildata->penghasilan_ibu ?></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <hr />
                                                        <table width="100%" class="table table-borderless table-sm mb-0">
                                                            <tr>
                                                                <td style="width: 32%"><label>Nama Wali</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->nama_wali ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Tahun Lahir</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->tahun_wali ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Pendidikan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->pendidikan_wali ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Pekerjaan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->pekerjaan_wali ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 32%"><label>Penghasilan</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->penghasilan_wali ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-contacts" role="tabpanel" aria-labelledby="custom-tabs-contacts-tab">
                                                        <table width="100%" class="table table-borderless table-sm mb-0">
                                                            <tr>
                                                                <td style="width: 32%"><label>No. Telp. Rumah</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->telepon ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label>No. HP</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->hp ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label>Email Aktif</small></td>
                                                                <td style="width: 1%">:</td>
                                                                <td><?= $tampildata->email ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>