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
    <h1><a href="dashboard.php">Warung</a></h1>
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
        <h3>Tambah Produk</h3>
        <div class="box">
            <form action="" method="POST" enctype="multipart/form-data">
                <select class="input-control" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY kategori_id DESC ");
                        while ($r = mysqli_fetch_array($kategori)) {
                    ?>
                    <option value="<?php echo $r['kategori_id'] ?>"><?php echo $r['kategori_nama'] ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="nama" placeholder="Nama Produk" class="input-control" required>
                <input type="text" name="harga" placeholder="Harga" class="input-control" required>
                <input type="file" name="gambar" class="input-control" required>
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea>
                <select name="status" class="input-control">
                    <option value="">Pilih Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    
                    //print_r($_FILES['gambar']);
                    //menampung inputan dari form
                    $kategori   = $_POST['kategori'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];

                    //menampung data file yang di uploud
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'produk'.time().'.'.$type2;

                    //menampung data format file yang diizinkan
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    //validasi format file
                    if(!in_array($type2, $tipe_diizinkan)){
                        //jika format file tidak diizinkan
                        echo '<script>alert("Format tidak diixzinkan")</script>';

                    }else{
                        //jika format file sesuai dengan yang ada di dalam array tipe diizinkan
                        //proses uploud file sekaligus insert ke database
                        move_uploaded_file($tmp_name, './produk/'.$newname);

                        $insert = mysqli_query($conn, "INSERT INTO produk VALUES (
                                    null,
                                    '".$kategori."',
                                    '".$nama."',
                                    '".$harga."',
                                    '".$deskripsi."',
                                    '".$newname."',
                                    '".$status."',
                                    null
                                    ) ");
                        if($insert){
                            echo'<script>alert("simpan data berhasil")</script>';
                            echo '<script>window.location="data-produk.php"</script>';
                        }else{
                            echo 'gagal'.mysqli_error($conn);
                        }
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