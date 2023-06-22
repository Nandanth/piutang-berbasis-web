<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}


require 'functions.php';
$id_piutang = $_GET["id"];



$query_piutang = query(" SELECT * FROM tabel_piutang WHERE id = $id_piutang ")[0];


    //cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    

    //cek data berhasil ditambahkan atau tidak
   if( edit_data_piutang($_POST) > 0 ) {
       echo "
            <script>
                alert('Perubahan Data berhasil disimpan!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Perubahan Data gagal disimpan!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
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
    <title>Edit Data Piutang</title>

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">


<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<style type="text/css">
    body{
        background-color: #FFF0F5;
    }
    .card-body {
        margin: 100px auto;
        width: 400px;
        padding: 50px;
        border: 1px solid #ccc;
        background: #6495ED;
    }
    
 
</style>

</head>

<body>
    <h1 class="text-center">Edit Data Piutang</h1>

    <form action="" method="post">
    <input type="hidden" name="id_piutang" value="<?= $id_piutang; ?>">
        
    <div class="card-body">
      
             <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="nomor_invoice" class="input-group-text">Nomor Invoice : </label>
                <input type="text" name="nomor_invoice" id="nomor_invoice" required value="<?= $query_piutang["nomor_invoice"]; ?>">
            </div>

            <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="tanggal_piutang" class="input-group-text">Tanggal Piutang: </label>
                <input type="date" name="tanggal_piutang" id="tanggal_piutang" required value="<?= $query_piutang["tanggal_piutang"]; ?>">
            </div>

           <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="tanggal_tempo" class="input-group-text">Tanggal Jatuh Tempo : </label>
                <input type="date" name="tanggal_tempo" id="tanggal_tempo" required value="<?= $query_piutang["tanggal_tempo"]; ?>">
          </div>

          <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="nominal" class="input-group-text">Nominal : </label>
                <input type="text" name="nominal" id="nominal" required value="<?= $query_piutang["nominal"]; ?>">
           </div>

          <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="sisa_piutang" class="input-group-text">Sisa Piutang: </label>
                <input type="text" name="sisa_piutang" id="sisa_piutang" required value="<?= $query_piutang["sisa_piutang"]; ?>">
            </div>

                <button type="submit" name="submit" class="btn btn-primary">Edit Data</button>
        
    </div>
    </form>


    <!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>