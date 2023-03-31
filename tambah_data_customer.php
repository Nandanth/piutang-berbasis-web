<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


    //cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    
    //cek data berhasil ditambahkan atau tidak
   if( tambah_data_customer($_POST) > 0 ) {
       echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Data gagal ditambahkan!');
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
    <title>Tambah Data customer</title>
</head>
<body>
    <h1>Tambah Data Customer</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="nama_customer">Nama : </label>
                <input type="text" name="nama_customer" id="nama_customer" required>
            </li>

            <li>
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat" required>
            </li>

            <li>
                <label for="no_telp">No. Telp : </label>
                <input type="text" name="no_telp" id="no_telp" required>
            </li>

            

            <li>
                <button type="submit" name="submit">Tambahkan Data</button>
            </li>

        </ul>
    </form>

</body>
</html>