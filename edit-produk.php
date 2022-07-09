<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id = '".$_GET['id']."' ");
    if(mysqli_num_rows($produk) == 0){
        echo '<script>window.location="data-produk.php"</script>';
    }
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
        <h3>Edit Produk</h3>
        <div class="box">
            <form action="" method="POST" enctype="multipart/form-data">
                <select class="input-control" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY kategori_id DESC ");
                        while ($r = mysqli_fetch_array($kategori)) {
                    ?>
                    <option value="<?php echo $r['kategori_id'] ?>" <?php echo ($r['kategori_id'] == $p->kategori_id)? 'selected':''; ?> ><?php echo $r['kategori_nama'] ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="nama" placeholder="Nama Produk" class="input-control" value="<?php echo $p->produk_nama ?>" required>
                <input type="text" name="harga" placeholder="Harga" class="input-control" value="<?php echo $p->harga ?>" required>

                <img src="produk/<?php echo $p->produk_image ?>" width="100px" alt="">
                <input type="hidden" name="foto" value="<?php echo $p->produk_image ?>">
                <input type="file" name="gambar" class="input-control" >
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"><?php echo $p->deskripsi ?></textarea>
                <select name="status" class="input-control">
                    <option value="">Pilih Status</option>
                    <option value="1" <?php echo ($p->status == 1)? 'selected':''; ?> >Aktif</option>
                    <option value="0" <?php echo ($p->status == 0)? 'selected':''; ?>>Tidak Aktif</option>
                </select>
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    
                    //menampung data inputan form
                    $kategori   = $_POST['kategori'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];
                    $foto       = $_POST['foto'];

                    //menampung data format file yang diizinkan
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    //tampung data gambar yg baru
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'produk'.time().'.'.$type2;

                    //jika admin ganti gambar
                    if($filename != ''){
                        //validasi format file
                        if(!in_array($type2, $tipe_diizinkan)){
                        //jika format file tidak diizinkan
                        echo '<script>alert("Format tidak diixzinkan")</script>';

                        }else{
                            unlink('./produk/'.$foto);
                            move_uploaded_file($tmp_name, './produk/'.$newname);
                            $namagambar = $newname;
                        }

                    }else{
                        //jika admin tidak ganti gambar
                        $namagambar = $foto;

                    }

                    //query update data produk
                    $update = mysqli_query($conn, "UPDATE produk SET
                                              kategori_id = '".$kategori."',
                                              produk_nama = '".$nama."',
                                              harga = '".$harga."',
                                              deskripsi = '".$deskripsi."',
                                              produk_image = '".$namagambar."',
                                              status = '".$status."'
                                              WHERE produk_id = '".$p->produk_id."' ");
                    if($update){
                        echo'<script>alert("simpan data berhasil")</script>';
                        echo '<script>window.location="data-produk.php"</script>';
                    }else{
                        echo 'gagal'.mysqli_error($conn);
                    }                
                }
            ?>
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