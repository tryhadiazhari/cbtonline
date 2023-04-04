<?php
require("config/config.default.php");

$username = $_POST['username'];
$password = $_POST['password'];
$siswaQ = mysqli_query($koneksi, "SELECT * FROM hazedu_siswa WHERE uname = '" . $username . "'");

if ($username == "" and $password == "") {
	$datareg = [
		'error' => [
			'username' => 'Username tidak boleh kosong...',
			'password' => 'Password tidak boleh kosong...'
		]
	];
	http_response_code(404);
} else {
	if (mysqli_num_rows($siswaQ) == 0) {
		$datareg = [
			'error' => 'Username <b>' . $username . '</b> tidak ditemukan!',
		];
		http_response_code(400);
	} else {
		$siswa = mysqli_fetch_array($siswaQ);
		$ceklogin = mysqli_num_rows(mysqli_query($koneksi, "select * from login where id_siswa='$siswa[uid_siswa]'"));

		if ($password == $siswa['pword']) {
			if ($ceklogin == 0) {
				$datareg = [
					'success' => "Login berhasil...",
					'value' => $siswa['uid_siswa'],
				];

				$_SESSION['id_siswa'] = $siswa['uid_siswa'];
				$_SESSION['npsn'] = $siswa['npsn'];
				$_SESSION['username'] = $siswa['uname'];

				mysqli_query($koneksi, "INSERT INTO login (id_siswa, ipaddress) VALUES ('$siswa[uid_siswa]', '" . $_SERVER['REMOTE_ADDR'] . "')");
			} else {
				$datareg = [
					'error' => 'Siswa sudah aktif!!!'
				];
				http_response_code(400);
			}
		} else {
			$datareg = [
				'error' => 'Password salah!',
			];
			http_response_code(400);
		}
	}
}
echo json_encode($datareg);
