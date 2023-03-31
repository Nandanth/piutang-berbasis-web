<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


//ambil data di url
$id = $_GET["id"];

//query data berdasarkan id
$datacs = query("SELECT * FROM tabel_customer WHERE id = $id")[0];


    //cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    //cek data berhasil diubah atau tidak
   if( edit_data_customer($_POST) > 0 ) {
       echo "
            <script>
                alert('Perubahan data berhasil disimpan');
                document.location.href = 'index.php';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Perubahan data gagal disimpan');
                document.location.href = 'index.php';
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
    <title>Edit Data Customer</title>
</head>
<body>
    <h1>Edit Data Customer</h1>

    <form action="" method="post">
            <input type="hidden" name="id" value="<?= $datacs["id"]; ?>">
        
        <ul>
            <li>
                <label for="nama_customer">Nama : </label>
                <input type="text" name="nama_customer" id="nama_customer" required value="<?= $datacs["nama_customer"]; ?>">
            </li>

            <li>
                <label for="alamat">Alamat : </label>
                <input type="text" name="alamat" id="alamat" required value="<?= $datacs["alamat"]; ?>">
            </li>

            <li>
                <label for="no_telp">No. Telp : </label>
                <input type="text" name="no_telp" id="no_telp" required value="<?= $datacs["no_telp"]; ?>">
            </li>

            

            <li>
                <button type="submit" name="submit">Edit Data Customer</button>
            </li>

        </ul>
    </form>

</body>
</html>