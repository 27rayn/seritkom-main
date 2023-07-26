<?php

@include 'config.php';
session_start();

if (!isset($_SESSION['role'])) {
   header("Location: index.php"); // Redirect to the login page or another page
   exit();
}

if (isset($_POST['add_keg'])) {

   $nama_kegiatan = $_POST['nama_kegiatan'];
   $info_kegiatan = $_POST['info_kegiatan'];
   $link = $_POST['link'];
   $gambar = $_FILES['gambar']['name'];
   $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
   $gambar_folder = 'uploaded_img/' . $gambar;

   if (empty($nama_kegiatan) || empty($link) || empty($gambar)) {
      $message[] = 'please fill out all';
   } else {
      $insert = "INSERT INTO info_keg(nama_keg, info, link, gambar) VALUES('$nama_kegiatan', '$info_kegiatan', '$link', '$gambar')";
      $upload = mysqli_query($conn, $insert);
      if ($upload) {
         move_uploaded_file($gambar_tmp_name, $gambar_folder);
         $message[] = 'Kegiatan Berhasil Ditambah';
      } else {
         $message[] = 'Gagal Menambahkan Kegiatan';
      }
   }
};

if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM info_keg WHERE id = $id");
   header('location:admin_page.php');
};
if (isset($_POST['logout'])) {
   session_destroy();
   header("Location: index.php");
   //  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/style.css"> -->

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
         if ($_SESSION['role'] == 1) {
         ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
               <h3>Tambah Kegiatan</h3>
               <div class="mb-3">
                  <input class="form-control" type="text" placeholder="Masukkan nama kegiatan" name="nama_kegiatan" class="box">
               </div>
               <div class="mb-3">
                  <input class="form-control" type="text" placeholder="Masukkan informasi kegiatan" name="info_kegiatan" class="box">
               </div>
               <div class="mb-3">
                  <input class="form-control" type="text" placeholder="Masukkan link" name="link" class="box">
               </div>
               <div class="mb-3">
                  <input class="form-control" type="file" accept="image/png, image/jpeg, image/jpg" name="gambar" class="box">
               </div>
               <div class="mb-3">
                  <input type="submit" class="col-12 btn btn-md btn-primary" name="add_keg" value="Tambah Kegiatan">
               </div>
            </form>
         <?php
         }
         ?>

      </div>

      <?php

      $select = mysqli_query($conn, "SELECT * FROM info_keg");

      ?>
      <div class="container-lg">


         <?php

         $select = mysqli_query($conn, "SELECT * FROM info_keg");

         ?>
         <tbody>
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th scope="col">Nama Kegiatan</th>
                     <th scope="col">Info Kegiatan</th>
                     <th scope="col">Link</th>
                     <th scope="col">Gambar Kegiatan</th>
                  </tr>
               </thead>
               <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                  <tr>
                     <td class="col-2"><?php echo $row['nama_keg']; ?></td>
                     <td class="col-6"><?php echo $row['info']; ?></td>
                     <td><a href=""><?php echo $row['link']; ?></a></td>
                     <td><img src="uploaded_img/<?php echo $row['gambar']; ?>" height="100" alt=""></td>
                     <td class="col-2">
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="mb-3 col-12 btn btn-md btn-warning"> <i class="fas fa-edit"></i> edit </a>
                        <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="col-12 btn btn-md btn-danger"> <i class="fas fa-trash"></i> delete </a>
                     </td>
                  </tr>
               <?php } ?>
            </table>
         </tbody>
         <form action="" method="POST">
            <input type="submit" class="btn btn-lg btn-danger col-12 mt-5" name="logout" value="Log out">
         </form>
      </div>

   </div>


</body>

</html>