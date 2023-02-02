<?php
    require 'db_connection.php';
    require 'model/user.php';

    session_start();

    $loginError = false;
    
    
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username_post = $_POST['username'];
        $password_post = $_POST['password'];

        $user_post = new User(1,$username_post, $password_post);
        

        $result_login = User::logInUser($user_post, $conn);

       
        
        if($user_post != null){
          $_SESSION['UserID'] = $user_post->id;
          header('Location: home.php');
          exit();
        } else {
          $loginError = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <title>OnePage Bootstrap Template - Index</title>
</head>
<body>
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">Gym Membership Management System</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
      </nav>
    </div>
  </header>
  <section id="login-section" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
            <div class="section-title">
                <h2>LOGIN</h2>
                <p>Please enter your credentials</p>
                <?php
                // if($loginError){ ?>
                   <!-- <p class="alert alert-danger">Invalid username or password</p> -->
                <?php
                // }
                ?>
            </div>
            <form method="POST" action="#">
              <div class="form-outline mb-4">
                  <input type="text" id="username-input" name="username" class="form-control" placeholder = "Username" />
              </div>
              <div class="form-outline mb-4">
                  <input type="password" id="password-input" name="password" class="form-control" placeholder = "Password" />
              </div>
              <div class="text-center col-12"><button type="submit">Login</button></div>
            </form>
        </div>
      </div>
      </div>
    </div>
  </section>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
    
</body>
</html>

