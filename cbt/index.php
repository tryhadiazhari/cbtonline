<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");

(!isset($_SESSION['id_siswa'])) ? header("Location: $homeurl/login") : $id_siswa = $_SESSION['id_siswa'];

$jenis = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_jenis_ujian WHERE status = 'aktif'"));

$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_siswa WHERE uid_siswa='$id_siswa'"));
$idsesi = $siswa['sesi'];

$rombel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_rombel WHERE npsn = '" . $siswa['npsn'] . "' AND tingkatan = '" . $siswa['tingkatan'] . "' AND nama = '" . $siswa['rombel'] . "'"));

$tglsekarang = time();
$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_rombel WHERE npsn = '" . $siswa['npsn'] . "' AND tingkatan = '" . $siswa['tingkatan'] . "' AND nama = '" . $siswa['rombel'] . "'"));

$namamapel = fetch('hazedu_jadwal', array(
	'uid_banksoal' => $_SESSION['uid_banksoal'],
	'uid_jadwal' => $_SESSION['uid_jadwal'],
));

$jmlpg = $namamapel['jml_pg'];
$jmlesai = $namamapel['jml_esai'];

$jmlsoalall = $jmlpg + $jmlesai;

$nilai = fetch('hazedu_nilai', array(
	'npsn' => $siswa['npsn'],
	'uid_jadwal' => $namamapel['uid_jadwal'],
	'uid_banksoal' => $namamapel['uid_banksoal'],
	'uid_siswa' => $siswa['uid_siswa'],
));

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />
	<title>HAz CBT Online</title>
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/dist/css/adminlte.min.css" />
	<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css" />
	<link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/plugins/iCheck/square/green.css" />
	<link rel="stylesheet" href="/plugins/animate/animate.min.css">
	<link rel='stylesheet' href='/plugins/sweetalert2/sweetalert2.min.css'>
	<link rel="stylesheet" href="/plugins/slidemenu/jquery-slide-menu.css">
	<link rel="stylesheet" href="/plugins/radio/css/style.css">
	<style>
		.card-primary:not(.card-outline)>.card-header {
			background-color: #007bff;
		}

		.card-primary:not(.card-outline)>.card-header,
		.card-primary:not(.card-outline)>.card-header a {
			color: #fff;
		}

		.card-primary:not(.card-outline)>.card-header a.active {
			color: #1f2d3d;
		}

		.card-primary.card-outline {
			border-top: 3px solid #007bff;
		}

		.card-primary.card-outline-tabs>.card-header a:hover {
			border-top: 3px solid #dee2e6;
		}

		.card-primary.card-outline-tabs>.card-header a.active {
			border-top: 3px solid #007bff;
		}

		.bg-gradient-primary .btn-tool,
		.bg-primary .btn-tool,
		.card-primary:not(.card-outline) .btn-tool {
			color: rgba(255, 255, 255, 0.8);
		}

		.bg-gradient-primary .btn-tool:hover,
		.bg-primary .btn-tool:hover,
		.card-primary:not(.card-outline) .btn-tool:hover {
			color: #fff;
		}

		.soal img {
			max-width: 100%;
			height: auto;
		}

		.callout {
			border-left: 0px;
		}

		#canvasDiv {
			position: relative;
			border: 1px dashed grey;
			height: 200px;
		}

		@media (min-width: 320px) and (max-width: 425px) {
			#canvasDiv {
				max-height: 1000% !important;
			}
		}
	</style>
</head>

