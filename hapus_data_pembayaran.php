<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


$id_bayar = $_GET["id"];

$query_pembayaran = query(" SELECT * FROM tabel_pembayaran WHERE id = $id_bayar ")[0];


if( hapus_data_pembayaran($id_bayar) > 0 ) {
    echo "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'form_pembayaran.php?id=".$query_pembayaran['id_pelanggan']."';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'form_pembayaran.php?id=".$query_pembayaran['id_pelanggan']."';
             </script>
    ";
}



?>