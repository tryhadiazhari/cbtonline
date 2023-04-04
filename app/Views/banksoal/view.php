<?php
$db = \Config\Database::connect();
?>
<table id='example1' width='100%' class='table table-hover table-striped table-responsive nowrap' style="font-size: 10pt">
    <thead>
        <tr>
            <th width="2px" class="no-short" style="vertical-align: bottom">
                <div class="form-check form-check-inline">
                    <input type='checkbox' class='form-check-input' id='ceksemua'>
                </div>
            </th>
            <th width="18%" style='vertical-align: bottom'>Mata Pelajaran</th>
            <th width="17%">Soal PG</th>
            <th width="10%">Soal Essay</th>
            <th>Rombel/Tingkatan</th>
            <th>Guru</th>
            <th width="15%">Status/Total Soal</th>
            <th class='no-short' style="width: 12%;<?= (count($tampildata) == 0) ? ' display: none' : '' ?>"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($tampildata) > 0) : ?>
            <?php $no = 0;
            foreach ($tampildata as $tampil) : $no++; ?>
                <tr>
                    <td>
                        <div class="form-check form-check-inline">
                            <input type='checkbox' name='cekpilih[]' class='cekpilih form-check-input' id='cekpilih-<?= $no; ?>' value="<?= $tampil['idbsoal'] ?>">
                        </div>
                    </td>
                    <td>
                        <small class='label label-primary'><?= $tampil['alias']; ?></small>
                        <small class='label label-primary'><?= $tampil['tingkatan'] ?></small>
                        <small class='label label-primary'><?= $tampil['idpk'] ?></small>
                        <?= ($tampil['paket_soal'] == 'Utama') ? "<small class='label bg-primary'>" . $tampil['paket_soal'] . "</small>" : "<small class='label label-danger'>" . $tampil['paket_soal'] . "</small>" ?>
                    </td>
                    <td>
                        <small class='label label-success'><?= $tampil['jml_soal'] ?>/<?= $tampil['tampil_pg'] ?></small>
                        <small class='label label-success'><?= $tampil['bobot_pg'] ?> %</small>
                        <small class='label label-success'><?= $tampil['opsi'] ?> opsi</small>
                    </td>
                    <td>
                        <small class='label label-success'><?= $tampil['jml_esai'] ?>/<?= $tampil['tampil_esai'] ?></small>
                        <small class='label label-success'><?= $tampil['bobot_esai'] ?> %</small>
                    </td>
                    <td>
                        <small class='label label-success'><?= ($tampil['rombel'] == "") ? $tampil['tingkatan'] : $tampil['rombel'] . '/' . $tampil['tingkatan'] ?></small>
                    </td>
                    <td>
                        <?php if (session()->get('level') == 1) : ?>
                            <?php foreach ($tampilgtk as $gtk) : ?>
                                <?= ($tampil['idguru'] == $gtk['id_guru']) ? "<small class='label label-primary'>$gtk[nama]</small>" : "" ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <small class='label label-primary'><?= $tampil['nama'] ?></small>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($tampil['status'] == 1) : ?>
                            <?php $soal = $db->query("SELECT * FROM soal WHERE soal.tingkatan = '" . $tampil['tingkatan'] . "' And soal.idbsoal = '" . $tampil['idbsoal'] . "'")->getResult(); ?>
                            <label class="label label-success">Aktif</label>
                            <label class="label label-success"><?= count($soal) ?> Soal</label>
                        <?php else : ?>
                            <label class="label label-danger">Non Aktif</label>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class='btn-group'>
                            <div class="row">
                                <div class="col">
                                    <a href='/banksoal/view/<?= $tampil['idbsoal'] ?>' class='btn btn-success btn-xs'><i class='fa fa-search'></i></a>
                                    <a href='/banksoal/importsoal/<?= $tampil['idbsoal'] ?>' class='btn btn-info btn-xs'><i class='fa fa-upload'></i></a>
                                    <button class="btn btn-warning btn-xs banksoal-edit" data-toggle="modal" data-href="/banksoal" data-id="<?= $tampil['idbsoal'] ?>"><i class='fa fa-pencil-alt'></i></button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>