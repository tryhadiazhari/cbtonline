<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");

// (!isset($_SESSION['id_siswa'])) ? header("Location: $homeurl/login") : $id_siswa = $_SESSION['id_siswa'];
(isset($_SESSION['id_siswa'])) ? $id_siswa = $_SESSION['id_siswa'] : header("Location: $homeurl/login");
($id_siswa == null) ? header("Location: $homeurl/login") : null;

$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_siswa WHERE uid_siswa = '" . $id_siswa . "'"));
$jurusan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_rombel WHERE npsn = '" . $siswa['npsn'] . "' AND nama = '" . $siswa['rombel'] . "'"));

if ($pageurl[2] == '') {
	$cekStatusUjian = mysqli_query($koneksi, "SELECT * FROM hazedu_jenis_ujian WHERE status= 'Aktif'");
	$jenisUjian = mysqli_fetch_array($cekStatusUjian);

	if (mysqli_num_rows($cekStatusUjian) > 0) {
		$cekjadwalujian = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE tgl_ujian = '" . date('Y-m-d') . "' AND tgl_expired <= '" . date('Y-m-d 23:59:59') . "' AND `status` = 1 AND tingkatan = '" . $siswa['tingkatan'] . "' AND sesi = '" . $siswa['sesi'] . "' AND jenjang = '" . $jurusan['jenjang'] . "'");

		if (mysqli_num_rows($cekjadwalujian) > 0) {
			foreach ($cekjadwalujian as $jadwal) {
				$namamapel = mysqli_query($koneksi, "SELECT * FROM hazedu_banksoal WHERE tingkatan = '" . $siswa['tingkatan'] . "' AND jenjang = '" . $jurusan['jenjang'] . "' AND uid_banksoal = '" . $jadwal['uid_banksoal'] . "'");
				$fetchUjian = mysqli_fetch_array($namamapel);

				if ($fetchUjian['mapel'] == 'Pendidikan Agama') {
					if ($siswa['agama'] == 'Islam') {
						$jadwalujian = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE kode_ujian = '" . $jenisUjian['alias'] . "' AND kategori = 'Islam' AND tingkatan = '" . $siswa['tingkatan'] . "' AND sesi = '" . $siswa['sesi'] . "' AND jenjang = '" . $jurusan['jenjang'] . "' AND `status` = 1 AND tgl_ujian = '" . date('Y-m-d') . "'");
						$queryUjian = mysqli_fetch_array($jadwalujian);
					} else {
						$jadwalujian = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE kode_ujian = '" . $jenisUjian['alias'] . "' AND kategori = '" . $jadwal['kategori'] . "' AND tingkatan = '" . $siswa['tingkatan'] . "' AND sesi = '" . $siswa['sesi'] . "' AND jenjang = '" . $jurusan['jenjang'] . "' AND `status` = 1 AND tgl_ujian = '" . date('Y-m-d') . "'");
						$queryUjian = mysqli_fetch_array($jadwalujian);
					}
				} else {
					$jadwalujian = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE kode_ujian = '" . $jenisUjian['alias'] . "' AND tingkatan = '" . $siswa['tingkatan'] . "' AND jenjang = '" . $jurusan['jenjang'] . "' AND sesi = '" . $siswa['sesi'] . "' AND `status` = 1 AND tgl_ujian = '" . date('Y-m-d') . "'");
					$queryUjian = mysqli_fetch_array($jadwalujian);
				}

				if (time() <= strtotime($queryUjian['tgl_ujian'] . ' ' . $queryUjian['jam_ujian']) && time() <= strtotime($queryUjian['tgl_expired'])) {
					$data = [
						'error' => 'Maaf! Jadwal ujian ' . $queryUjian['mapel'] . ' belum dimulai, silahkan tunggu sesuai jadwal yang berikan',
					];

					http_response_code(400);
				} else {
					if (time() >= strtotime($queryUjian['tgl_expired'])) {
						$data = [
							'error' => 'Maaf! Jadwal ujian ' . $queryUjian['mapel'] . ' telah berakhir...',
						];

						http_response_code(400);
					} else {

						$daftarhadir = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM hazedu_daftar_hadir WHERE uid_siswa = '" . $siswa['uid_siswa'] . "' AND uid_banksoal = '" . $queryUjian['uid_banksoal'] . "' AND uid_jadwal = '" . $queryUjian['uid_jadwal'] . "'"));

						if ($daftarhadir > 0) {
							$data = [
								'daftarhadir' => $daftarhadir,
								'action' => '/konfirmasi/',
								'agama' => $queryUjian['kategori'],
								'id' => $queryUjian['uid_banksoal'],
							];
						} else {
							$data = [
								'daftarhadir' => $daftarhadir,
								'action' => '/absensi/',
								'agama' => $queryUjian['kategori'],
								'id' => $queryUjian['uid_banksoal'],
							];
						}

						http_response_code(200);
					}
				}

				$_SESSION['uid_banksoal'] = $queryUjian['uid_banksoal'];
				$_SESSION['uid_jadwal'] = $queryUjian['uid_jadwal'];
			}
		} else {
			$data = [
				'error' => "Tidak ada jadwal ujian yang berlangsung... Anda akan keluar dalam 3 detik"
			];

			http_response_code(400);
		}
	} else {
		$response = [
			'error' => 'Tidak jenis ujian yang aktif...'
		];

		http_response_code(404);
	}

	$response = [
		'nisn' => $siswa['nisn'],
		'nama' => $siswa['nama'],
		'agama' => $siswa['agama'],
		'tempatlahir' => $siswa['tempat_lahir'],
		'tgllahir' => date('d-m-Y', strtotime($siswa['tanggal_lahir'])),
		'jk' => ($siswa['jk'] == 'L') ? 'Laki-Laki' : 'Perempuan',
		'data' => $data
	];
} else if ($pageurl[2] == 'absensi') {
	$signature = $_POST['signature'];

	$namamapel = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE uid_banksoal = '" . $_SESSION['uid_banksoal'] . "'");
	$fetchUjian = mysqli_fetch_array($namamapel);

	if ($_POST['signature'] == "") {
		$response = ['error' => 'Tanda tangan wajib dibuat!!!'];
		http_response_code(400);
	} else {
		$signatureFileName = $siswa['npsn'] . "-" . $siswa['uid_siswa'] . "-" . $fetchUjian['uid_jadwal'] . "-" . time() . ".png";
		$signature = str_replace('data:image/png;base64,', '', $signature);
		$signature = str_replace(' ', '+', $signature);
		$data = base64_decode($signature);
		$file = '../assets/signature/' . $signatureFileName;
		file_put_contents($file, $data);

		mysqli_query($koneksi, "INSERT INTO `hazedu_daftar_hadir` (`npsn`, `uid_banksoal`, `uid_jadwal`, `uid_siswa`, `nama`, `tandatangan`) VALUES ('" . $siswa['npsn'] . "','" . $fetchUjian['uid_banksoal'] . "', '" . $fetchUjian['uid_jadwal'] . "', '" . $siswa['uid_siswa'] . "', '" . $siswa['nama'] . "', '$signatureFileName')");

		$response = [
			'action' => '/konfirmasi/'
		];
	}
} else if ($pageurl[2] == 'konfirmasi') {
	$namamapel = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE uid_banksoal = '" . $_SESSION['uid_banksoal'] . "'");
	$fetchUjian = mysqli_fetch_array($namamapel);

	$query = mysqli_query($koneksi, "SELECT * FROM hazedu_nilai WHERE uid_jadwal = '" . $_SESSION['uid_jadwal'] . "' AND uid_siswa = '" . $siswa['uid_siswa'] . "'");
	$nilai = mysqli_fetch_array($query);

	$jenisujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_jenis_ujian WHERE alias = '" . $fetchUjian['kode_ujian'] . "'"));

	if ($fetchUjian['token'] == 1) {
		if (mysqli_num_rows($query) == 0) {
			$data = [
				'action' => '/checked/rules/' . $siswa['uid_siswa'] . '/' . $fetchUjian['uid_jadwal'],
				'status' => '<label class="label label-success">Tes Baru</label>',
				'token' => $fetchUjian['token']
			];
		} else {
			if ($nilai['ujian_selesai'] == '0000-00-00 00:00:00') {
				$data = [
					'action' => '/checked/rules/' . $siswa['uid_siswa'] . '/' . $fetchUjian['uid_jadwal'],
					'status' => '<label class="label label-warning">Berlangsung</label>',
					'token' => $fetchUjian['token']
				];
			} else {
				$data = [
					'action' => 0,
					'status' => '<label class="label label-primary">Selesai</label>',
					'token' => $fetchUjian['token'],
					'disable' => true
				];
			}
		}
	} else {
		if (mysqli_num_rows($query) == 0) {
			$data = [
				'action' => '/checked/rules/' . $siswa['uid_siswa'] . '/' . $fetchUjian['uid_jadwal'],
				'status' => '<label class="label label-success">Tes Baru</label>',
			];
		} else {
			if ($nilai['ujian_selesai'] == '0000-00-00 00:00:00') {
				$data = [
					'action' => '/checked/rules/' . $siswa['uid_siswa'] . '/' . $fetchUjian['uid_jadwal'],
					'status' => '<label class="label label-warning">Berlangsung</label>',
				];
			} else {
				$data = [
					'action' => 0,
					'status' => '<label class="label label-primary">Selesai</label>',
					'disable' => true,
				];
			}
		}
	}

	$response = [
		'jenisujian' => $jenisujian['nama'],
		'status' => $data['status'],
		'mapel' => $fetchUjian['mapel'],
		'durasi' => $fetchUjian['durasi_ujian'] . ' Menit',
		'jmlsoal' => ($fetchUjian['jml_esai'] == 0) ? $fetchUjian['jml_pg'] . ' Pilihan Ganda' : $fetchUjian['jml_pg'] . ' PG / ' . $fetchUjian['jml_esai'] . ' Essay',
		'data' => $data
	];
} else if ($pageurl[2] == 'rules') {
	$logdata = array(
		'npsn' => $siswa['npsn'],
		'uid_siswa' => $siswa['uid_siswa'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'type' => 'testongoing',
		'text' => 'Sedang Ujian',
		'date' => date('Y-m-d H:i:s')
	);

	$ceklog = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM log WHERE uid_siswa = '" . $id_siswa . "' AND uid_jadwal = '" . $_SESSION['uid_jadwal'] . "' AND `type` = 'testongoing'"));

	if ($ceklog == 0) {
		insert('log', $logdata);
	}

	if (empty($_POST['token'])) {
		$response = [
			'error' => 'Masukan Kode Token!!!'
		];

		http_response_code(404);
	} else {
		$tokencek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT token FROM token"));

		if ($tokencek['token'] == $_POST['token']) {
			$query = mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE uid_banksoal = '" . $_SESSION['uid_banksoal'] . "'");
			$fetchUjian = mysqli_fetch_array($query);

			$order = array(
				"nomor ASC",
				"nomor DESC",
				"soal ASC",
				"soal DESC",
				"pilA ASC",
				"pilA DESC",
				"pilB ASC",
				"pilB DESC",
				"pilC ASC",
				"pilC DESC",
				"pilD ASC",
				"pilD DESC",
				"pilE ASC",
				"pilE DESC",
			);
			$ordera = array(
				"nomor ASC",
				"nomor DESC",
				"soal ASC",
				"soal DESC",
			);

			$ambilsoal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE uid_banksoal = '" . $fetchUjian['uid_banksoal'] . "'"));

			$r = ($fetchUjian['acak'] == 1) ? mt_rand(0, 17) : 0;
			$re = ($fetchUjian['acak'] == 1) ? mt_rand(0, 17) : 0;

			$where = array(
				'uid_banksoal' => $fetchUjian['uid_banksoal'],
				'jenis' => '1',
			);

			$where2 = array(
				'uid_banksoal' => $fetchUjian['uid_banksoal'],
				'jenis' => '2',
			);

			$soal = select('soal', $where, $order[$r]);
			$soalesai = select('soal', $where2, $ordera[$re]);

			$nomorpg = '';
			$nomoresai = '';

			foreach ($soal as $s) :
				if ($fetchUjian['opsi'] == 5) :
					$acz = array("A", "B", "C", "D", "E");
				elseif ($fetchUjian['opsi'] == 4) :
					$acz = array("A", "B", "C", "D");
				elseif ($fetchUjian['opsi'] == 3) :
					$acz = array("A", "B", "C");
				endif;

				if ($fetchUjian['acak'] == 0) {
					$ack1 = $acz[0];
					$ack2 = $acz[1];
					$ack3 = $acz[2];
					$ack4 = $acz[3];

					if ($fetchUjian['opsi'] == 3) :
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',';
					elseif ($fetchUjian['opsi'] == 4) :
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',';
					elseif ($fetchUjian['opsi'] == 5) :
						$ack5 = $acz[4];
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',' . $ack5 . ',';
					endif;
				} else {
					shuffle($acz);
					$ack1 = $acz[0];
					$ack2 = $acz[1];
					$ack3 = $acz[2];
					$ack4 = $acz[3];

					if ($fetchUjian['opsi'] == 3) :
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',';
					elseif ($fetchUjian['opsi'] == 4) :
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',';
					elseif ($fetchUjian['opsi'] == 5) :
						$ack5 = $acz[4];
						$nomorpg .= $s['nomor'] . ',';
						$opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',' . $ack5 . ',';
					endif;
				}
			endforeach;

			foreach ($soalesai as $m) :
				$nomoresai .= $m['nomor'] . ',';
			endforeach;

			$queryNilai = mysqli_query($koneksi, "SELECT * FROM hazedu_nilai WHERE uid_jadwal = '" . $fetchUjian['uid_jadwal'] . "' AND uid_siswa = '" . $siswa['uid_siswa'] . "'");
			$nilai = mysqli_fetch_array($queryNilai);

			$ceknilai = mysqli_num_rows($queryNilai);
			if (!$ceknilai <> 0) {
				mysqli_query($koneksi, "INSERT INTO `hazedu_nilai` (`uid_nilai`, `npsn`, `uid_jadwal`, `uid_banksoal`, `mapel`, `kode_ujian`, `uid_siswa`, `tgl_ujian`, `ujian_mulai`, `ipaddress`) VALUES ('" . $siswa['npsn'] . $fetchUjian['uid_banksoal'] . time() . $ambilsoal['jenis'] . $ambilsoal['nomor'] . "','" . $siswa['npsn'] . "','" . $fetchUjian['uid_jadwal'] . "','" . $fetchUjian['uid_banksoal'] . "','" . $fetchUjian['mapel'] . "','" . $fetchUjian['kode_ujian'] . "','" . $siswa['uid_siswa'] . "','" . $fetchUjian['tgl_ujian'] . "','" . date('Y-m-d H:i:s') . "','" . $_SERVER['REMOTE_ADDR'] . "')");

				mysqli_query($koneksi, "INSERT INTO `pengacak` (`npsn`, `uid_banksoal`, `uid_jadwal`, `uid_siswa`, `nomorpg`, `nomoresai`) VALUES ('" . $siswa['npsn'] . "','" . $fetchUjian['uid_banksoal'] . "','" . $fetchUjian['uid_jadwal'] . "','" . $siswa['uid_siswa'] . "','" . $nomorpg . "','" . $nomoresai . "')");

				mysqli_query($koneksi, "INSERT INTO `pengacakopsi` (`npsn`, `uid_banksoal`, `uid_jadwal`, `uid_siswa`, `opsi`) VALUES ('" . $siswa['npsn'] . "','" . $fetchUjian['uid_banksoal'] . "','" . $fetchUjian['uid_jadwal'] . "','" . $siswa['uid_siswa'] . "','" . $opsi . "')");
			}
			$_SESSION['uid_jadwal'] = $fetchUjian['uid_jadwal'];

			$response = [
				'action' => '/testongoing/' . $ambilsoal['jenis'] . '/1'
			];
		} else {
			$response = [
				'error' => 'Kode Token Salah!!!'
			];

			http_response_code(400);
		}
	}
} else if ($pageurl[2] == 'testongoing') {
	$logdata = array(
		'npsn' => $siswa['npsn'],
		'uid_siswa' => $siswa['uid_siswa'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'type' => 'testongoing',
		'text' => 'Sedang Ujian',
		'date' => date('Y-m-d H:i:s')
	);

	$ceklog = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM log WHERE uid_siswa = '" . $id_siswa . "' AND uid_jadwal = '" . $_SESSION['uid_jadwal'] . "' AND `type` = 'testongoing'"));

	if ($ceklog == 0) {
		insert('log', $logdata);
	}

	$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM hazedu_jadwal WHERE uid_jadwal='" . $_SESSION['uid_jadwal'] . "'"));

	$no_soal = ($pageurl[4] == 1) ? 0 - 1 : $pageurl[4];
	$no_prev = $no_soal - 1;
	$no_next = ($pageurl[4] <= 1) ? 0 : $pageurl[4] - 1;
	$id_mapel = $query['uid_banksoal'];

	$id_siswa = $siswa['uid_siswa'];

	$audio = array('mp3');

	$where = array(
		'npsn' => $siswa['npsn'],
		'uid_banksoal' => $id_mapel,
		'uid_jadwal' => $query['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
	);
	$where2 = array(
		'npsn' => $siswa['npsn'],
		'uid_banksoal' => $id_mapel,
		'uid_jadwal' => $query['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
	);

	$pengacak = fetch('pengacak', $where);
	$pengacakpil = fetch('pengacakopsi', $where);
	$pengacakesai = fetch('pengacak', $where);

	$pengacak2 = explode(',', $pengacak['nomorpg']);
	$pengacakpil2 = explode(',', $pengacakpil['opsi']);
	$pengacakesai2 = explode(',', $pengacakesai['nomoresai']);

	$soal = fetch('soal', array('uid_banksoal' => $id_mapel, 'nomor' => $pengacak2[$no_next], 'jenis' => 1));

	$soalessai = fetch('soal', array('uid_banksoal' => $id_mapel, 'nomor' => $pengacakesai2[$no_next], 'jenis' => 2));

	$jawab = fetch('jawaban', array('uid_siswa' => $siswa['uid_siswa'], 'uid_banksoal' => $id_mapel, 'nomor' => $soal['nomor'], 'uid_jadwal' => $query['uid_jadwal'], 'jenis' => 1));

	$jawabesai = fetch('jawaban', array('uid_siswa' => $siswa['uid_siswa'], 'uid_banksoal' => $id_mapel, 'nomor' => $soalessai['nomor'], 'uid_jadwal' => $query['uid_jadwal'], 'jenis' => 2));

	update('hazedu_nilai', array('ujian_berlangsung' => date('Y-m-d H:i:s')), $where2);
	$nilai = fetch('hazedu_nilai', $where2);
	$habis = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
	$selisih = strtotime('+' . $query["durasi_ujian"] . 'minutes', strtotime($nilai['ujian_mulai'])) - strtotime(date('Y-m-d H:i:s'));

	$jam = floor($selisih / (60 * 60));
	$mnt = floor(($selisih - $jam * (60 * 60)) / 60);
	$dtk = $selisih % 60;

	$ujianselesai = $nilai['ujian_selesai'];

	$nop1 = $no_next * $query['opsi'];
	$pil1 = $pengacakpil2[$nop1];

	$nop2 = $no_next * $query['opsi'] + 1;
	$pil2 = $pengacakpil2[$nop2];

	$nop3 = $no_next * $query['opsi'] + 2;
	$pil3 = $pengacakpil2[$nop3];

	if ($query['opsi'] == 4) {
		$nop4 = $no_next * $query['opsi'] + 3;
		$pil4 = $pengacakpil2[$nop4];
	} else if ($query['opsi'] == 5) {
		$nop4 = $no_next * $query['opsi'] + 3;
		$pil4 = $pengacakpil2[$nop4];

		$nop5 = $no_next * $query['opsi'] + 4;
		$pil5 = $pengacakpil2[$nop5];
	}

	$array = [0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E'];
	$nom = [0 => $pil1, 1 => $pil2, 2 => $pil3, 3 => $pil4, 4 => $pil5];

	for ($i = 0; $i < $query['opsi']; $i++) {
		$opsi[] = [
			'pil' . $array[$i] => $nom[$i],
		];
	}
	for ($i = 0; $i < $query['opsi']; $i++) {
		$opsijawab[] = [
			'jawaban' . $array[$i] => $soal['pil' . $nom[$i]]
		];
	}

	$cekpg = select('jawaban', array(
		'uid_banksoal' => $_SESSION['uid_banksoal'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
		'jenis' => 1,
	));

	$cekesai = select('jawaban', array(
		'uid_banksoal' => $_SESSION['uid_banksoal'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
		'jenis' => 2,
	));

	$nomor = 0;
	$nomors = 0;

	foreach ($cekpg as $jawaban) {
		$nomor++;
		$jwbpg[] = [
			'badgeanswer' . $jawaban['badgenom'] => $jawaban['badgeanswer'],
		];
	}

	foreach ($cekesai as $jawaban) {
		$nomors++;
		$jwbesai[] = [
			'badgesai' . $jawaban['badgenom'] => $jawaban['esai']
		];
	}

	if ($pageurl[3] == 1) {
		$response = [
			'nomor' => $soal['nomor'],
			'soal' => $soal['soal'],
			'opsi' => $opsi,
			'opsijawab' => $opsijawab,
			'jmlpg' => (empty($jwbpg)) ? count($cekpg) : $jwbpg,
			'jmlesai' => (empty($jwbesai)) ? count($cekesai) : $jwbesai,
			'jawaban' => (empty($jawab['jawaban'])) ? 0 : $jawab['jawaban'],
			'jumsoal' => count($cekpg) + count($jwbesai),
			'nextnum' => '/testongoing/1/' . ($pageurl[4] == $query['jml_pg'] ? $query['jml_pg'] : $pageurl[4] + 1),
			'prevnum' => '/testongoing/1/' . ($pageurl[4] == 1 ? 1 : $pageurl[4] - 1),
		];
	} else {
		$response = [
			'nomor' => $soalessai['nomor'],
			'soal' => $soalessai['soal'],
			'opsi' => $opsi,
			'opsijawab' => $opsijawab,
			'jmlpg' => (empty($jwbpg)) ? count($cekpg) : $jwbpg,
			'jmlesai' => (empty($jwbesai)) ? count($cekesai) : $jwbesai,
			'jawaban' => [
				'jawabesai' . $pageurl[4] => ($jawabesai['esai'] == null) ? "" : $jawabesai['esai']
			],
			'jumsoal' => count($cekpg) + count($jwbesai),
			'nextnum' => '/testongoing/2/' . ($pageurl[4] == $query['jml_esai'] ? $query['jml_esai'] : ($pageurl[4] + 1)),
			'prevnum' => '/testongoing/2/' . ($pageurl[4] == 1 ? 1 : $pageurl[4] - 1),
		];
	}
} else if ($pageurl[2] == 'jawabsoal') {
	$nomor = $_POST['nomor'];
// 	$soal = $_POST['soal'];
	$jawaban = $_POST['jawaban'];

	$cekjawaban = mysqli_query($koneksi, "SELECT * FROM jawaban WHERE uid_siswa = '" . $siswa['uid_siswa'] . "' AND uid_banksoal = '" . $_SESSION['uid_banksoal'] . "' AND uid_jadwal = '" . $_SESSION['uid_jadwal'] . "' AND nomor = '" . $nomor . "' AND jenis = '" . $_POST['jenis'] . "'");

	if (mysqli_num_rows($cekjawaban) == 0) {
		if ($_POST['jenis'] == 1) {
			insert('jawaban', array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				// 'soal' => $soal,
				'jawaban' => $jawaban,
				'jenis' => 1,
				'badgenom' => $_POST['badge'],
				'badgeanswer' => $_POST['badgea'],
			));
		} else {
			insert('jawaban', array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				// 'soal' => $soal,
				'esai' => $jawaban,
				'jenis' => 2,
				'badgenom' => $_POST['badge'],
			));
		}
	} else {
		if ($_POST['jenis'] == 1) {
			update('jawaban', array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				// 'soal' => $soal,
				'jawaban' => $jawaban,
				'jenis' => 1,
				'badgenom' => $_POST['badge'],
				'badgeanswer' => $_POST['badgea'],
			), array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				'jenis' => 1,
				'badgenom' => $_POST['badge'],
			));
		} else {
			update('jawaban', array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				// 'soal' => $soal,
				'esai' => $jawaban,
				'jenis' => 2,
			), array(
				'uid_banksoal' => $_SESSION['uid_banksoal'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'uid_siswa' => $siswa['uid_siswa'],
				'nomor' => $nomor,
				'jenis' => 2,
			));
		}
	}

	$cekpg = select('jawaban', array(
		'uid_banksoal' => $_SESSION['uid_banksoal'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
		'jenis' => 1,
	));

	$cekesai = select('jawaban', array(
		'uid_banksoal' => $_SESSION['uid_banksoal'],
		'uid_jadwal' => $_SESSION['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
		'jenis' => 2,
	));

	$response['badgeanswer' . $_POST['badge']] = $_POST['badgea'];
	$response['jumsoal'] = count($cekpg) + count($cekesai);
} else if ($pageurl[2] == 'done') {
	$benar = $salah = 0;

	$ceksoal = select('soal', array('uid_banksoal' => $_SESSION['uid_banksoal'], 'jenis' => '1'));
	$soal = fetch('hazedu_jadwal', array('uid_banksoal' => $_SESSION['uid_banksoal']));
	$jmljawaban = $soal['jml_pg'] + $soal['jml_esai'];

	foreach ($ceksoal as $getsoal) {
		$jika = array(
			'uid_banksoal' => $soal['uid_banksoal'],
			'uid_jadwal' => $soal['uid_jadwal'],
			'uid_siswa' => $siswa['uid_siswa'],
			'nomor' => $getsoal['nomor'],
// 			'soal' => $getsoal['soal'],
			'jenis' => '1'
		);

		$getjwb = fetch('jawaban', $jika);

		if ($getjwb) {
			($getjwb['jawaban'] == $getsoal['jawaban']) ? $benar++ : $salah++;
		}
	}

	$jumsalah = $soal['jml_pg'] - $benar;
	$bagi = $soal['jml_pg'] / 100;
	$bobot = $soal['bobot_pg'] / 100;
	$skorx = ($benar / $bagi) * $bobot;
	$skor = number_format($skorx, 2, '.', '');

	$data = array(
		'ujian_selesai' => date('Y-m-d H:i:s'),
		'jml_benar' => $benar,
		'jml_salah' => $jumsalah,
		'skor' => $skor,
		'status' => 'Selesai',
		'total' => $skor
	);
	$where = array(
		'npsn' => $siswa['npsn'],
		'uid_banksoal' => $soal['uid_banksoal'],
		'uid_jadwal' => $soal['uid_jadwal'],
		'uid_siswa' => $siswa['uid_siswa'],
	);
	$where2 = array(
		'npsn' => $siswa['npsn'],
		'uid_jadwal' => $soal['uid_jadwal'],
		'uid_banksoal' => $soal['uid_banksoal'],
		'uid_siswa' => $siswa['uid_siswa'],
	);

	if (delete('pengacak', $where) && delete('pengacakopsi', $where) && update('hazedu_nilai', $data, $where2)) {
		$logdata = array(
			'type' => 'done',
			'text' => 'Selesai Ujian',
			'date' => date('Y-m-d H:i:s')
		);

		$ceklog = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM log WHERE uid_siswa = '" . $id_siswa . "' AND uid_jadwal = '" . $_SESSION['uid_jadwal'] . "' AND `type` = 'testongoing'"));

		if ($ceklog == 1) {
			update('log', $logdata, array(
				'uid_siswa' => $siswa['uid_siswa'],
				'uid_jadwal' => $_SESSION['uid_jadwal'],
				'type' => 'testongoing',
			));
		}

		$response = [
			'action' => '/logout'
		];
	}
} else {
	$response = ['error' => 'Ops... Tidak ada yang terjadi!!!'];
	http_response_code(404);
}
echo json_encode($response);
