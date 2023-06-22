<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';


$id_piutang = $_GET["id"];

$query_piutang = query(" SELECT * FROM tabel_piutang WHERE id = $id_piutang ")[0];



if( hapus_data_piutang($id_piutang) > 0 ) {
    echo "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
            </script>
       ";
   } else {
       echo "
            <script>
                alert('Data gagal dihapus!');
                document.location.href = 'daftar_piutang.php?id=".$query_piutang['id_customer']."';
             </script>
    ";
}



?>