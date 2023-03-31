<?php
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}


require 'functions.php';

$data_customer = query("
SELECT * FROM tabel_customer");


//tombol cari ditekan
if ( isset($_POST["cari"]) ) {
    $data_customer = cari($_POST["keyword"]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>
</head>
<body>
   
<a href="logout.php">Log Out</a>

<h1>Daftar Piutang</h1>
<a href="tambah_data_customer.php">Tambah Data Customer</a>
<br><br>


<form action="" method="post">
    <input type="text" name="keyword" size="30" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off">
    <button type="submit" name="cari">Search!</button>
</form>

<br>



<table border="1" cellpadding="10" cellspacing="0"> 

    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No. Telp</th>
        
    </tr>
<?php $i = 1; ?>
<?php foreach( $data_customer as $row) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td>
            <a href="edit_data_customer.php?id=<?= $row["id"]; ?>">Edit Data Customer</a> |
            <a href="daftar_piutang.php?id=<?= $row["id"]; ?>">Daftar Piutang</a> |
            <a href="hapus_data_customer.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin untuk menghapus?');">delete</a> 
            
        </td>
        <td><?= $row["nama_customer"]; ?></td>
        <td><?= $row["alamat"]; ?></td>
        <td><?= $row["no_telp"]; ?></td>
        
        

        
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>
</table>
<?php ;?>


</body>
</html>