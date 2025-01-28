<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
   exit;
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   // Verify if the user or tutor exists
   $verify_delete_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $verify_delete_user->execute([$delete_id]);

   $verify_delete_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
   $verify_delete_tutor->execute([$delete_id]);

   if($verify_delete_user->rowCount() > 0 || $verify_delete_tutor->rowCount() > 0){
      // Delete playlists and associated images
      $select_images = $conn->prepare("SELECT thumb FROM `playlist` WHERE tutor_id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $thumb = $fetch_images['thumb'];
         if(!empty($thumb)){
            unlink('../uploaded_files/'.$thumb);
         }
      }

      // Delete content and associated images
      $select_images = $conn->prepare("SELECT thumb FROM `content` WHERE tutor_id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $thumb = $fetch_images['thumb'];
         if(!empty($thumb)){
            unlink('../uploaded_files/'.$thumb);
         }
      }

      // Delete playlists
      $delete_listings = $conn->prepare("DELETE FROM `playlist` WHERE tutor_id = ?");
      $delete_listings->execute([$delete_id]);

      // Delete content
      $delete_requests = $conn->prepare("DELETE FROM `content` WHERE tutor_id = ?");
      $delete_requests->execute([$delete_id]);

      // Delete bookmarks
      $delete_saved = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ?");
      $delete_saved->execute([$delete_id]);

      // Delete tutor information
      if($verify_delete_tutor->rowCount() > 0) {
         $delete_tutor = $conn->prepare("DELETE FROM `tutors` WHERE id = ?");
         $delete_tutor->execute([$delete_id]);
      }

      // Finally, delete the user if they exist
      if($verify_delete_user->rowCount() > 0) {
         $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
         $delete_user->execute([$delete_id]);
      }

      $success_msg[] = 'User deleted!';
   }else{
      $warning_msg[] = 'User already deleted!';
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/main_admin.css">
</head>
<body>
   
<!-- header section starts  -->
<?php include 'main_admin_header.php'; ?>
<!-- header section ends -->

<!-- users section starts  -->

<section class="grid">

   <h1 class="heading">Students and tutors</h1>

   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="search for users..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">

   <?php
      if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         $search_box = $_POST['search_box'];
         $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
         $select_users = $conn->prepare("SELECT *, 'student' AS type FROM `users` WHERE name LIKE ? OR email LIKE ?");
         $select_users->execute(['%'.$search_box.'%', '%'.$search_box.'%']);
         $select_tutors = $conn->prepare("SELECT *, 'tutor' AS type FROM `tutors` WHERE name LIKE ? OR email LIKE ?");
         $select_tutors->execute(['%'.$search_box.'%', '%'.$search_box.'%']);
      }else{
         $select_users = $conn->prepare("SELECT *, 'student' AS type FROM `users`");
         $select_users->execute();
         $select_tutors = $conn->prepare("SELECT *, 'tutor' AS type FROM `tutors`");
         $select_tutors->execute();
      }

      $fetch_all = array_merge($select_users->fetchAll(PDO::FETCH_ASSOC), $select_tutors->fetchAll(PDO::FETCH_ASSOC));

      if(count($fetch_all) > 0){
         foreach($fetch_all as $fetch_user){
            $type = $fetch_user['type'];

            if($type == 'student') {
               $count_property = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            } else {
               $count_property = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            }
            $count_property->execute([$fetch_user['id']]);
            $total_properties = $count_property->rowCount();
   ?>
   <div class="box">
      <p>name : <span><?= $fetch_user['name']; ?></span></p>
      <p>email : <a href="mailto:<?= $fetch_user['email']; ?>"><?= $fetch_user['email']; ?></a></p>
      <p>playlists listed : <span><?= $total_properties; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $fetch_user['id']; ?>">
         <button type="submit" class="delete-btn" name="delete" onclick="return confirm('Delete this <?= $type; ?>?');">Delete <?= $type; ?> <i class="fa-solid fa-trash"></i></button>
      </form>
   </div>
   <?php
         }
      }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         echo '<p class="empty">results not found!</p>';
      }else{
         echo '<p class="empty">no user or tutor accounts added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- users section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>



</body>
</html>
