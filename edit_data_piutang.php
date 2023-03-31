<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}


require 'functions.php';
$id_piutang = $_GET["id"];



$query_piutang = query(" SELECT * FROM tabel_piutang WHERE id = $id_piutang ")[0];


    //cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    

    //cek data berhasil ditambahkan atau tidak
   if( edit_data_piutang($_POST) > 0 ) {
       echo "
            <script>
                alert('Perubahan Data berhasil disimpan!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Perubahan Data gagal disimpan!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
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
    <title>Edit Data Piutang</title>
</head>
<body>
    <h1>Edit Data Piutang</h1>

    <form action="" method="post">
    <input type="hidden" name="id_piutang" value="<?= $id_piutang; ?>">
        <ul>

 
            <li>
                
                <label for="nomor_invoice">Nomor Invoice : </label>
                <input type="text" name="nomor_invoice" id="nomor_invoice" required value="<?= $query_piutang["nomor_invoice"]; ?>">
                
                
                
            </li>

            <li>
                <label for="tanggal_piutang">Tanggal Piutang: </label>
                <input type="date" name="tanggal_piutang" id="tanggal_piutang" required value="<?= $query_piutang["tanggal_piutang"]; ?>">
            </li>

            <li>
                <label for="tanggal_tempo">Tanggal Jatuh Tempo : </label>
                <input type="date" name="tanggal_tempo" id="tanggal_tempo" required value="<?= $query_piutang["tanggal_tempo"]; ?>">
            </li>

            <li>
                <label for="nominal">Nominal : </label>
                <input type="text" name="nominal" id="nominal" required value="<?= $query_piutang["nominal"]; ?>">
            </li>

            <li>
                <label for="sisa_piutang">Sisa Piutang: </label>
                <input type="text" name="sisa_piutang" id="sisa_piutang" required value="<?= $query_piutang["sisa_piutang"]; ?>">
            </li>

            

            <li>
                <button type="submit" name="submit">Edit Data</button>
            </li>

        </ul>
    </form>

</body>
</html>