<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Penghitung BMI</title>
</head>

<body>
         <h1>Aplikasi Penghitung BMI</h1>

    <form method="POST" action="">
            <label for="berat">Berat Badan (kg)   : </label> 
            <input type="number" name="weight"> <br>
            <br>
            <label for="tinggi">Tinggi Badan (cm) : </label>
            <input type="number"  name="height">
            <br><br>
            <input type="submit" value="Hitung BMI">
    </form>

         <h3>Hasil Perhitungan : </h3>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $weight  = $_POST['weight'];
            $height = $_POST['height'];

            $height_total = $height / 100;
            $bmi = $weight  / ($height_total * $height_total);

            echo "Berat Badan  : $weight <br>";
            echo "Tinggi Badan : $height <br>";
            echo "BMI          : ", round ($bmi, 2), "<br>";
            echo "Kategori BMI : ";

            if ($bmi <= 17) {
                echo "Sangat Kurus";
            } else if ($bmi <= 18.5) {
                echo "Kurus";
            } else if ($bmi <= 25.0) {
                echo "Normal";
            } else if ($bmi <= 27.5) {
                echo "Gemuk (Overweight)";
            } else if ($bmi >  27.5) {
                echo "Gemuk (Obesitas)";
            }
        }
    ?>
</body>
</html>
