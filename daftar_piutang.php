<?php
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}


require 'functions.php';
$id_tabel_customer = $_GET["id"];

 //$query_cust = ("SELECT * FROM tabel_customer WHERE id = $id_tabel_customer");

 



$data_piutang = query("
SELECT
    tabel_piutang.id as id_piutang,
    tabel_piutang.id_customer as id_customer,
    tabel_piutang.nomor_invoice as no_invoice,
    tabel_piutang.tanggal_piutang as tanggal_input_piutang,
    tabel_piutang.tanggal_tempo as tanggal_jatuh_tempo,
    tabel_piutang.umur_piutang as umur_piutang,
    tabel_piutang.nominal as nominal_utang,
    tabel_piutang.sisa_piutang as sisa_piutang,

    tabel_customer.nama_customer as nama_customer,
    tabel_customer.alamat as alamat,
    tabel_customer.no_telp as no_telp


 FROM tabel_piutang
 LEFT JOIN tabel_customer ON tabel_customer.id = tabel_piutang.id_customer  
 WHERE tabel_piutang.id_customer = ".$id_tabel_customer."
 ");

 //$data_cust = mysqli_fetch_assoc(mysqli_query($conn, $data_piutang));

//  print_r($data_piutang);
//  die();

//tombol cari ditekan
if ( isset($_POST["cari_piutang"]) ) {
    $data_cari_piutang = cari_piutang($_POST["keyword_piutang"]);
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
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">
    

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>
<body>
   
<a class="btn btn-dark" href="index.php" role="button">Halaman Utama</a>

<h1>Daftar Piutang</h1>
<a class="btn btn-success" href="tambah_data_piutang.php?id=<?= $id_tabel_customer ?>" role="button">Tambah Data Piutang</a>
<br><br>


<form action="" method="post">
    <input type="text" name="keyword_piutang" size="30" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off">
    <button type="submit" name="cari_piutang" class="btn btn-secondary">Search!</button>
</form>

<br>



<table border="1" cellpadding="10" cellspacing="0" class="table table-striped"> 

<h1>Nama: <?= isset($data_piutang[0]["nama_customer"])?$data_piutang[0]["nama_customer"]:''; ?></h1>
<h1>Alamat: <?= isset($data_piutang[0]["alamat"])?$data_piutang[0]["alamat"]:''; ?></h1>
<h1>No. Telp: <?= isset($data_piutang[0]["no_telp"])?$data_piutang[0]["no_telp"]:''; ?></h1> 

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
            <a class="btn btn-warning" href="edit_data_piutang.php?id=<?= $piutang['id_piutang']; ?>" role="button">Edit Data Piutang</a> 
            <a class="btn btn-danger" href="hapus_data_piutang.php?id=<?= $piutang['id_piutang']; ?>" onclick="return confirm('Yakin untuk menghapus?');" role="button">delete</a> 
            
        </td>
        <td><?= $piutang["no_invoice"]; ?> </td>
        <td><?= $piutang["tanggal_input_piutang"]; ?> </td>
        <td><?= $piutang["tanggal_jatuh_tempo"]; ?> </td>
        <td><?= selisih($piutang["tanggal_input_piutang"], $piutang["tanggal_jatuh_tempo"]); ?></td>
        <td><?= $piutang["nominal_utang"]; ?></td>
        <td><?= $piutang["sisa_piutang"]; ?></td>
        <td> <a class="btn btn-primary" href="form_pembayaran.php?id=<?= $piutang['id_piutang']; ?>" role="primary">Form Pembayaran</a></td>

        
        

        
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>
</table>
<?php ;?>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>