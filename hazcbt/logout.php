<?php
require("config/config.default.php");
session_destroy();

(!isset($_SESSION['id_siswa'])) ? header("Location: $homeurl/login") : $id_siswa = $_SESSION['id_siswa'];

($id_siswa <> "") ? mysqli_query($koneksi, "DELETE FROM log WHERE id_siswa='$id_siswa'") : null;
($id_siswa <> "") ? mysqli_query($koneksi, "DELETE FROM login WHERE id_siswa='$id_siswa'") : null;

header('location: ./');
