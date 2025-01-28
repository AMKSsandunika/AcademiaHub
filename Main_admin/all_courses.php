<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
}

if(isset($_POST['delete'])){
   $playlist_id = $_POST['playlist_id'];
   $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);

   $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
   $verify_playlist->execute([$playlist_id]);

   if($verify_playlist->rowCount() > 0){
      $fetch_playlist = $verify_playlist->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fetch_playlist['thumb']);
      $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
      $delete_bookmark->execute([$playlist_id]);
      $delete_content = $conn->prepare("DELETE FROM `content` WHERE playlist_id = ?");
      $delete_content->execute([$playlist_id]);
      $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
      $delete_playlist->execute([$playlist_id]);
      $message[] = 'Playlist deleted!';
   }else{
      $message[] = 'Playlist already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Playlists</title>
   <link rel="shortcut icon" href="../images/hat.png" sizes="64x64" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/main_admin.css">

</head>
<body>

<?php include 'main_admin_header.php'; ?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">all courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="../uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="../uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <div class="button-container">
         <a href="admin_playlist.php?get_id=<?= $course_id; ?>" class="inline-btn2">View playlist <i class="fa fa-eye" aria-hidden="true"></i></a>
         <form action="" method="post" class="delete-form">
            <input type="hidden" name="playlist_id" value="<?= $course_id; ?>">
            <button type="submit" class="delete-btn2" name="delete" onclick="return confirm('Delete this playlist?');">Delete <i class="fa-solid fa-trash"></i></button>
         </form>
         </div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No courses added yet!</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>
