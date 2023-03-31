<?php
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}


require 'functions.php';
$id_tabel_customer = $_GET["id"];

$query_cust = ("SELECT * FROM tabel_customer WHERE id = $id_tabel_customer");



$data_cust = mysqli_fetch_assoc(mysqli_query($conn, $query_cust));

$data_piutang = query("
SELECT
    tabel_piutang.id as id_piutang,
    tabel_piutang.id_customer as id_customer,
    tabel_piutang.nomor_invoice as no_invoice,
    tabel_piutang.tanggal_piutang as tanggal_input_piutang,
    tabel_piutang.tanggal_tempo as tanggal_jatuh_tempo,
    tabel_piutang.umur_piutang as umur_piutang,
    tabel_piutang.nominal as nominal_utang,
    tabel_piutang.sisa_piutang as sisa_piutang

 FROM tabel_piutang
 LEFT JOIN tabel_customer ON tabel_customer.id = tabel_piutang.id_customer
 WHERE tabel_piutang.id_customer = ".$id_tabel_customer."
 ");

// //tombol cari ditekan
// if ( isset($_POST["cari"]) ) {
//     $data_piutang = cari($_POST["keyword"]);
// }

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
   
<a href="index.php">Halaman Utama</a>

<h1>Daftar Piutang</h1>
<a href="tambah_data_piutang.php?id=<?= $id_tabel_customer ?>">Tambah Data Piutang</a>
<br><br>


<form action="" method="post">
    <input type="text" name="keyword" size="30" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off">
    <button type="submit" name="cari">Search!</button>
</form>

<br>



<table border="1" cellpadding="10" cellspacing="0"> 

<h1>Nama: <?= $data_cust["nama_customer"]; ?></h1>
<h1>Alamat: <?= $data_cust["alamat"]; ?></h1>
<h1>No. Telp: <?= $data_cust["no_telp"]; ?></h1> 

    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Nomor Invoice</th>
        <th>Tanggal Input Data</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Jangka Waktu Piutang</th>
        <th>Nominal</th>
        <th>Sisa Piutang</th>
        <th>Pembayaran</th>
        
    </tr>
<?php $i = 1; ?>
<?php foreach( $data_piutang as $piutang) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td>
            <a href="edit_data_piutang.php?id=<?= $piutang['id_piutang']; ?>">Edit Data Piutang</a> |
            <a href="hapus_data_piutang.php?id=<?= $piutang['id_piutang']; ?>" onclick="return confirm('Yakin untuk menghapus?');">delete</a> 
            
        </td>
        <td><?= $piutang["no_invoice"]; ?> </td>
        <td><?= $piutang["tanggal_input_piutang"]; ?> </td>
        <td><?= $piutang["tanggal_jatuh_tempo"]; ?> </td>
        <td><?= selisih($piutang["tanggal_input_piutang"], $piutang["tanggal_jatuh_tempo"]); ?></td>
        <td><?= $piutang["nominal_utang"]; ?></td>
        <td><?= $piutang["sisa_piutang"]; ?></td>
        <td> <a href="form_pembayaran.php?id=<?= $piutang['id_piutang']; ?>">Form Pembayaran</a></td>

        
        

        
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>
</table>
<?php ;?>


</body>
</html>