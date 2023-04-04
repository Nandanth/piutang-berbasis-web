<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


//ambil data di url
$id_piutang = $_GET["id"];

//query data berdasarkan id
$data_query_cust = query(" SELECT * FROM tabel_piutang WHERE id = $id_piutang ")[0];

 $data_tabel_pembayaran = query("
SELECT
    tabel_pembayaran.id as id_bayar,
    tabel_pembayaran.id_pelanggan as id_tabel_pembayaran,
    tabel_pembayaran.tanggal_bayar as tanggal_bayar,
    tabel_pembayaran.jumlah_bayar as jumlah_bayar,
    tabel_pembayaran.metode_bayar as metode_bayar,
    tabel_pembayaran.ket_bayar as ket_bayar
    
 FROM tabel_pembayaran
 LEFT JOIN tabel_piutang ON tabel_piutang.id = tabel_pembayaran.id_pelanggan
 WHERE tabel_pembayaran.id_pelanggan = ".$id_piutang."
 ");

 
  //cek tombol submit sudah ditekan atau belum
if( isset($_POST["kirim"]) ) {
    
    //cek data berhasil ditambahkan atau tidak
   if( pembayaran($_POST) > 0 ) {
      echo "
             <script>
                 alert('Data berhasil dikirim!');
                 document.location.href = 'form_pembayaran.php?id=".$id_piutang."';
             </script>
        ";
    } else {
        echo "
             <script>
                 alert('Data gagal dikirim!');
                 document.location.href = 'form_pembayaran.php?id=".$id_piutang."';
              </script>
     ";
    }

}


if( isset($_POST["cancel"]) ) {
    echo "
    <script>
        document.location.href = 'form_pembayaran.php?id=".$id_piutang."';
     </script>
";
    exit;
}
 

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
    <h1>Form Pembayaran</h1> <br>

    <a href="daftar_piutang.php?id=<?= $data_query_cust['id_customer']?>">Kembali ke Halaman Daftar Piutang</a> <br> <br>

    <h1>Nomor Invoice : <?= $data_query_cust["nomor_invoice"]; ?></h1>
    <h1>Tanggal Input Data : <?= $data_query_cust["tanggal_piutang"]; ?></h1>
    <h1>Tanggal Jatuh Tempo : <?= $data_query_cust["tanggal_tempo"]; ?></h1>
    <h1>Nominal : <?= $data_query_cust["nominal"]; ?></h1>

    <form action="" method="post">
            <input type="" name="id_piutang" value="<?= $id_piutang ?>">
        
        <ul>

             <li>
                <label for="sisa_piutang">Sisa Piutang : </label>
                <input type="number" name="sisa_piutang" id="sisa_piutang" value="<?= $data_query_cust["sisa_piutang"]; ?>" readonly>
            </li>

            <li>
                <label for="tanggal_bayar">Tanggal Pembayaran : </label>
                <input type="date" name="tanggal_bayar" id="tanggal_bayar">
            </li>

            <li>

                <label for="jumlah_bayar">Jumlah Pembayaran </label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar">
                <button type="button" onclick="hitung()">Hitung</button>
            </li>

            <li>
                <label for="metode_bayar">Metode Pembayaran </label>
                <select name="metode_bayar" id="metode_bayar">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="giro">Bilyet Giro</option>
                    <option value="jasa">Jasa</option> 
                    </select>

                    <label for="ket_bayar">Keterangan Pembayaran</label>
                    <input type="textarea" name="ket_bayar" id="ket_bayar">
            </li>

           

            <li>
                <button type="submit" name="kirim">Kirim</button>
                <button type="submit" name="cancel">Cancel </button>
            </li>

        </ul>
    </form>

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
        <td><?= $i; ?></td>
        
        <td><?= $data_bayar["tanggal_bayar"]; ?> </td>
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