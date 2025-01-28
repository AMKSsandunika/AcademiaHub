<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About us</title>
   <link rel="shortcut icon" href="images/hat.png" sizes="64x64" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>


<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Why choose us?</h3>
         <p>Choosing an academic institute is a crucial decision that impacts your educational journey and future career. It is essential to consider factors such as quality of education, available resources, career opportunities, financial aspects, and personal preferences to select an institute that aligns best with your goals and aspirations.
         </p>
         <a href="courses.php" class="inline-btn">Our courses</a>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>100+</h3>
            <span>Online courses</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+2k</h3>
            <span>brilliants students</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>20+</h3>
            <span>expert teachers</span>
         </div>
      </div>

      <!-- <div class="box">
         <i class="fas fa-briefcase"></i>
         <div>
            <h3>100%</h3>
            <span>job placement</span>
         </div>
      </div> -->

   </div>

</section>

<!-- about section ends -->

<!-- reviews section starts  -->

<section class="faq" id="faq">

   <h1 class="heading">FAQ</h1>

   <div class="box-container">

      <div class="box active">
         <h3><span>How to make a complain?</span><i class="fas fa-angle-down"></i></h3>
         <p>Feel free to reach out to us anytime to send a message or make inquiries – we're always available online to assist you! Whether you have questions, 
            feedback, or need support, our team is here to help.</p>
      </div>

      <div class="box active">
         <h3><span>Can students post comments?</span><i class="fas fa-angle-down"></i></h3>
         <p>Yes. you can also post comments to reach out to your lessons? Whether you're looking for  courses, our platform offers you the opportunity to connect with other students.</p>
      </div>

      <div class="box">
         <h3><span>Is this free to use?</span><i class="fas fa-angle-down"></i></h3>
         <p>Yes. you can also post comments to reach out to your lessons? Whether you're looking for  courses, our platform offers you the opportunity to connect with other students.</p>
      </div>

      <div class="box">
         <h3><span>how to contact with the tutors?</span><i class="fas fa-angle-down"></i></h3>
         <p>Yes. you can also post comments to reach out to your lessons? Whether you're looking for  courses, our platform offers you the opportunity to connect with other students.</p>
      </div>

      <div class="box">
         <h3><span>Do we need to complete the exercises?</span><i class="fas fa-angle-down"></i></h3>
         <p>Yes. you can also post comments to reach out to your lessons? Whether you're looking for  courses, our platform offers you the opportunity to connect with other students.</p>
      </div>

      <div class="box">
         <h3><span>Can students download the contents?</span><i class="fas fa-angle-down"></i></h3>
         <p>Yes. you can also post comments to reach out to your lessons? Whether you're looking for  courses, our platform offers you the opportunity to connect with other students.</p>
      </div>

   </div>

</section>
<!-- reviews section ends -->










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js">
   
</script>
<script>
document.querySelectorAll('.faq .box-container .box h3').forEach(headings =>{
   headings.onclick = () =>{
      headings.parentElement.classList.toggle('active');
   }
});
</script>

   
</body>
</html>