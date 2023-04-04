<table id="tablepd" class="table table-hover table-stripped table-responsive nowrap">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th width="25%">Nama</th>
            <th width="1%">JK</th>
            <th>NISN</th>
            <th>Tingkatan/Rombel</th>
            <th>Tempat Lahir</th>
            <th>Tgl Lahir</th>
            <th>No Peserta</th>
            <th>Username</th>
            <th>Password</th>
            <th class="no-short" <?= (count($tampildata) == 0) ? "hidden" : "" ?>></th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($tampildata as $v) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $v->nama ?></td>
                <td><?= $v->jk ?></td>
                <td><?= $v->nisn ?></td>
                <td><?= ($v->tingkatan == "" && $v->rombel == "") ? "" : $v->tingkatan . "/" . $v->rombel ?></td>
                <td><?= $v->tempat_lahir ?></td>
                <td><?= $v->tanggal_lahir ?></td>
                <td><?= $v->no_peserta ?></td>
                <td><?= $v->username ?></td>
                <td><?= $v->password ?></td>
                <td align="center">
                    <button class="btn btn-xs btn-info detail" data-link="/pd/detail" data-id="<?= $v->id_siswa ?>"><i class="fas fa-search fa-sm"></i></button>
                    <button class="btn btn-xs btn-secondary" onClick="window.location='/pd/edit/<?= urlencode(base64_encode($v->id_siswa)) ?>'"><i class=" fas fa-pencil fa-sm"></i></button>
                    <button class="btn btn-danger btn-xs btn-delete" data-href="/pd/delete/<?= $v->id_siswa ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>