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


 <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">


<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">



</head>
<body>
    
    <h1 class="text-center">Bukti Pembayaran</h1> <br>

    <a class="btn btn-success" href="daftar_piutang.php?id=<?= isset($data_tabel_pembayaran[0]['id_customer'])?$data_tabel_pembayaran[0]['id_customer']:''; ?>" class="back">Kembali ke Halaman Daftar Piutang </a>  

    <a class="btn btn-secondary" href="print_pdf.php?id=<?= $id_piutang?>" target="_blank"><i class="bi bi-printer-fill"></i> PDF <i class="bi bi-file-earmark-pdf-fill"></i> </a>
    <a class="btn btn-secondary" href="excel.php?id=<?= $id_piutang?>" target="_blank"><i class="bi bi-printer-fill"></i> EXCELL <i class="bi bi-file-earmark-excel-fill"></i> </a>

    <h3>Nama : <?= isset($data_tabel_pembayaran[0]["nama_customer"])?$data_tabel_pembayaran[0]["nama_customer"]:''; ?></h3>
    <h3>Nomor Invoice : <?= isset($data_tabel_pembayaran[0]["nomor_invoice"])?$data_tabel_pembayaran[0]["nomor_invoice"]:''; ?></h3>
    <h3>Tanggal Input Data : <?= isset($data_tabel_pembayaran[0]["tanggal_piutang"])?$data_tabel_pembayaran[0]["tanggal_piutang"]:''; ?></h3>
    <h3>Tanggal Jatuh Tempo : <?= isset($data_tabel_pembayaran[0]["tanggal_tempo"])?$data_tabel_pembayaran[0]["tanggal_tempo"]:''; ?></h3>
    <h3>Nominal : <?= isset($data_tabel_pembayaran[0]["nominal"])?$data_tabel_pembayaran[0]["nominal"]:''; ?></h3>

    <form action="" method="post">
            <input type="hidden" name="id_piutang" value="<?= $id_piutang ?>">
        
        <ul class="form">

             <li>
                <label for="sisa_piutang" class="fs-4">Sisa Piutang : </label>
                <input type="number" name="sisa_piutang" id="sisa_piutang" value="<?= $data_tabel_pembayaran[0]["sisa_piutang"]; ?>" readonly>
            </li>

            <li>
                <label for="tanggal_bayar" class="fs-4">Tanggal Pembayaran : </label>
                <input type="date" name="tanggal_bayar" id="tanggal_bayar">
            </li>

            <li>

                <label for="jumlah_bayar" class="fs-4">Jumlah Pembayaran </label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar">
                <button type="button" onclick="hitung()">Hitung</button>
            </li>

            <li>
                <label for="metode_bayar" class="fs-4">Metode Pembayaran </label>
                <select name="metode_bayar" id="metode_bayar">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="giro">Bilyet Giro</option>
                    <option value="jasa">Jasa</option> 
                    </select>

                    <label for="ket_bayar" class="fs-4">Keterangan Pembayaran</label>
                    <input type="textarea" name="ket_bayar" id="ket_bayar">
            </li>

           

            
                <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                <button type="submit" name="cancel" class="btn btn-danger">Cancel </button>
            

        </ul>
    </form>

     <hr color="blue">

<table border="1" cellpadding="10" cellspacing="0"> 
     <tr>
        <th>No.</th>
        <th class="aksi">Aksi</th>
        <th>Tanggal Pembayaran</th>
        <th>Jumlah Pembayaran</th>
        <th>Metode Pembayaran</th>
        <th>Keterangan Pembayaran</th>
     </tr>


     <?php $i = 1; ?>
<?php 
    foreach( $data_tabel_pembayaran as $data_bayar){?>
    <tr>
        <td><?= $i; ?></td>
        <td class="aksi"><a href="hapus_data_pembayaran.php?id=<?= $data_bayar["id_bayar"]; ?>" onclick="return confirm('Yakin untuk menghapus?');">delete</a></td>
        <td><?= $data_bayar ["tanggal_bayar"]; ?> </td>
        <td><?= $data_bayar["jumlah_bayar"]; ?> </td>
        <td><?= $data_bayar["metode_bayar"]; ?> </td>
        <td><?= $data_bayar["ket_bayar"]; ?></td>
        
    </tr>
<?php $i++; }?>
</table>
<?php ;?>


<script src="js/script.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



<script>
    function hitung(){
    const sisa_piutang = document.getElementById('sisa_piutang').value;
    const jumlah_bayar = document.getElementById('jumlah_bayar').value;

    if(jumlah_bayar >= 0 && jumlah_bayar <= sisa_piutang){
        var hitung_sisa_piutang = sisa_piutang-jumlah_bayar;
        document.getElementById('sisa_piutang').value = hitung_sisa_piutang;
    }else{
        alert("Nominal jumlah pembayaran tidak sesuai!");
    }
}


</script>

</body>
</html>