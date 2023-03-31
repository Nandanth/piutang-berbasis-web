<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}


require 'functions.php';
$id_tabel_customer = $_GET["id"];



    //cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    

    //cek data berhasil ditambahkan atau tidak
   if( tambah_data_piutang($_POST) > 0 ) {
       echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'daftar_piutang.php?id=".$id_tabel_customer."';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'daftar_piutang.php?id=".$id_tabel_customer."';
             </script>
    ";
   }

   
}


 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Piutang</title>
</head>
<body>
    <h1>Tambah Data Customer</h1>

    <form action="" method="post">
        <ul>

 
            <li>
                <label for="nomor_invoice">Nomor Invoice : </label>
                <input type="text" name="nomor_invoice" id="nomor_invoice" required>
                <input type="hidden" name="id_tabel_customer" value="<?= $id_tabel_customer ?>">
                
            </li>

            <li>
                <label for="tanggal_piutang">Tanggal Piutang: </label>
                <input type="date" name="tanggal_piutang" id="tanggal_piutang" required>
            </li>

            <li>
                <label for="tanggal_tempo">Tanggal Jatuh Tempo : </label>
                <input type="date" name="tanggal_tempo" id="tanggal_tempo" required>
            </li>

            <li>
                <label for="nominal">Nominal : </label>
                <input type="text" name="nominal" id="nominal" required>
            </li>

            <li>
                <label for="sisa_piutang">Sisa Piutang: </label>
                <input type="text" name="sisa_piutang" id="sisa_piutang" required>
            </li>

            

            <li>
                <button type="submit" name="submit">Tambahkan Data</button>
            </li>

        </ul>
    </form>

</body>
</html>