<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


//ambil data di url
$id_piutang = $_GET["id"];


$data_tabel_pembayaran = query("
SELECT
    tabel_pembayaran.id as id_bayar,
    tabel_pembayaran.id_pelanggan as id_pelanggan,
    tabel_pembayaran.tanggal_bayar as tanggal_bayar,
    tabel_pembayaran.jumlah_bayar as jumlah_bayar,
    tabel_pembayaran.metode_bayar as metode_bayar,
    tabel_pembayaran.ket_bayar as ket_bayar,

    tabel_piutang.id_customer as id_customer,
    tabel_piutang.nomor_invoice as nomor_invoice,
    tabel_piutang.tanggal_piutang as tanggal_piutang,
    tabel_piutang.tanggal_tempo as tanggal_tempo,
    tabel_piutang.umur_piutang as umur_piutang,
    tabel_piutang.nominal as nominal,
    tabel_piutang.sisa_piutang as sisa_piutang,
    
    tabel_customer.id as id_tabel_customer,
    tabel_customer.nama_customer as nama_customer
    
 FROM tabel_pembayaran
 LEFT JOIN tabel_piutang ON tabel_piutang.id = tabel_pembayaran.id_pelanggan
 LEFT JOIN tabel_customer ON tabel_customer.id = tabel_piutang.id_customer
 WHERE tabel_pembayaran.id_pelanggan = ".$id_piutang."
 ORDER BY tabel_pembayaran.id ASC

 ");

// print_r($data_tabel_pembayaran);
// die();

 
 
header("content-type: application/vnd-ms-excel");
header("content-Disposition: attachment; filename=laporan-bukti-pembayaran.xls");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form dan Hasil Pembayaran</title>



</head>
<body>
    
    <h1 class="text-center">Bukti Pembayaran</h1> <br>


    <h3>Nama : <?= isset($data_tabel_pembayaran[0]["nama_customer"])?$data_tabel_pembayaran[0]["nama_customer"]:''; ?></h3>
    <h3>Nomor Invoice : <?= isset($data_tabel_pembayaran[0]["nomor_invoice"])?$data_tabel_pembayaran[0]["nomor_invoice"]:''; ?></h3>
    <h3>Tanggal Input Data : <?= isset($data_tabel_pembayaran[0]["tanggal_piutang"])?$data_tabel_pembayaran[0]["tanggal_piutang"]:''; ?></h3>
    <h3>Tanggal Jatuh Tempo : <?= isset($data_tabel_pembayaran[0]["tanggal_tempo"])?$data_tabel_pembayaran[0]["tanggal_tempo"]:''; ?></h3>
    <h3>Nominal : <?= isset($data_tabel_pembayaran[0]["nominal"])?$data_tabel_pembayaran[0]["nominal"]:''; ?></h3>



     <hr color="blue">

<table border="1" cellpadding="10" cellspacing="0"> 
     <tr>
        <th>No.</th>
        <th>Tanggal Pembayaran</th>
        <th>Jumlah Pembayaran</th>
        <th>Metode Pembayaran</th>
        <th>Keterangan Pembayaran</th>
     </tr>


     <?php $i = 1; ?>
<?php foreach( $data_tabel_pembayaran as $data_bayar) : ?>
    <tr>
        <td><?= $i++; ?></td>
        <td><?= $data_bayar ["tanggal_bayar"]; ?> </td>
        <td><?= $data_bayar["jumlah_bayar"]; ?> </td>
        <td><?= $data_bayar["metode_bayar"]; ?> </td>
        <td><?= $data_bayar["ket_bayar"]; ?></td>
        
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>
</table>
<?php ;?>


</body>
</html>