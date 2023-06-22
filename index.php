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
if ( isset($_POST["cari_customer"]) ) {
    $data_customer = cari_customer($_POST["keyword_customer"]);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>

     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">
    

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    

</head>
<body>
   <br>
<a class="btn btn-dark" href="logout.php" role="button">Log Out</a>

<br>

<h1>Daftar Customer</h1>
<a class="btn btn-success" href="tambah_data_customer.php" role="button">Tambah Data Customer</a>
<br><br>


<form action="" method="post">
    <input type="text" name="keyword_customer" size="30" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off" id="keyword_customer">
    <button type="submit" name="cari_customer" id="tombol-customer" class="btn btn-secondary">Search!</button>
</form>

<br>

<div id="container">

<table border="1" cellpadding="10" cellspacing="0" class="table table-striped"> 
<div class="row">
<div class="col">
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
            <a class="btn btn-warning" href="edit_data_customer.php?id=<?= $row["id"]; ?>" role="button">Edit Data Customer</a> 
            <a class="btn btn-primary" href="daftar_piutang.php?id=<?= $row["id"]; ?>" role="button">Daftar Piutang</a> 
            <a class="btn btn-danger" href="hapus_data_customer.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin untuk menghapus?');" role="button">delete</a> 
            
        </td>
        <td><?= $row["nama_customer"]; ?></td>
        <td><?= $row["alamat"]; ?></td>
        <td><?= $row["no_telp"]; ?></td>
        
        

        
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>
</table>
<?php ;?>
</div>
</div>
</div>

<script src="js/script.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>