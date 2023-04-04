	<div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-green">
					<h5 class="modal-title" id="edit">Edit <?= $titlecontent ?></h5>
					<button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="margin: 0;"><i class="fas fa-times"></i></button>
				</div>
				<form action="/banksoal/edit/<?= $tampildata['idbsoal'] ?>" id="formupdate" class="formupdate" method="post">
					<?= csrf_field(); ?>
					<div class="modal-body">
						<div class="form-group">
							<label>Program Layanan</label>
							<input type="text" class="form-control form-control-sm" value="<?= $tampildata['jenjang'] . " " . $tampildata['idpk'] ?>" readonly>
						</div>
						<div class="form-group">
							<label>Tingkatan</label>
							<input type="text" class="form-control form-control-sm" value="<?= $tampildata['tingkatan'] ?>" readonly>
						</div>
						<div class="form-group">
							<label>Rombel</label><br>
							<input type="text" class="form-control form-control-sm" value="<?= $tampildata['rombel'] ?>" readonly>
						</div>
						<div class="form-group">
							<label>Mata Pelajaran</label>
							<input type="text" class="form-control form-control-sm" value="<?= $tampildata['nama'] ?>" readonly>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Jumlah Soal PG</label>
									<input type="number" id="soalpg" name="jml_soal" class="form-control form-control-sm" value="<?= ($tampildata['jml_soal'] != "") ? $tampildata['jml_soal'] : "" ?>" required />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Bobot Soal PG %</label>
									<input type="number" id="bobot_pg" name="bobot_pg" class="form-control form-control-sm" required value="<?= ($tampildata['bobot_pg'] != "") ? $tampildata['bobot_pg'] : ""; ?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Soal Tampil</label>
									<input type="number" id="tampilpg" name="tampil_pg" class="form-control form-control-sm" value="<?= ($tampildata['jml_soal'] != "") ? $tampildata['jml_soal'] : "" ?>" readonly required />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Opsi</label>
									<select id="opsi" name="opsi" class="form-select form-select-sm" data-placeholder="Opsi Jawaban" required>
										<option disabled selected></option>
										<?= ($tampildata['opsi'] == 3 | $tampildata['opsi'] == 4 | $tampildata['opsi'] == 5) ? $selected = " selected" : ""; ?>
										<option value="3" <?= ($tampildata['opsi'] == 3) ? "selected" : ""; ?>>3</option>
										<option value="4" <?= ($tampildata['opsi'] == 4) ? "selected" : ""; ?>>4</option>
										<option value="5" <?= ($tampildata['opsi'] == 5) ? "selected" : ""; ?>>5</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Jumlah Soal Essai</label>
									<input type="number" id="soalesai" name="jml_esai" class="form-control form-control-sm" value="<?= ($tampildata['jml_esai'] != "") ? $tampildata['jml_esai'] : ""; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Bobot Soal Essai %</label>
									<input type="number" id="bobot_esai" name="bobot_esai" class="form-control form-control-sm" value="<?= ($tampildata['bobot_esai'] != "") ? $tampildata['bobot_esai'] : ""; ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Soal Tampil</label>
									<input type="number" id="tampilesai" name="tampil_esai" class="form-control form-control-sm" value="<?= ($tampildata['tampil_esai'] != "") ? $tampildata['tampil_esai'] : ""; ?>" readonly />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Guru Pengampu</label>
									<select id="guru" name="guru" class="form-select form-select-sm" data-placeholder="Guru Pengampu" <?= (session()->get('level') == 2) ? "required" : "" ?>>
										<option disabled selected></option>
										<?php foreach ($tampilguru as $guru) : ?>
											<option value="<?= $guru['id_guru'] ?>" <?= ($tampildata['idguru'] == $guru['id_guru']) ? "selected" : "" ?>><?= strtoupper($guru['nama']); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Status Soal</label>
									<select id="status" name="status" class="form-select form-select-sm" data-placeholder="Status Soal" required>
										<option disabled selected></option>
										<option value="1" <?= ($tampildata['status'] == 1) ? "selected" : "" ?>>Aktif</option>
										<option value="0" <?= ($tampildata['status'] == 0) ? "selected" : "" ?>>Non Aktif</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="update" class="btn btn-sm btn-primary">Simpan</button>
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Keluar</button>
					</div>
				</form>
			</div>
		</div>
	</div>