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

function cari_customer($keyword_customer) {
    $query_cari_customer = "SELECT * FROM tabel_customer
            WHERE 
            nama_customer LIKE '%$keyword_customer%' OR
            alamat LIKE '%$keyword_customer%' OR
            no_telp LIKE '%$keyword_customer%'
            ";
            
        return query($query_cari_customer);
}

  function cari_piutang($keyword_piutang) {

        $query_cari_piutang = "SELECT * FROM tabel_piutang
                WHERE 
                nomor_invoice LIKE '%$keyword_piutang%' OR
                tanggal_piutang LIKE '%$keyword_piutang%'OR
                tanggal_tempo LIKE '%$keyword_piutang%' OR
                umur_piutang LIKE '%$keyword_piutang%' OR
                nominal LIKE '%$keyword_piutang%' OR
                sisa_piutang LIKE '%$keyword_piutang%' 
                ";

           return query($query_cari_piutang);
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

   

    $id_pelanggan = $data_tabel_pembayaran["id_piutang"];
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

function hapus_data_pembayaran($id_bayar){

    global $conn;
    mysqli_query($conn, "DELETE FROM tabel_pembayaran WHERE id = $id_bayar");
    
    
    return mysqli_affected_rows($conn);
}

?>