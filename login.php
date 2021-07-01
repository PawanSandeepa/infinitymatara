<?php //require_once('external_html.php'); ?>
<?php require_once('external_php.php'); ?>
<?php require_once('connection.php'); ?>

<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  } 
?>

<?php
  $_SESSION['id']="";
  $_SESSION['name']="";
  $_SESSION['position']="";

  $error=array();
  $lenth_error=array();

  if (isset($_POST['login'])) {
      $email = mysqli_real_escape_string($conn,$_POST['email']);
      $password = mysqli_real_escape_string($conn,$_POST['password']);
      $mdpassword = md5($password);

      $sql = "SELECT * FROM users WHERE email='{$email}' LIMIT 1";
      $result = mysqli_query($conn,$sql);
      if ($result) {
          if (mysqli_num_rows($result)==1) {
              while ($details = mysqli_fetch_assoc($result)) {
                  if ($mdpassword==$details['password']) {
                      $_SESSION['id']=$details['id'];
                      $_SESSION['name']=$details['name'];
                      $_SESSION['position']=$details['position'];

                      header('Location:home2.php');
                  }else{
                    $error[] = "Invalid user name or password";
                  }
              }
          }else{
            $error[] = "Invalid user name or password";
          }
      }else{
        $error[] = "Invalid user name or password";
      }

  }

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Add Items</title>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="shortcut icon" href="img/titlelogo.png" type="image/png">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

      <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <!-- menu -->
    <div class="wrappage">
        <header id="header" class="header-v2">
            <div class="header-top-banner">
                <a href="#"><img src="img/banner-top.jpg" alt="" class="img-reponsive"></a>
            </div>
            
            <!-- end menu -->
            
            <div class="header-bottom hidden-xs hidden-sm">
                <div class="flex lr">
                    <div class="box-header-nav">
                        <nav class="main-menu">
                            <ul class="nav navbar-nav">
                                <li class="level1 active hassub">Home
                                    <span class="plus js-plus-icon"></span>
                                    <div class="menu-level-1 ver2 dropdown-menu">
                                        <div class="row">
                                            <div class="cate-item col-md-4 col-sm-12">
                                                <div class="demo-img">
                                                    <a href="movieshome.php">
                                                        <img src="img/demo/movies.jpg" alt="" class="img-reponsive">

                                                    </a>
                                                </div>
                                                <div class="demo-text">Movies\TV Series</div>
                                            </div>
                                            <div class="cate-item col-md-4 col-sm-12">
                                                <div class="demo-img">
                                                    <a href="gameshome.php"><img src="img/demo/games.jpg" alt="" class="img-reponsive"></a>
                                                </div>
                                                <div class="demo-text">Games</div>
                                            </div>
                                            <div class="cate-item col-md-4 col-sm-12">
                                                <div class="demo-img">
                                                    <a href="accessorieshome.php"><img src="img/demo/accessories.jpg" alt="" class="img-reponsive"></a>
                                                </div>
                                                <div class="demo-text">Accessories</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="level1"><a href="accessorieshome.php?filter=handfree"> Hand Free </a></li>
                                <li class="level1"><a href="accessorieshome.php?filter=subwoofer"> Subwoofers </a></li>
                                <li class="level1"><a href="accessorieshome.php?filter=minispeaker"> Mini-Speakers </a></li>
                                <li class="level1"><a href="accessorieshome.php?filter=pen"> Pen Drives </a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="box-header-menu">
                        <nav class="main-menu">
                            <ul class="nav navbar-nav">
                                <li class="level1"><a href="accessorieshome.php?sort=discountza">Flash Deals<span class="h-ribbon h-pos v4 e-skyblue">Dis</span></a></li>
                                <li class="level1"><a href="accessorieshome.php?sort=newaz">Tech Discovery<span class="h-ribbon h-pos e-green v4">new</span></a></li>
                                <li class="level1"><a href="accessorieshome.php?sort=newaz">Trending Styles<span class="h-ribbon h-pos v4 e-red">hot</span></a></li>
                                <li class="level1"><a href="accessorieshome.php?sort=discountza">Gift Cards </a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- /header -->
        <!--content-->
        <div class="container container-240">
            
            <div class="myaccount">
                <ul class="breadcrumb v3">
                    <li>Home</li>
                    <li class="active">My Account</li>
                </ul>
                <div class="row flex pd">
                    <div class="account-element bd-7">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v1">Login</h1>
                        </div>
                        <div class="page-content">
                            <p>Sign in to your account</p>
                            <p><?php print_error($error,$lenth_error); ?></p>
                            <form class="login-form" method="post" action="login.php"> 
                                  <div class="form-group">
                                    <label>Username or email address <span class="f-red">*</span></label>
                                      <input type="text" id="email" class="form-control bdr" name="email" value="">
                                      <label>Password <span class="f-red">*</span></label>
                                      <input type="password" id="password" class="form-control bdr" name="password" value="">
                                  </div>
                                  <div class="flex lr">
                                      <button type="submit" name="login" class="btn btn-submit btn-gradient">
                                          Login
                                      </button>
                                        <div class="checkbox checkbox-default">       
                                          <input id="remember" type="checkbox" value="yes" class="">
                                          <label for="remember"><span class="chk-span" tabindex="2"></span>Remember me</label>      
                                      </div>
                                  </div>
                            </form>
                            <a href="#" class="btn-lostpwd spc">Lost your password?</a>
                        </div>
                    </div>
                    <div class="account-element bd-7 e-left">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v1">Register</h1>
                        </div>
                        <div class="page-content">
                            <p>Create your very own account</p>
                            <form class="login-form" method="post" action="#"> 
                                  <div class="form-group">
                                    <label>Username or email address <span class="f-red">*</span></label>
                                      <input type="text" id="author2" class="form-control bdr" name="comment[author]" value="">
                                      <label>Password <span class="f-red">*</span></label>
                                      <input type="email" id="email2" class="form-control bdr" name="comment[email]" value="">
                                  </div>
                                  <div class="flex lr">
                                      <button type="submit" class="btn btn-submit btn-gradient">
                                          Register
                                        </button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- end of content -->
        <?php  require_once('e_category.php') ?>

        <!-- / end content -->
        <footer>

        <?php require_once('footer.php'); ?>
        <?php require_once('dev_footer.php'); ?>
            
        </footer>
        <!-- /footer -->
        <!-- /footer -->
    </div>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/slick.min.js"></script>
    
    <script src="js/main.js"></script>

      <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>