<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
   <!-- header -->
   <header>
    <div class="container">
    <h1><a href="dashboard.php">Warungonline</a></h1>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="kategori.php">Data Kategori</a></li>
        <li><a href="data-produk.php">Data Produk</a></li>
        <li><a href="keluar.php">Keluar</a></li>
    </ul>
    </div>
   </header>
   
   <!-- konten  -->
   <div class="section">
    <div class="container">
        <h3>Produk</h3>
        <div class="box">
            <p><a href="tambah-produk.php">Tambah Produk</a></p>
            <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $produk = mysqli_query($conn, "SELECT * FROM produk LEFT JOIN kategori USING (kategori_id) ORDER BY produk_id DESC");
                        if(mysqli_num_rows($produk)){
                        while($row = mysqli_fetch_array($produk)){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['kategori_nama'] ?></td>
                        <td><?php echo $row['produk_nama'] ?></td>
                        <td>Rp. <?php echo number_format($row['harga']) ?></td>
                        <td><a href="produk/<?php echo $row['produk_image'] ?>" target="_blank"><img src="produk/<?php echo $row['produk_image'] ?>" width="50px" alt=""></a></td>
                        <td><?php echo ($row['status'] == 0)? 'Tidak Aktif':'Aktif'; ?></td>
                        <td>
                            <a href="edit-produk.php?id=<?php echo $row['produk_id'] ?>">Edit</a> || <a href="hapus-kategori.php?idp=<?php echo $row['produk_id'] ?>" onclick="return confirm('Yakin ingin menghapus data?') ">Hapus</a>
                        </td>
                    </tr>
                    <?php }}else{ ?>
                        <tr>
                            <td colspan="7">Tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
   </div>

   <!-- footer -->
   <footer>
   <div class="container">
    <small>Copyright &copy; 2022 - Warungonline.</small>
   </div>
   </footer>
</body>
</html>