<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_id = '".$_GET['id']."' ");
    if(mysqli_num_rows($kategori) == 0){
        echo '<script>window.location="kategori.php"</script>';
    }
    $k = mysqli_fetch_object($kategori);
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
        <h3>Edit Kategori</h3>
        <div class="box">
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="Nama Kategori" class="input-control" value="<?php echo $k->kategori_nama ?>" required>
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    $nama = ucwords($_POST['nama']);
                    $update = mysqli_query($conn, "UPDATE kategori SET
                                            kategori_nama = '".$nama."'
                                            WHERE kategori_id = '".$k->kategori_id."' ");

                    if($update){
                        echo '<script>alert("Edit kategori berhasil.")</script>';
                        echo '<script>window.location="kategori.php"</script>';
                    }else{
                        echo 'Gagal!'. mysqli_error($conn);
                    }
                }
            ?>
        </div>
    </div>
   </div>

   <!-- footer -->
   <div class="container">
    <small>Copyright &copy; 2022 - Warungonline.</small>
   </div>
</body>
</html>