<body class='hold-transition skin-blue-light fixed'>
	<span id='livetime'></span>

	<header class="masthead" style="padding-top: 20px">
		<nav class="navbar navbar-expand-lg py-0">
			<div class="container-fluid">
				<img src="/dist/img/logo.png" class="mx-2 d-block d-lg-none">
				<img src="/dist/img/logo.png" class="d-none d-lg-block mx-2">

				<img src="/dist/img/avatar_default.png" class="mx-2 px-0 py-0 navbar-toggler img-thumbnail rounded float-end img-fluid" width="60" onclick="window.location='/logout'">

				<div class="collapse navbar-collapse justify-content-end mx-2" id="navbarScroll">
					<div class="d-flex">
						<span class="" style='color: #fff; margin-right: 10px'>
							<b><?= $siswa['nama'] ?></b><br>
							<div class="d-grid gap-2">
								<button class='btn btn-light btn-block rounded-pill' onclick='location.href="/logout"'>Keluar</button>
							</div>
						</span>
						<img src="/dist/img/avatar_default.png" class="img-responsive img-rounded img-thumbnail hidden-xs" width="60px" style="margin: 0" alt="">
					</div>
				</div>

			</div>
		</nav>
	</header>

	<div class="limiter">
		<div class="container-konfirmasi pt-0">
			<?php if ($pg == '') : ?>
				<div class="animated wrap-konfirmasi">
					<div class="box-header without-border">
						<h2 class="box-title">Konfirmasi Data Peserta</h2>
					</div>
					<div class="box-body py-0">
						<div class="pesan"></div>
						<div class="form-konfirmasi-peserta">
							<form action="#" method="post" class="konfirm-peserta" autocomplete="off">
								<ul class="list-group list-group-flush">
									<li class="list-group-item nisn mb-2">
										<div class="fw-bold row">NISN</div>
										<span class="list-nisn row"></span>
									</li>
									<li class="list-group-item nama-peserta mb-2">
										<div class="fw-bold row">Nama Peserta</div>
										<span class="list-nama row"></span>
									</li>
									<li class="list-group-item agama mb-2">
										<div class="fw-bold row">Agama</div>
										<span class="list-agama row"></span>
									</li>
									<li class="list-group-item tempatlahir mb-2">
										<div class="fw-bold row">Tempat Lahir</div>
										<span class="list-tempatlahir row"></span>
									</li>
									<li class="list-group-item tgllahir mb-2">
										<div class="fw-bold row">Tanggal Lahir</div>
										<span class="list-tgllahir row"></span>
									</li>
									<li class="list-group-item jk mb-2">
										<div class="fw-bold row">Jenis Kelamin</div>
										<span class="list-jk row"></span>
									</li>
								</ul>
								<div class="container-login100-form-btn mt-2">
									<div class="wrap-login100-form-btn">
										<div class="login100-form-bgbtn"></div>
										<button type="submit" id="konfirmasi" name="konfirmasi" class="login100-form-btn">Konfirmasi</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

			<?php elseif ($pg == "absensi") : ?>
				<div class="animated wrap-konfirmasi">
					<div class="box-header without-border">
						<h2 class="box-title">Konfirmasi Daftar Hadir</h2>
					</div>
					<div class="box-body">
						<div class="pesan"></div>
						<div class="col">
							<b>Tanda Tangan</b><br />
							<div id="canvasDiv" class="col"></div>
							<br>
							<button type="button" class="btn btn-success" id="btn-save" name="savesign">Simpan</button>
							<button type="button" class="btn btn-danger" id="reset-btn">Hapus</button>
						</div>
						<form id="signatureform" action="#" style="display: none" method="post">
							<input type="hidden" id="signature" name="signature">
							<input type="hidden" name="signaturesubmit" value="1">
						</form>
					</div>
				</div>

			<?php elseif ($pg == "konfirmasi") : ?>
				<div class="animated wrap-konfirmasi">
					<div class="box-header without-border">
						<h2 class="box-title">Konfirmasi Ujian</h2>
					</div>
					<div class="box-body">
						<div class="pesan"></div>
						<div class="form-konfirmasi-ujian">
							<ul class="list-group list-group-flush">
								<li class="list-group-item mb-2">
									<div class="fw-bold row">Nama Ujian</div>
									<span class="list-jenisujian row"></span>
								</li>
								<li class="list-group-item mb-2">
									<div class="fw-bold row">
										Status Ujian
										<div class="list-status px-0"></div>
									</div>
								</li>
								<li class="list-group-item mb-2">
									<div class="fw-bold row">Mata Pelajaran</div>
									<span class="list-mapel row"></span>
								</li>
								<li class="list-group-item mb-2">
									<div class="fw-bold row">Alokasi Waktu</div>
									<span class="list-durasi row"></span>
								</li>
								<li class="list-group-item mb-2">
									<div class="fw-bold row">Jumlah Soal</div>
									<span class="list-jmlsoal row"></span>
								</li>
								<li class="list-group-item list-group-token mb-2" style="display: none">
									<div class="fw-bold row">Token</div>
									<div class="list-token row">
										<input type='text' id="token" class='form-control rounded-3' name="token" placeholder="Masukan token" autofocus>
									</div>
								</li>
							</ul>
							<div class=" container-login100-form-btn mt-2">
								<div class="wrap-login100-form-btn">
									<div class="login100-form-bgbtn"></div>
									<button type="submit" id="mulai" name="" class="login100-form-btn<?php echo $hidden ?>" <?php echo $disabled ?>>Mulai</button>
								</div>
							</div>
						</div>
					</div>
				</div>

			<?php elseif ($pg == 'testongoing') : ?>
				<div class="animated wrap-soal py-0">
					<div class="box-solid">
						<div class="box-header py-3">
							<div id="divujian">
								<span style="display:none" id="htmlujianselesai"><?= $ujianselesai ?></span>
								<input type="hidden" name="urls" id="urls" value="<?= $_SERVER['REQUEST_URI'] ?>">
								<input type="hidden" id="idsiswa" value="<?= $id_siswa ?>">
								<input type="hidden" id="idmapel" value="<?= $_SESSION['uid_banksoal'] ?>">
								<input type="hidden" id="idujian" value="<?= $_SESSION['uid_jadwal'] ?>">
								<input type="hidden" id="numsoal">
							</div>
							<div class="row px-0">
								<div class="col">
									<div class="row">
										<div class="col-auto px-0 mx-0 d-none d-sm-block">
											<span class="btn bg-body fw-bold">NOMOR SOAL</span>
										</div>
										<div class="col">
											<span class="btn bg-blue" id="displaynum"></span>
											<div class="btn-group">
												<button type="button" id="smaller_font" class="btn bg-purple"> - </button>

												<button type="button" id="reset_font" class="btn bg-purple">
													<i class="fa fa-redo"></i>
												</button>

												<button type="button" id="bigger_font" class="btn bg-purple"> + </button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-auto ms-auto px-0">
									<span class="btn bg-body" id="countdown"></span>
								</div>
							</div>
						</div>
					</div>
					<div id="loadsoal">
						<div class="box-body mx-2 px-0">
							<div class="col-12">
								<div class="soal"></div>
								<div class="col-md-12" id="file-audio"></div>
							</div>

							<div class="col-12" id="opsi">
								<div class="list-group">
									<?php for ($i = 1; $i <= $namamapel['opsi']; $i++) : ?>
										<?php
										$array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];

										$no_soal = ($pageurl[3] == 1) ? 0 - 1 : $pageurl[3];
										$no_prev = $no_soal - 1;
										$no_next = ($pageurl[3] <= 1) ? 0 : $pageurl[3] - 1;

										$pengacakpil = fetch('pengacakopsi', array(
											'npsn' => $siswa['npsn'],
											'uid_banksoal' => $namamapel['uid_banksoal'],
											'uid_jadwal' => $namamapel['uid_jadwal'],
											'uid_siswa' => $siswa['uid_siswa'],
										));

										$pengacakpil2 = explode(',', $pengacakpil['opsi']);

										$nop1 = $no_next * $namamapel['opsi'];
										$pil1 = $pengacakpil2[$nop1];

										$nop2 = $no_next * $namamapel['opsi'] + 1;
										$pil2 = $pengacakpil2[$nop2];

										$nop3 = $no_next * $namamapel['opsi'] + 2;
										$pil3 = $pengacakpil2[$nop3];

										$nop4 = $no_next * $namamapel['opsi'] + 3;
										$pil4 = $pengacakpil2[$nop4];

										$nop5 = $no_next * $namamapel['opsi'] + 4;
										$pil5 = $pengacakpil2[$nop5];

										$nom = [1 => $pil1, 2 => $pil2, 3 => $pil3, 4 => $pil4, 5 => $pil5];
										?>
										<label class="list-group-item border-0">
											<div class="row">
												<div class="col-auto px-0">
													<input type="radio" class="hidden btn-check" name="jawab" id="<?= $array[$i]; ?>" value="<?= $nom[$i] ?>">
													<label class="button-label" for="<?= $array[$i]; ?>">
														<h1><?= $array[$i]; ?></h1>
													</label>
												</div>
												<div class="col" style="text-align: justify">
													<span id="jawaban<?= $array[$i]; ?>" class="opsijawab"></span>
												</div>
											</div>
										</label>
									<?php endfor ?>
								</div>
							</div>
							<div class="col-12 content-essai" style="display: none">
								<textarea id="jawabesai<?= $pageurl[3] ?>" name="textjawab" style="height:200px; resize: none" class="textjawab form-control"></textarea>
							</div>
						</div>

						<div class="box-footer button-move my-2">
							<div class="row">
								<div class="col move-prev pr-1">
									<button id="move-prev" class="btn btn-primary fw-bold bg-gradient shadow">
										<i class="fa fa-angle-left d-block d-sm-none"></i>
										&nbsp;
										<span class="d-none d-sm-block">Sebelumnya</span>
									</button>
								</div>
								<div class="col move-next pl-1">
									<button id="move-next" class="btn-next-pg btn btn-primary bg-gradient fw-bold shadow">
										<span class="d-none d-sm-block">Selanjutnya</span>
										&nbsp;
										<i class="fa fa-angle-right d-block d-sm-none"></i>
									</button>
									<button id="move-next" class="btn-next-essai btn btn-primary bg-gradient fw-bold shadow" onclick="loadsoal('/testongoing/2/1')">
										<span class="d-none d-sm-block">Selanjutnya</span>
										&nbsp;
										<i class="fa fa-angle-right d-block d-sm-none"></i>
									</button>
									<button id="move-next" class="btn-selesai btn btn-danger bg-gradient fw-bold shadow">
										<span class="d-none d-sm-block">Selesai?</span>
										&nbsp;
										<i class="fa fa-angle-right d-block d-sm-none"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="navs-slide rounded-start rounded-3">
					<div class="btn-slide rounded-start shadow"></div>
					<div class="card card-primary shadow border-light" style="border-radius: 10px 0 0 10px">
						<div class="card-header" style="border-radius: 10px 0 0 0">
							<span class="fw-bold fs-5">Daftar Soal</span>
						</div>
						<div class="card-body px-2" id="list-soal-number">
							<input type="hidden" id="jumsoal" value="<?= $jmlsoalall ?>" />
							<input type="hidden" id="jumjawab" />
							<div class="col-12">
								<ul class="list-group list-group-flush">
									<li class="list-group-item px-0 pt-0" <?= ($jmlesai == 0) ? 'style="border-bottom: none"' : ($jmlpg == 0 ? 'style="display: none"' : 'style="padding-bottom: 20px"') ?>>
										<div class="col-12 fw-bold text-decoration-underline">Soal Pilihan Ganda</div>

										<div id="navlist-soal" class="row mx-0 d-flex justify-content-evenly">
											<?php for ($byk = 1; $byk <= $jmlpg; $byk++) : ?>
												<button type="button" data-href="/testongoing/1/<?= $byk ?>" id="badge<?= $byk ?>" class="btn-listnumber btn btn-light bg-gradient border rounded-circle shadow position-relative mt-3 mx-1" style="max-width: 50px; height: 50px; border-color: silver" onclick="loadsoal('/testongoing/1/<?= $byk ?>')">
													<?= $byk ?>
													<span id="badgeanswer<?= $byk ?>" class="position-absolute badge rounded-circle bg-success bg-gradient" style="top: -5px; right: -8px; width: 50%; height: 50%"></span>
												</button>
											<?php endfor ?>
										</div>
									</li>
									<li class="list-group-item px-0" <?= ($jmlesai == 0) ? 'style="display: none"' : '' ?>>
										<div class="col-12 fw-bold text-decoration-underline">Soal Essay</div>

										<div id="navlist-soal" class="col-12 row mx-0 d-flex justify-content-evenly">
											<?php for ($byk = 1; $byk <= $jmlesai; $byk++) : ?>
												<button type="button" id="badgesai<?= $byk ?>" class="btn-listnumber btn btn-light bg-gradient border rounded-circle shadow position-relative mt-2 mx-1" style="max-width: 50px; height: 50px; border-color: silver" onclick="loadsoal('/testongoing/2/<?= $byk ?>')"><?= $byk ?></button>
											<?php endfor ?>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script src="/plugins/jquery/jquery-3.1.1.min.js"></script>
	<script src="/plugins/zoom-master/jquery.zoom.js"></script>
	<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="/plugins/iCheck/icheck.min.js"></script>
	<script src='/plugins/sweetalert2/sweetalert2.all.min.js'></script>
	<script src="/plugins/slidemenu/jquery-slide-menu.js"></script>
	<script src="/plugins/mousetrap/mousetrap.min.js"></script>
	<script src="/dist/js/html2canvas.min.js"></script>
	<script>
		$(function() {
			$('#list-soal-number').slimScroll({
				height: '250px'
			});
		})

		var url = window.location.href;
		var str = url.split("/");
		var homeurl = '<?= $_SERVER['REQUEST_URI'] ?>';

		$(document).ready(function() {
			if (str[3] == '') {
				$.ajax({
					url: '/checked',
					dataType: 'JSON',
					error: function(error) {
						$.each(error.responseJSON, function(field, val) {
							$('.list-' + field).html(val);
						});

						let timerInterval
						Swal.fire({
							html: '<h4>' + error.responseJSON.data.error + '</h4>',
							timer: 3000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading()
								const b = Swal.getHtmlContainer().querySelector('b');
								timerInterval = setInterval(() => {
									b.textContent = Swal.getTimerLeft();
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							}
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								window.location = '/logout';
							}
						});
					},
					success: function(response) {
						$.each(response, function(field, val) {
							$('.list-' + field).html(val);
						});

						if (response.data.daftarhadir > 0) {
							window.location = response.data.action;
						} else {
							$('#konfirmasi').click(function() {
								$('.konfirm-peserta').attr('action', response.data.action);
								// window.location = response.data.action;
							})
						}
					}
				});
			}

			if (str[3] == 'absensi') {
				var canvasDiv = document.getElementById('canvasDiv');
				var canvas = document.createElement('canvas');
				canvas.setAttribute('id', 'canvas');
				canvasDiv.appendChild(canvas);
				$("#canvas").attr('height', $("#canvasDiv").outerHeight());
				$("#canvas").attr('width', $("#canvasDiv").width());
				if (typeof G_vmlCanvasManager != 'undefined') {
					canvas = G_vmlCanvasManager.initElement(canvas);
				}

				context = canvas.getContext("2d");
				$('#canvas').mousedown(function(e) {
					var offset = $(this).offset()
					var mouseX = e.pageX - this.offsetLeft;
					var mouseY = e.pageY - this.offsetTop;

					paint = true;
					addClick(e.pageX - offset.left, e.pageY - offset.top);
					redraw();
				});

				$('#canvas').mousemove(function(e) {
					if (paint) {
						var offset = $(this).offset()
						//addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
						addClick(e.pageX - offset.left, e.pageY - offset.top, true);
						redraw();
					}
				});

				$('#canvas').mouseup(function(e) {
					paint = false;
					var mycanvas = document.getElementById('canvas');
					var img = mycanvas.toDataURL("image/png");
					anchor = $("#signature");
					anchor.val(img);
				});

				$('#canvas').mouseleave(function(e) {
					paint = false;
				});

				var clickX = new Array();
				var clickY = new Array();
				var clickDrag = new Array();
				var paint;

				function addClick(x, y, dragging) {
					clickX.push(x);
					clickY.push(y);
					clickDrag.push(dragging);
				}

				$("#reset-btn").click(function() {
					context.clearRect(0, 0, window.innerWidth, window.innerWidth);
					clickX = [];
					clickY = [];
					clickDrag = [];

					$('#signature').val('');
				});

				$(document).on('click', '#btn-save', function(e) {
					e.preventDefault();
					var signa = $("#signatureform").on('submit', function(e) {
						e.preventDefault();
					});

					$.ajax({
						url: '/checked/absensi/' + str[4] + '/' + str[5],
						method: "POST",
						data: signa.serialize(),
						dataType: 'JSON',
						error: function(error) {
							$('.pesan').html('<div class="alert alert-danger alert-dismissible">' + error.responseJSON.error + '</div>');
						},
						success: function(response) {
							window.location = response.action;
						}
					});
				});

				var drawing = false;
				var mousePos = {
					x: 0,
					y: 0
				};
				var lastPos = mousePos;

				canvas.addEventListener("touchstart", function(e) {
					mousePos = getTouchPos(canvas, e);
					var touch = e.touches[0];
					var mouseEvent = new MouseEvent("mousedown", {
						clientX: touch.clientX,
						clientY: touch.clientY
					});
					canvas.dispatchEvent(mouseEvent);
				}, false);


				canvas.addEventListener("touchend", function(e) {
					var mouseEvent = new MouseEvent("mouseup", {});
					canvas.dispatchEvent(mouseEvent);
				}, false);


				canvas.addEventListener("touchmove", function(e) {

					var touch = e.touches[0];
					var offset = $('#canvas').offset();
					var mouseEvent = new MouseEvent("mousemove", {
						clientX: touch.clientX,
						clientY: touch.clientY
					});
					canvas.dispatchEvent(mouseEvent);
				}, false);

				// Get the position of a touch relative to the canvas
				function getTouchPos(canvasDiv, touchEvent) {
					var rect = canvasDiv.getBoundingClientRect();
					return {
						x: touchEvent.touches[0].clientX - rect.left,
						y: touchEvent.touches[0].clientY - rect.top
					};
				}

				var elem = document.getElementById("canvas");

				var defaultPrevent = function(e) {
					e.preventDefault();
				}
				elem.addEventListener("touchstart", defaultPrevent);
				elem.addEventListener("touchmove", defaultPrevent);

				function redraw() {
					lastPos = mousePos;
					for (var i = 0; i < clickX.length; i++) {
						context.beginPath();
						if (clickDrag[i] && i) {
							context.moveTo(clickX[i - 1], clickY[i - 1]);
						} else {
							context.moveTo(clickX[i] - 1, clickY[i]);
						}
						context.lineTo(clickX[i], clickY[i]);
						context.closePath();
						context.stroke();
					}
				}
			}

			if (str[3] == 'konfirmasi') {
				$.ajax({
					url: '/checked/konfirmasi/' + str[4] + '/' + str[5],
					dataType: 'JSON',
					success: function(response) {
						$.each(response, function(field, val) {
							$('.list-' + field).html(val);
						});

						if (response.data.action != 0) {
							if (response.data.token == 1) {
								$('.list-group-token').removeAttr('style');
							}

							$('#mulai').on('click', function(e) {
								e.preventDefault();

								$.ajax({
									url: response.data.action,
									data: {
										token: $('#token').val()
									},
									type: "POST",
									dataType: 'json',
									error: function(error) {
										if (error.status == 404) {
											$('.pesan').html('<div class="alert alert-danger alert-dismissible">' + error.responseJSON.error + '</div>');
										} else {
											$('.pesan').html('<div class="alert alert-danger alert-dismissible">' + error.responseJSON.error + '</div>');
										}
									},
									success: function(data) {
										window.location = data.action;
									}
								});
							});
						} else {
							$('.konfirm-ujian').on('submit', function(e) {
								alert($(this).serialize())
							})
						}
					}
				})
			}

			if (str[3] == 'testongoing') {
				loadsoal(homeurl);

				$('.navs-slide').SlideMenu({
					expand: false,
					collapse: true
				});

				let defaultFontSize = 14;
				let fontSize = 0;

				fontSize = localStorage.getItem('fontSize');

				if (!fontSize) {
					fontSize = defaultFontSize;
					localStorage.setItem('fontSize', fontSize);
				}

				soalFont(fontSize);

				function soalFont(fontSize) {
					$('div.soal > p > span').css({
						fontSize: fontSize + 'pt'
					});
					$('span.soal > p > span').css({
						fontSize: fontSize + 'pt'
					});
					$('.soal, .opsijawab').css({
						fontSize: fontSize + 'pt'
					});
					$('.callout soal').css({
						fontSize: fontSize + 'pt'
					});
				}

				$('#smaller_font').on('click', function() {
					fontSize = localStorage.getItem('fontSize');
					fontSize--;
					localStorage.setItem('fontSize', fontSize);
					soalFont(fontSize);
				});

				$('#bigger_font').on('click', function() {
					fontSize = localStorage.getItem('fontSize');
					fontSize++;
					localStorage.setItem('fontSize', fontSize);
					soalFont(fontSize);
				});

				$('#reset_font').on('click', function() {
					fontSize = defaultFontSize;
					localStorage.setItem('fontSize', fontSize);
					soalFont(fontSize);
				});

				var countDownDate = new Date("<?= date('M d, Y H:i:s', strtotime('+' . $namamapel["durasi_ujian"] . 'minutes', strtotime($nilai['ujian_mulai']))) ?>").getTime();

				var x = setInterval(function() {

					var now = new Date().getTime();

					var distance = countDownDate - now;

					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					hours = hours < 10 ? '0' + hours : hours;
					minutes = minutes < 10 ? '0' + minutes : minutes;
					seconds = seconds < 10 ? '0' + seconds : seconds;

					document.getElementById("countdown").innerHTML = "<b>" + hours + "</b>:<b>" + minutes + "</b>:<b>" + seconds + "</b>";

					if (distance <= 0) {
						clearInterval(x);
						waktuhabis();
					}
					return distance;
				}, 1000);

				window.addEventListener('popstate', function(e) {
					if (e.state)
						openURL(e.state.href);
				});
			}

			Mousetrap.bind('right', function() {
				if (str[4] == 1) {
					if (str[5] == 1 || str[5] <= '<?= $jmlpg ?>') {
						loadsoal($('.btn-next-pg').data('href'))
					}
				}
			});

			Mousetrap.bind('left', function() {
				if (str[4] == 1) {
					if (str[5] >= 1) {
						loadsoal($('#move-prev').data('href'))
					}
				}
			});

			Mousetrap.bind('a', function() {
				$('#A').click();
			});

			Mousetrap.bind('b', function() {
				$('#B').click();
			});

			Mousetrap.bind('c', function() {
				$('#C').click();
			});

			Mousetrap.bind('d', function() {
				$('#D').click();
			});

			Mousetrap.bind('e', function() {
				$('#E').click();
			});

			$('.btn-check').click(function() {
				jawabsoal($(this).attr('id'), $(this).val())
			});

			$('.btn-next-pg').on('click', function() {
				$('.textjawab').val('');
				loadsoal($(this).data('href'));
			});

			$('.textjawab').on('keyup', function() {
				jawabsoal('', $(this).val())
			});

			$('#move-prev').on('click', function() {
				loadsoal($(this).data('href'));
			});

			$('.btn-selesai').on('click', function() {
				if ($('#jumjawab').val() < $('#jumsoal').val()) {
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: '<p>Masih ada <strong>' + ($('#jumsoal').val() - $('#jumjawab').val()) + ' Soal</strong> yang belum dikerjakan !! </p>',
						timer: 3000,
						timerProgressBar: true,
						showConfirmButton: false,
					})
				} else {
					Swal.fire({
						title: 'Anda sudah yakin?',
						html: "Tekan tombol <strong>Selesaikan</strong> Jika sudah yakin ingin selesaikan ujian ini",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Selesaikan',
						cancelButtonText: 'Tidak',
						reverseButtons: false,
						customClass: {
							confirmButton: 'btn btn-success bg-gradient',
							cancelButton: 'btn btn-danger bg-gradient mx-2',

						},
						buttonsStyling: false,
						width: 'auto',
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								url: '/checked/done',
								type: 'POST',
								data: {
									jmljwb: $('#jumjawab').val(),
								},
								dataType: 'JSON',
								success: function(response) {
									window.location = '/logout'
								}
							})
						}
					});
				}
			});
		});

		function waktuhabis() {
			swal.fire({
				title: 'Maaf!!!',
				text: 'Waktu ujian Anda telah berakhir, terima kasih...',
				timer: 5000,
				timerProgressBar: true,
				onOpen: () => {
					swal.showLoading();
				}
			}).then((result) => {
				$.ajax({
					url: '/checked/done',
					dataType: 'JSON',
					success: function(response) {
						window.location = response.action;
					}
				});
			});
		}

		function loadsoal(href) {
			var strs = href.split("/");

			if (strs[2] == 1) {
				$('#opsi').show();
				$('.content-essai').hide();

				if (strs[3] == 1 && strs[3] < '<?= $jmlpg ?>') {
					$('.move-prev').hide();
					$('.btn-next-pg').show();
					$('.btn-next-essai').hide();
					$('.btn-selesai').hide();
				} else {
					if (strs[3] == '<?= $jmlpg ?>') {
						$('.btn-next-pg').hide();
						$('.btn-selesai').hide();
						$('.move-prev').show();
						$('.btn-next-essai').removeAttr('style').removeClass('btn-secondary').addClass('btn-success').find('span').html('Soal Essay');
					} else {
						$('.move-prev').show();
						$('.btn-next-pg').show();
						$('.btn-selesai').hide();
						$('.btn-next-essai').hide();

					}
				}
			} else {
				$('#opsi').hide();
				$('.content-essai').show();
				$('.btn-selesai').hide();

				if (strs[3] == 1) {
					$('.move-prev').hide();
					$('.btn-next-pg').show();
					$('.btn-next-essai').hide();
				} else {
					if (strs[3] < '<?= $jmlesai ?>') {
						$('.btn-next-essai').hide();
						$('.btn-selesai').hide();
						$('.move-prev').show();
						$('.btn-next-pg').show();
					} else {
						$('.btn-next-pg').hide();
						$('.btn-next-essai').hide();
						$('.move-prev').show();

						$('.btn-selesai').show();
					}
				}
			}

			$.ajax({
				url: '/checked' + href,
				dataType: 'JSON',
				success: function(response) {
					$('#urls').val(href);
					$('#jumjawab').val(response.jumsoal);

					$('#displaynum').html(strs[3]);
					$('.btn-next-pg').data('href', response.nextnum);
					$('#move-prev').data('href', response.prevnum);
					$('#numsoal').val(response.nomor);
					$('.soal').html(response.soal).css('text-align', 'justify');

					if (strs[2] == 2) {
						$.each(response.jawaban, function(field, val) {
							$('#' + field).val(val)
						})
					}

					if (response.opsi.length > 0) {
						response.opsi.forEach(function(val) {
							$.each(val, function(field, value) {
								var string = field.split('pil');
								$('#' + field).val(value);
								$('#' + string[1]).val(value);

								if ($('#' + string[1]).val() == response.jawaban) {
									$('#' + string[1]).prop('checked', true);
								} else {
									$('#' + string[1]).prop('checked', false)
								}
							});
						});
					}

					if (response.opsijawab.length > 0) {
						response.opsijawab.forEach(function(val) {
							$.each(val, function(field, value) {
								$('#' + field).html(value).css('text-align', 'justify');
							});
						});
					}

					if (response.jmlpg.length > 0) {
						response.jmlpg.forEach(function(va) {
							$.each(va, function(fi, vaa) {
								var badge = fi.split('badgeanswer');
								$('#' + fi).html(vaa)
								$('#badge' + badge[1]).removeClass('bg-light').addClass('bg-primary text-light fw-bold');
							});
						});
					}

					if (response.jmlesai.length > 0) {
						response.jmlesai.forEach(function(va) {
							$.each(va, function(fi, vaa) {
								$('#' + fi).removeClass('bg-light').addClass('bg-primary text-light fw-bold');
							});
						});
					}
				}
			});

			window.history.pushState({
				href: href
			}, '', href);
		}

		function jawabsoal(data, jawaban) {
			var pecah = $('#urls').val().split('/');

			$.ajax({
				url: '/checked/jawabsoal/' + pecah[2] + '/' + pecah[3],
				type: 'POST',
				data: {
					nomor: $('#numsoal').val(),
					// 	soal: $('.soal').html(),
					jawaban: jawaban,
					jenis: pecah[2],
					badge: pecah[3],
					badgea: data,
				},
				dataType: 'JSON',
				success: function(response) {
					if (pecah[2] == 1) {
						$.each(response, function(fi, va) {
							$('#' + fi).html(va);
							var badge = fi.split('badgeanswer');

							$('#badge' + badge[1]).removeClass('bg-light').addClass('bg-primary text-light fw-bold');
						});
						loadsoal($('#urls').val())
					} else {
						$('#jumjawab').val(response.jumsoal)
						$.each(response, function(fi, va) {
							$('#' + fi).removeClass('bg-light').addClass('bg-primary text-light fw-bold');
						});
					}
				}
			})
		}
	</script>
</body>

</html>