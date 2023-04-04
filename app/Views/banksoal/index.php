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
							<h4 class="card-header p-0 m-0" style="border: none"><?= $titlecontent ?></h4>
						</div>
						<div class="col-auto ms-auto">
							<button type="submit" class="btn btn-success btn-sm">
								<i class="fas fa-download"></i>
								<span class="d-none d-lg-inline">Import Data</span>
							</button>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
								<i class="fas fa-plus"></i>
								<span class="d-none d-lg-inline">Tambah</span>
							</button>
							<button id='btnhapusbank' data-href='/banksoal/deletebanksoal' class='btn btn-sm bg-green' style='margin-right: 5px'>
								<i class='fa fa-trash'></i>
								<span class="d-none d-lg-inline">Hapus</span>
							</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class='view'></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-green">
					<h5 class="modal-title" id="staticBackdropLabel">Tambah <?= $titlecontent ?></h5>
					<button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="margin: 0;"><i class="fas fa-times"></i></button>
				</div>
				<form action="/banksoal/save" id="formtambah" class="formtambah" method="post">
					<?= csrf_field(); ?>
					<div class="modal-body">
						<div class="form-group">
							<label>Program Layanan</label>
							<select name="id_pk" id="id_pk" class="select2 form-control" required>
								<option disabled selected></option>
								<?php foreach ($tampillayanan as $layanan) : ?>
									<option value="<?= $layanan['jurusan'] ?>" data-id="<?= $layanan['layanan'] ?>"><?= ($layanan['jurusan'] == "IPA" || $layanan['jurusan'] == "IPS" || $layanan['jurusan'] == "Bahasa") ? $layanan['layanan'] . " " . $layanan['jurusan'] : $layanan['layanan'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Tingkatan</label>
							<select name="level" id="soallevel" class="select2 form-control" data-placeholder="Tingkatan" required></select>
						</div>
						<div class="form-group">
							<label>Rombel</label><br>
							<select name="kelas" id="soalkelas" class="form-control select2" data-placeholder="Rombel" <?= (session()->get('level') == 2) ? "required" : "" ?>></select>
						</div>
						<div class="form-group">
							<label>Mata Pelajaran</label>
							<select name="mapel" id="nama" class="select2 form-control" data-placeholder="Mata Pelajaran" required></select>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Jumlah Soal PG</label>
									<input type="number" id="soalpg" name="jml_soal" class="form-control" required />
								</div>
								<div class="col-md-3">
									<label>Bobot Soal PG %</label>
									<input type="number" id="bobot_pg" name="bobot_pg" class="form-control" required />
								</div>
								<div class="col-md-3">
									<label>Soal Tampil</label>
									<input type="number" id="tampilpg" name="tampil_pg" class="form-control" readonly />
								</div>
								<div class="col-md-3">
									<label>Opsi</label>
									<select id="opsi" name="opsi" class="select2 form-control" data-placeholder="Opsi Jawaban" required>
										<option disabled selected></option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Jumlah Soal Essai</label>
									<input type="number" id="soalesai" name="jml_esai" class="form-control" />
								</div>
								<div class="col-md-4">
									<label>Bobot Soal Essai %</label>
									<input type="number" id="bobot_esai" name="bobot_esai" class="form-control" />
								</div>
								<div class="col-md-4">
									<label>Soal Tampil</label>
									<input type="number" id="tampilesai" name="tampil_esai" class="form-control" readonly />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Guru Pengampu</label>
									<select id="guru" name="guru" class="select2 form-control" data-placeholder="Guru Pengampu" <?= (session()->get('level') == 2) ? "required" : "" ?>>
										<option disabled selected></option>
										<?php foreach ($tampilguru as $guru) : ?>
											<option value="<?= $guru['id_guru'] ?>"><?= strtoupper($guru['nama']); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-6">
									<label>Status Soal</label>
									<select id="status" name="status" class="select2 form-control" data-placeholder="Status Soal" required>
										<option disabled selected></option>
										<option value="1">Aktif</option>
										<option value="0">Non Aktif</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group" <?= (session()->get('level') == 1) ? "" : 'style="display: none"' ?>>
							<div class="row">
								<div class="col">
									<label>Paket Soal</label>
									<select id="paketsoal" name="paketsoal" class="select2 form-control" data-placeholder="Paket Soal" required>
										<option disabled selected></option>
										<option value="Utama">Utama</option>
										<option value="Susulan">Susulan</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="save" name="tambahbanksoal" class="btn btn-sm btn-primary">Simpan</button>
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Keluar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

<div class='modalview'></div>

<?= $this->endSection(); ?>