<?php 

//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "piutang_web");



function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }

    return $rows;
}


function tambah_data_customer($data_customer) {
    global $conn;


    $nama_customer = htmlspecialchars($data_customer["nama_customer"]);
    $alamat = htmlspecialchars($data_customer["alamat"]);
    $no_telp = htmlspecialchars($data_customer["no_telp"]);
    

    //query insert data
    $query = "INSERT INTO tabel_customer
    VALUES ('', '$nama_customer', '$alamat', '$no_telp')
    ";
        

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

    
}


function tambah_data_piutang($data_piutang) {
    global $conn;

    
    $id_customer = ($data_piutang["id_tabel_customer"]);
    $nomor_invoice = htmlspecialchars($data_piutang["nomor_invoice"]);
    $tanggal_piutang = htmlspecialchars($data_piutang["tanggal_piutang"]);
    $tanggal_tempo = htmlspecialchars($data_piutang["tanggal_tempo"]);
    $nominal = htmlspecialchars($data_piutang["nominal"]);
    $sisa_piutang = htmlspecialchars($data_piutang["sisa_piutang"]);
    
    //insert data
    
    

    $query = "INSERT INTO tabel_piutang 
    (id, id_customer, nomor_invoice, tanggal_piutang, tanggal_tempo, nominal, sisa_piutang)
    VALUES ('', '$id_customer', '$nomor_invoice', '$tanggal_piutang', '$tanggal_tempo', '$nominal', '$sisa_piutang')
    ";

     mysqli_query($conn, $query);
    
     

    return mysqli_affected_rows($conn);


}


function hapus_data_customer($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM tabel_customer WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function hapus_data_piutang($id_piutang) {
    global $conn;
    mysqli_query($conn, "DELETE FROM tabel_piutang WHERE id = $id_piutang");
    
    return mysqli_affected_rows($conn);
}

function edit_data_customer($data) {
        global $conn;

        $id = $data["id"];
        $nama_customer = htmlspecialchars($data["nama_customer"]);
        $alamat = htmlspecialchars($data["alamat"]);
        $no_telp = htmlspecialchars($data["no_telp"]);
        


        //query insert data
        $query = "UPDATE tabel_customer SET
                    nama_customer = '$nama_customer',
                    alamat = '$alamat',
                    no_telp = '$no_telp'
                WHERE id = $id
            ";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function edit_data_piutang($query_piutang) {
        global $conn;
    
        $id = $query_piutang["id_piutang"];
        
        $nomor_invoice = htmlspecialchars($query_piutang["nomor_invoice"]);
        $tanggal_piutang = htmlspecialchars($query_piutang["tanggal_piutang"]);
        $tanggal_tempo = htmlspecialchars($query_piutang["tanggal_tempo"]);
        $nominal = htmlspecialchars($query_piutang["nominal"]);
        $sisa_piutang = htmlspecialchars($query_piutang["sisa_piutang"]);
        
        
        
        
    
        //query insert data
        $hasil_query_piutang = "UPDATE tabel_piutang SET
                    nomor_invoice = '$nomor_invoice',
                    tanggal_piutang = '$tanggal_piutang',
                    tanggal_tempo = '$tanggal_tempo',
                    nominal = '$nominal',
                    sisa_piutang = '$sisa_piutang'
                WHERE id = $id
            ";

   mysqli_query($conn, $hasil_query_piutang);

        return mysqli_affected_rows($conn);
    
    
    }

    // function cari($keyword) {
    //     $query = "SELECT * FROM piutang
    //             WHERE 
    //             nama LIKE '%$keyword%' OR
    //             nomor_invoice LIKE '%$keyword%' OR
    //             tanggal_input LIKE '%$keyword%'OR
    //             tanggal_tempo LIKE '%$keyword%' OR
    //             umur_piutang LIKE '%$keyword%' OR
    //             nominal LIKE '%$keyword%' OR
    //             sisa_piutang LIKE '%$keyword%' 
    //             ";
    //         return query($query);
    // }


    function registrasi($data) {
        global $conn;

        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);

        //cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");       

        if( mysqli_fetch_assoc($result) ) {
            echo "<script>
                    alert('Username sudah terdaftar!');
            </script>";
            return false;
        }

        //cek konfrimasi password
        if( $password !== $password2 ) {
            echo "<script> 
                    alert('Konfirmasi Password Tidak Sesuai!');
              </script>";
              return false;
        }

            //enkripsi password
            $password = password_hash($password, PASSWORD_DEFAULT);
            

            //tambahkan user baru ke database
            mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

            return mysqli_affected_rows($conn);

    }


