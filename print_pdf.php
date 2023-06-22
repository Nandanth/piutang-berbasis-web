<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';



//ambil data di url
$id_piutang = $_GET["id"];

//query data berdasarkan id


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
    
    tabel_customer.nama_customer as nama_customer

 FROM tabel_pembayaran
 LEFT JOIN tabel_piutang ON tabel_piutang.id = tabel_pembayaran.id_pelanggan
 LEFT JOIN tabel_customer ON tabel_customer.id = tabel_piutang.id_customer
 WHERE tabel_pembayaran.id_pelanggan = ".$id_piutang."
 ORDER BY tabel_pembayaran.id ASC
 
 ");

//  print_r($data_tabel_pembayaran);
//  die();

 $mpdf = new \Mpdf\Mpdf();


$html = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Cetak Pembayaran</title>
</head>
<body>
    <h1>Cetak Pembayaran</h1>
    <br>

    <h1>Nama: ". $data_tabel_pembayaran[0]['nama_customer'] ."</h1>
    <h1>Nomor Invoice : ". $data_tabel_pembayaran[0]['nomor_invoice'] ."</h1>
    <h1>Tanggal Input Data : ". $data_tabel_pembayaran[0]['tanggal_piutang'] ."</h1>
    <h1>Tanggal Jatuh Tempo : ". $data_tabel_pembayaran[0]['tanggal_tempo'] ."</h1>
    <h1>Nominal : ". $data_tabel_pembayaran[0]['nominal'] ."</h1>";
$html .= "<table border=1 cellpadding=10 cellspacing=0>
        <tr>
            <th>No.</th>
            <th>Tanggal Pembayaran</th>
            <th>Jumlah Pembayaran</th>
            <th>Metode Pembayaran</th>
            <th>Keterangan Pembayaran</th>
        </tr>";

    $i = 1;
    foreach( $data_tabel_pembayaran as $data_bayar) {
    $html .= "<tr>
        <td>". $i++ ."</td>
        <td>". $data_bayar["tanggal_bayar"] ." </td>
        <td>". $data_bayar["jumlah_bayar"] ." </td>
        <td>". $data_bayar["metode_bayar"] ." </td>
        <td>". $data_bayar["ket_bayar"] ." </td>
    </tr>";
    }

$html .= "</table>";

$html .= "</body>
</html>";



$mpdf->WriteHTML($html);
$mpdf->Output();
?>