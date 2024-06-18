<?php

    $hostname = "localhost";
    $userDataBase = "root";
    $passwordUser = "";
    $databaseName = "kuliah_pemrograman_web";

    $koneksi = mysqli_connect($hostname,$userDataBase,$passwordUser,$databaseName) or die (mysqli_error());

    // if($koneksi){
    //     echo "berhasil";
    // }else echo "gagal";

?>