function selisih($tgl_input_data, $tgl_jatuh_tempo)
{
    $now = date("Y-m-d");

    $tgl1 = new DateTime($now);
    $tgl2 = new DateTime($tgl_jatuh_tempo);
    $d = $tgl2->diff($tgl1)->days;

    
    $selisih = '';
    

    if($d < 1){
        $d = 0;
    }

    if($d < 2){
        $selisih = "<span style='color:red;'><b><i>Sudah Jatuh Tempo</i></b></span>";
    }else{
        $selisih = $d." hari";
    } 

    if($tgl2 < $tgl1) {
        $selisih = "<span style='color:blue;'><b><i>Sudah Lewat Jatuh Tempo</i></b></span>";

    }
    
    return $selisih;
    // return  $now;
}

function pembayaran($data_tabel_pembayaran) {
    global $conn;

    $id_pelanggan = ($data_tabel_pembayaran["id_tabel_pembayaran"]);
    $tanggal_bayar = htmlspecialchars($data_tabel_pembayaran["tanggal_bayar"]);
    $jumlah_bayar = htmlspecialchars($data_tabel_pembayaran["jumlah_bayar"]);
    $metode_bayar = htmlspecialchars($data_tabel_pembayaran["metode_bayar"]);
    $ket_bayar = htmlspecialchars($data_tabel_pembayaran["ket_bayar"]);

    $query = "INSERT INTO tabel_pembayaran 
    (id, id_pelanggan, tanggal_bayar, jumlah_bayar, metode_bayar, ket_bayar)
    VALUES ('', '$id_pelanggan', '$tanggal_bayar', '$jumlah_bayar', '$metode_bayar', '$ket_bayar')
    ";

     mysqli_query($conn, $query);
    
     

    return mysqli_affected_rows($conn);

}
	

// function saldo($data){
//     global $conn;

//     $id = $data["id"];
//     $nama = htmlspecialchars($data["nama"]);
//     $nomor_invoice = htmlspecialchars($data["nomor_invoice"]);
//     $tanggal_input = htmlspecialchars($data["tanggal_input"]);
//     $tanggal_tempo = htmlspecialchars($data["tanggal_tempo"]);
//     $umur_piutang = htmlspecialchars($data["umur_piutang"]);
//     $nominal = htmlspecialchars($data["nominal"]);
//     $sisa_piutang = htmlspecialchars($data["sisa_piutang"]);
//     $jumlah_pembayaran = htmlspecialchars($data["jumlah_pembayaran"]);
//     $tanggal_bayar = htmlspecialchars($data["tanggal_bayar"]);
//     $metode_pembayaran = htmlspecialchars($data["metode_pembayaran"]);
//     $ket_pembayaran = htmlspecialchars($data["ket_pembayaran"]);


//     //query insert data
//     $query = "UPDATE piutang SET
//                 nama = '$nama',
//                 nomor_invoice = '$nomor_invoice',
//                 tanggal_input = '$tanggal_input',
//                 tanggal_tempo = '$tanggal_tempo',
//                 umur_piutang = '$umur_piutang',
//                 nominal = '$nominal',
//                 sisa_piutang = '$sisa_piutang',
//                 jumlah_pembayaran = '$jumlah_pembayaran',
//                 tanggal_bayar = '$tanggal_bayar',
//                 metode_pembayaran = '$metode_pembayaran',
//                 ket_pembayaran = '$ket_pembayaran'
//             WHERE id = $id
//         ";

//     mysqli_query($conn, $query);

//     return mysqli_affected_rows($conn);

// }
    

// function rincian($data){
//     global $conn;
    
//     $query = "SELECT * FROM piutang
//                  nama = '$nama',
//                 nomor_invoice = '$nomor_invoice',
//                 tanggal_input = '$tanggal_input',
//                 tanggal_tempo = '$tanggal_tempo',
//                 umur_piutang = '$umur_piutang',
//                 nominal = '$nominal',
//                 sisa_piutang = '$sisa_piutang',
//                 jumlah_pembayaran = '$jumlah_pembayaran',
//                 tanggal_bayar = '$tanggal_bayar',
//                 metode_pembayaran = '$metode_pembayaran',
//                 ket_pembayaran = '$ket_pembayaran'
    
//      WHERE id = $id
//      ";
   
// }







?>