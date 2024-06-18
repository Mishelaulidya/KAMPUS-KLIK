<?php

    include "koneksi.php";

    $proses = mysqli_query($koneksi, "SELECT * FROM mahasiswa") or die (mysqli_error ($koneksi));

?>