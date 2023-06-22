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

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.rtl.min.css">


<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


</head>
<body>
<div class="card text-center">
  <div class="card-header">
    <h1 class="text-center">Tambah Data Customer</h1>
    </div>
    
    <form action="" method="post">
    
   <div class="card-body">
      

        
        <div class="card border-primary mb-3" style="max-width: 20rem;" >
                <label for="nama_customer" class="input-group-text" >Nama  </label>
                <input type="text" name="nama_customer" id="nama_customer" placeholder="Masukkan Nama" required>
           
            </div>

            <div class="card border-primary mb-3 " style="max-width: 20rem;">
                <label for="alamat" class="input-group-text">Alamat </label>
                <input type="text" name="alamat" id="alamat" placeholder="Masukkan Alamat" required>
                </div>

             <div class="card border-primary mb-3" style="max-width: 20rem;">
                <label for="no_telp" class="input-group-text">No. Telp  </label>
                <input type="text" name="no_telp" id="no_telp" placeholder="Masukkan No. Telp" required>
             </div>

        
           
            

            
                <button type="submit" name="submit" class="btn btn-primary">Tambahkan Data</button>
            

       
        </div>
    </form>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>