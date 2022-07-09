<?php 
    error_reporting(0);
    include 'db.php';
    $kontak = mysqli_query($conn, "SELECT no_telepon, email, alamat FROM tb_admin WHERE admin_id = 1");
    $a = mysqli_fetch_object($kontak);

    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id = '".$_GET['id']."' ");
    $p = mysqli_fetch_object($produk);
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
    <h1><a href="index.php">Warungonline</a></h1>
    <ul>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
    </div>
   </header>
   
   <!-- search -->
   <div class="search">
    <div class="container">
        <form action="produk.php">
            <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search'] ?>">
            <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
            <input type="submit" name="cari" value="Cari Produk">
        </form>
    </div>
   </div>

   <!-- produk detail -->
   <div class="section">
    <div class="container">
        <h3>Detail Produk</h3>
        <div class="box">
            <div class="col-2">
                <img src="produk/<?php echo $p->produk_image ?>" width="100%" alt="">
            </div>
            <div class="col-2">
                <h3><?php echo $p->produk_nama ?></h3>
                <h4>Rp. <?php echo number_format($p->harga) ?></h4>
                <p>Deskripsi : <br>
                    <?php echo $p->deskripsi ?>
                </p>
                <p><a href="https://api.whatsapp.com/send?phone=6281393439765&text=Hai Penjual, saya tertarik." target="_blank"><img width="50px" src="img/icon-whatsapp.png" alt="">Hubungi Penjual</a></p>
            </div>
        </div>
    </div>
   </div>

   <!-- footer -->
   <div class="footer">
   <div class="container">
    <h4>Alamat</h4>
    <p><?php echo $a->alamat ?></p>

    <h4>Email</h4>
    <p><?php echo $a->email ?></p>

    <h4>No. Hp</h4>
    <p><?php echo $a->no_telepon ?></p>
    <small>Copyright &copy; 2022 - Warungonline.</small>
   </div>
   </div>
</body>
</html>