<?php

@include 'config.php';

$id = $_GET['edit'];

if (isset($_POST['update_keg'])) {


   $nama_kegiatan = $_POST['nama_kegiatan'];
   $link = $_POST['link'];
   $tgl = $_POST['tgl'];
   $gambar = $_FILES['gambar']['name'];
   $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
   $gambar_folder = 'uploaded_img/' . $gambar;

   if (empty($nama_kegiatan) || empty($link) || empty($gambar)) {
      $message[] = 'please fill out all';
   } else {

      $update_keg = "UPDATE info_keg SET nama_keg='$nama_kegiatan', link='$link', tgl='$tgl', gambar='$gambar'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_keg);

      if ($upload) {
         move_uploaded_file($gambar_tmp_name, $gambar_folder);
         header('location:admin_page.php');
      } else {
         $$message[] = 'please fill out all!';
      }
   }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <link rel="stylesheet" href="css/style.css"> -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<span class="message">' . $message . '</span>';
      }
   }
   ?>

   <div class="container-lg col-12">


      <div class="mt-5 d-flex flex-column align-items-center justify-content center">

         <?php

         $select = mysqli_query($conn, "SELECT * FROM info_keg WHERE id = '$id'");
         while ($row = mysqli_fetch_assoc($select)) {

         ?>

            <form action="" method="post" enctype="multipart/form-data">
               <div class="mb-3">
                  <h3 class="title">Update Kegiatan</h3>
               </div>
               <div class="mb-3">
                  <input type="text" class="form-control" name="nama_kegiatan" value="<?php echo $row['nama_keg']; ?>" placeholder="Masukkan nama kegiatan">
               </div>
               <div class="mb-3">
                  <input type="text" min="0" class="form-control" name="link" value="<?php echo $row['link']; ?>" placeholder="Masukkan link">
               </div>
               <div class="mb-3">
                  <input type="date" min="0" class="form-control" name="tgl" value="<?php echo $row['tgl']; ?>" placeholder="Masukkan Tanggal">
               </div>
               <div class="mb-3">
                  <input type="file" class="form-control" name="gambar" accept="image/png, image/jpeg, image/jpg">
               </div>
               <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <input type="submit" value="Update Kegiatan" name="update_keg" class="btn btn-md btn-primary">
                  <a href="admin_page.php" class="btn btn-outline-secondary">Cancel</a>
               </div>
            </form>



         <?php }; ?>



      </div>

   </div>

</body>

</html>