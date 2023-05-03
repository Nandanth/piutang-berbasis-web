<?php 
    require '../functions.php';

    
 $keywordCustomer = $_GET["keywordCustomer"];

$query_cari_customer = "SELECT * FROM tabel_customer
    WHERE 
        nama_customer LIKE '%$keywordCustomer%' OR
        alamat LIKE '%$keywordCustomer%' OR
        no_telp LIKE '%$keywordCustomer%'
    ";

$cari_customer = query($query_cari_customer);

$data_customer = query("
SELECT * FROM tabel_customer");

?>

<table border="1" cellpadding="10" cellspacing="0"> 

<tr>
    <th>No.</th>
    <th>Aksi</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>No. Telp</th>
    
</tr>
<?php $i = 1; ?>
<?php foreach( $data_customer as $row) : ?>
<tr>
    <td><?= $i; ?></td>
    <td>
        <a href="edit_data_customer.php?id=<?= $row["id"]; ?>">Edit Data Customer</a> |
        <a href="daftar_piutang.php?id=<?= $row["id"]; ?>">Daftar Piutang</a> |
        <a href="hapus_data_customer.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin untuk menghapus?');">delete</a> 
        
    </td>
    <td><?= $row["nama_customer"]; ?></td>
    <td><?= $row["alamat"]; ?></td>
    <td><?= $row["no_telp"]; ?></td>
    
    

    
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
