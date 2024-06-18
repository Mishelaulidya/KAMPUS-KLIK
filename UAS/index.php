<?php
include "tampilkan_data.php";
include "koneksi.php";

// Inisialisasi variabel $search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk pencarian data mahasiswa berdasarkan NPM dengan prepared statement
if ($search != '') {
    $query = "SELECT * FROM mahasiswa WHERE npm = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $query = "SELECT * FROM mahasiswa";
    $result = mysqli_query($koneksi, $query);
}

// Memeriksa apakah query sukses dieksekusi
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="library/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="library/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="library/assets/styles.css" rel="stylesheet" media="screen">
    <script src="library/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
    <div class="span9" id="content">
        <div class="row-fluid">
            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">Input Nilai Mahasiswa</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <form action="<?php echo isset($data_edit['id']) ? 'edit_data.php?id=' . $data_edit['id'] . '&proses=1' : 'percobaan8.php'; ?>" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Input Nilai Mahasiswa</legend>

                                <div class="control-group">
                                    <label class="control-label" for="NPM">NAMA MAHASISWA : </label>
                                    <div class="controls">
                                        <input type="text" class="input-xlarge focused" id="NPM" name="nama" value="<?php echo isset($data_edit['nama_mahasiswa']) ? $data_edit['nama_mahasiswa'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="NPM">NPM MAHASISWA : </label>
                                    <div class="controls">
                                        <input type="text" class="input-xlarge focused" id="NPM" name="npm" value="<?php echo isset($data_edit['npm']) ? $data_edit['npm'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="NPM">PRODI MAHASISWA : </label>
                                    <div class="controls">
                                        <input type="text" class="input-xlarge focused" id="NPM" name="prodi" value="<?php echo isset($data_edit['prodi']) ? $data_edit['prodi'] : ''; ?>">
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Proses</button>
                                    <button type="reset" class="btn">Batal</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">Data Mahasiswa</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <!-- Form pencarian mahasiswa -->
                        <form method="GET" action="" class="form-inline" onsubmit="return validateNPM()">
                            <div class="input-group">
                                <input type="text" name="search" id="npmInput" placeholder="Ketik NPM Mahasiswa" class="form-control" value="<?php echo $search; ?>">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </span>
                            </div>
                        </form>
                        <!-- Tabel data mahasiswa -->
                        <table class="table" id="mahasiswaTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NPM Mahasiswa</th>
                                    <th>Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop untuk menampilkan data mahasiswa
                                while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $data['id'] ?></td>
                                    <td><?php echo $data['nama_mahasiswa'] ?></td>
                                    <td><?php echo $data['npm'] ?></td>
                                    <td><?php echo $data['prodi'] ?></td>
                                    <td>
                                        <a href="edit_data.php?id=<?php echo $data['id']; ?>">Edit</a> | 
                                        <a href="hapus_data.php?id=<?php echo $data['id']; ?>">Hapus</a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi validasi NPM
        function validateNPM() {
            var npmInput = document.getElementById('npmInput').value;
            var npmRegex = /^\d{13}$/;

            if (!npmRegex.test(npmInput)) {
                if (isNaN(npmInput)) {
                    alert('NPM harus berupa angka.');
                } else if (npmInput.length < 13) {
                    alert('NPM kurang dari 13 digit.');
                } else {
                    alert('NPM lebih dari 13 digit.');
                }
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
