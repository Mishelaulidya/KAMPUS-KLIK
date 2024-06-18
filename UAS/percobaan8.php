<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil nilai dari form
    $nama_mhs = $_POST['nama'];
    $prodi_mhs = $_POST['prodi'];
    $npm_mhs = $_POST['npm'];

    // Validasi NPM harus 13 digit angka
    if (!preg_match('/^\d{13}$/', $npm_mhs)) {
        echo "<script>
                alert('NPM harus terdiri dari 13 digit angka.');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Escape nilai untuk mencegah SQL Injection
    $nama_mhs = mysqli_real_escape_string($koneksi, $nama_mhs);
    $prodi_mhs = mysqli_real_escape_string($koneksi, $prodi_mhs);
    $npm_mhs = mysqli_real_escape_string($koneksi, $npm_mhs);

    // Query SQL untuk INSERT data mahasiswa dengan prepared statement
    $query = "INSERT INTO mahasiswa (nama_mahasiswa, npm, prodi) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nama_mhs, $npm_mhs, $prodi_mhs);

    // Eksekusi prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil disimpan');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

    // Tutup prepared statement dan koneksi
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
}
?>
