<?php
include "koneksi.php";

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['proses']) && $_GET['proses'] == '1') {
    $nama_mahasiswa = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $npm = $_POST['npm'];

    // Validasi NPM harus 13 digit angka
    if (!preg_match('/^\d{13}$/', $npm)) {
        echo "<script>
                alert('NPM harus terdiri dari 13 digit angka.');
                window.location.href = 'edit_data.php?id=$id';
              </script>";
        exit;
    }

    // Menggunakan prepared statement untuk query update
    $query = "UPDATE mahasiswa SET nama_mahasiswa=?, prodi=?, npm=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $nama_mahasiswa, $prodi, $npm, $id);

    // Eksekusi prepared statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
}

// Query untuk mendapatkan data mahasiswa berdasarkan ID
$query = "SELECT * FROM mahasiswa WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Menutup statement setelah selesai mengambil data
mysqli_stmt_close($stmt);

// Menutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link href="library/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="library/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="library/assets/styles.css" rel="stylesheet" media="screen">
    <script src="library/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
    <h2>Edit Data Mahasiswa</h2>
    <?php
    // Tampilkan form dengan data mahasiswa yang akan diedit
    if ($data) {
        ?>
        <form method="POST" action="edit_data.php?id=<?php echo $id; ?>&proses=1" enctype="multipart/form-data">
            <label for="nama">Nama Mahasiswa:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama_mahasiswa']); ?>">
            <label for="npm">NPM Mahasiswa:</label>
            <input type="text" id="npm" name="npm" value="<?php echo htmlspecialchars($data['npm']); ?>">
            <label for="prodi">Prodi:</label>
            <input type="text" id="prodi" name="prodi" value="<?php echo htmlspecialchars($data['prodi']); ?>"><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "Data tidak ditemukan!";
    }
    ?>
</body>
</html>
