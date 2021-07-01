<?php require_once('external_php.php'); ?>
<?php require_once('connection.php'); ?>

<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  if (isset($_SESSION['position'])) {
      if ($_SESSION['position']!='admin') {
          header('Location:login.php');
      }
  }else{
    header('Location:login.php');
  }
?>

<?php

  $error=array();
  $lenth_error=array();
    
    $id = "";
    $name = "";
    $address = "";
    $phone = "";
    $email = "";
    $position = "";

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn,$_GET['id']);
        $sql = "SELECT * FROM users WHERE id = {$id} LIMIT 1";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result)>0) {
                while ($details=mysqli_fetch_assoc($result)) {
                    $name = $details['name'];
                    $address = $details['address'];
                    $phone = $details['phone'];
                    $email = $details['email'];
                    $position = $details['position'];
                }
            }
        }
    }
    

    if (isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn,$_POST['id']);
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $address = mysqli_real_escape_string($conn,$_POST['address']);
        $phone = mysqli_real_escape_string($conn,$_POST['phone']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);

        if ($id=='') {
            $password = mysqli_real_escape_string($conn,$_POST['password']);
            $mdpassword = md5($password);

            $sql = "INSERT INTO users(name,address,phone,email,position,password) VALUES('{$name}','{$address}','{$phone}','{$email}','admin','{$mdpassword}')";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                
            }else{
                $error[]="Query error";
            }
        }else{
            $sql = "UPDATE users SET name='{$name}',address='{$address}',email='{$email}' WHERE id={$id} LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                
            }else{
                $error[]="Query error";
            }
        }

    }


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Infinity Accessories</title>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="shortcut icon" href="img/titlelogo.png" type="image/png">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- push menu-->
    <div class="pushmenu menu-home5">
        <div class="menu-push">
            <span class="close-left js-close"><i class="icon-close f-20"></i></span>
            <div class="clearfix"></div>
            <form role="search" method="post" id="searchform" class="searchform" action="accessorieshome.php">
                <div>
                    <label class="screen-reader-text" for="q"></label>
                    <input type="text" placeholder="Search..." value="" name="search_text" id="q" autocomplete="off">
                    <!-- <input type="hidden" name="search_category" value="both"> -->
                    <button type="submit" name="searchsubmit"><i class="ion-ios-search-strong"></i></button>
                </div>
            </form>
            <ul class="nav-home5 js-menubar">
                <li class="level1 active dropdown"><a href="movieshome.php">Video</a>
                    <span class="icon-sub-menu"></span>
                    <ul class="menu-level1 js-open-menu">
                        <?php 
                            $sql = "SELECT DISTINCT(language) FROM movies";
                            $result = mysqli_query($conn,$sql);
                            if ($result) {
                                if (mysqli_num_rows($result)>0) {
                                    while ($details=mysqli_fetch_assoc($result)) {
                                        echo '<li class="level2"><a href="movieshome.php?filter='.$details['language'].'" title="">'.$details['language'].'</a></li>';
                                    }
                                }
                            }
                        ?>
                    </ul>
                </li>
                <li class="level1 active dropdown"><a href="gameshome.php">Game</a>
                </li>
                <li class="level1 active dropdown"><a href="accessorieshome.php">Accesories</a></li>
                <li class="level1">
                    <a href="#">Phone Accessories</a>
                    <span class="icon-sub-menu"></span>
                    <ul class="menu-level1 js-open-menu">
                        <li class="level2"><a href="accessorieshome.php?filter=charger">chager </a></li>
                        <li class="level2"><a href="accessorieshome.php?filter=handfree">hand free</a></li>
                        <li class="level2"><a href="accessorieshome.php?filter=backcover">back cover</a></li>
                    </ul>
                </li>
                <li class="level1">
                    <a href="#">Computer Accesories</a>
                    <span class="icon-sub-menu"></span>
                    <ul class="menu-level1 js-open-menu">
                        <li class="level2"><a href="accessorieshome.php?filter=mouse">mouse</a></li>
                        <li class="level2"><a href="accessorieshome.php?filter=keybord">keybord</a></li>
                        <li class="level2"><a href="accessorieshome.php?filter=moniter">moniter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- end push menu-->
    <!-- menu -->
    <div class="wrappage">
        <header id="header" class="header-v5">
           <div class="header-top-banner">
               <a href="home2.php"><img src="img/banner-top.jpg" alt="" class="img-reponsive"></a>
           </div>
           <?php require_once('top_bar_menu.php'); ?>
            <!-- end menu -->
            <div class="header-center">
                <div class="container container-240">
                    <div class="row flex">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 v-center header-logo order-1 order-lg-1">
                            <a href="home2.php"><img src="img/logo.png" alt="" class="img-reponsive"></a>
                        </div>
                        <div class="col-lg-7 col-md-7 v-center header-search order-1 order-lg-1 hidden-xs hidden-sm">
                            <form method="post" class="searchform ajax-search" action="accessorieshome.php" role="search">
                                <input type="text" name="search_text" class="form-control" placeholder="i’m shoping for...">
                                
                                <div class="search-panel">
                                    <!-- <select class="dropdown-toggle" data-toggle="dropdown" name="search_category">
                                        <option value="both">All Accessories</option>
                                        <option value="computer">Computer Accessories</option>
                                        <option value="phone">Phone Accessories</option>
                                        
                                    </select> -->
                                </div>
                                <span class="input-group-btn">
                                    <button class="button_search" type="submit" name="searchsubmit"><i class="ion-ios-search-strong"></i></button>
                                </span>
                            </form>
                        </div>
                        <div class="col-lg-3  col-md-3 col-sm-6 col-xs-6 v-center header-sub order-sm-2 order-md-2">
                            <div class="right-panel">
                                <div class="header-sub-element hidden-xs hidden-sm">
                                    <div class="sub-left">
                                        <img src="img/icon-call.png" alt="">
                                    </div>
                                    <div class="sub-right">
                                        <span>Call Us</span>
                                        <div class="phone">071 720 6006 </div>
                                    </div>
                                </div>
                                <!-- <div class="header-sub-element row">
                                    <a class="hidden-xs hidden-sm" href=""><img src="img/icon-user.png" alt=""></a>
                                    <a href="#"><img src="img/icon-heart.png" alt=""></a>
                                    <div class="cart">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="label5">
                                            <img src="img/icon-cart.png" alt="">
                                            <span class="count cart-count">0</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-cart">
                                            <ul class="mini-products-list">
                                                <li class="item-cart">
                                                    <div class="product-img-wrap">
                                                        <a href="#"><img src="img/cart1.jpg" alt="" class="img-reponsive"></a>
                                                    </div>
                                                    <div class="product-details">
                                                        <div class="inner-left">
                                                            <div class="product-name"><a href="#">Harman Kardon Onyx Studio </a></div>
                                                            <div class="product-price">
                                                                $ 60.00 <span>( x2)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="e-del"><i class="ion-ios-close-empty"></i></a>
                                                </li>
                                                <li class="item-cart">
                                                    <div class="product-img-wrap">
                                                        <a href="#"><img src="img/cart1.jpg" alt="" class="img-reponsive"></a>
                                                    </div>
                                                    <div class="product-details">
                                                        <div class="inner-left">
                                                            <div class="product-name"><a href="#">Harman Kardon Onyx Studio </a></div>
                                                            <div class="product-price">
                                                                $ 60.00 <span>( x2)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="e-del"><i class="ion-ios-close-empty"></i></a>
                                                </li>
                                            </ul>
                                            <div class="bottom-cart">
                                                <div class="cart-price">
                                                    <span>Subtotal</span>
                                                    <span class="price-total">$ 120.00</span>
                                                </div>
                                                <div class="button-cart">
                                                    <a href="#" class="cart-btn btn-viewcart">View Cart</a>
                                                    <a href="#" class="cart-btn e-checkout btn-gradient">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="hidden-md hidden-lg icon-pushmenu js-push-menu">
                                        <i class="fa fa-bars f-15"></i>
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="header-bottom hidden-xs hidden-sm">
               <div class="container container-240">
                       <div class="row flex lr2">
                            <div class="col-lg-3 widget-verticalmenu">
                                <div class="navbar-vertical">
                                    <button class="navbar-toggles navbar-drop js-vertical-menu"><span>All Departments</span></button>
                                </div>
                                <div class="vertical-wrapper">
                                    <ul class="vertical-group">
                                        <li class="vertical-item level1 mega-parent"><a href="accessorieshome.php?sort=newaz">New Arrivals <span class="h-ribbon e-skyblue mg-l10">new</span></a></li>
                                        <li class="vertical-item level1 mega-parent"><a href="accessorieshome.php?sort=discountza">Top Best Discount <span class="h-ribbon e-red mg-l10">Hot</span></a></li>
                                        <?php 
                                            $sql = "SELECT * FROM model ORDER BY id DESC";
                                            $result = mysqli_query($conn,$sql);
                                            if ($result) {
                                                if (mysqli_num_rows($result)>0) {
                                                    while ($details=mysqli_fetch_assoc($result)) {
                                                        echo '<li class="vertical-item level1 mega-parent"><a href="accessorieshome.php?filter='.$details['id'].'">'.$details['name'].'</a></li>';
                                                    }
                                                }
                                            }

                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9 widget-left">
                                <div class="flex lr e-border">
                                    <nav class="main-menu flex align-center">
                                        <button type="button" class="icon-mobile e-icon-menu icon-pushmenu js-push-menu">
                                            <span class="navbar-toggler-bar"></span>
                                            <span class="navbar-toggler-bar"></span>
                                            <span class="navbar-toggler-bar"></span>
                                        </button>
                                       <div class="collapse navbar-collapse" id="myNavbar">
                                            <ul class="nav navbar-nav js-menubar">
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
                                                <li class="level1 dropdown hassub">Shop<span class="h-ribbon h-pos e-green">sale</span>

                                                    <span class="plus js-plus-icon"></span>
                                                    <div class="menu-level-1 dropdown-menu">
                                                        <ul class="level1">
                                                            <li class="level2 col-4">
                                                                Phone Accessories
                                                                <ul class="menu-level-2">
                                                                    <?php 
                                                                        $sql = "SELECT * FROM model WHERE category='phone' OR category='both'";
                                                                        $result = mysqli_query($conn,$sql);
                                                                        if ($result) {
                                                                            if (mysqli_num_rows($result)>0) {
                                                                                while ($details=mysqli_fetch_assoc($result)) {
                                                                                    echo '<li class="level3"><a href="accessorieshome.php?model='.$details['id'].'" title="">'.$details['name'].'</a></li>';
                                                                                }
                                                                            }
                                                                        }

                                                                    ?>
                                                                    
                                                                    
                                                                </ul>

                                                            </li>
                                                            <li class="level2 col-4">
                                                                Computer Accessories
                                                                <ul class="menu-level-2">
                                                                    <?php 
                                                                        $sql = "SELECT * FROM model WHERE category='computer' OR category='both'";
                                                                        $result = mysqli_query($conn,$sql);
                                                                        if ($result) {
                                                                            if (mysqli_num_rows($result)>0) {
                                                                                while ($details=mysqli_fetch_assoc($result)) {
                                                                                    echo '<li class="level3"><a href="accessorieshome.php?model='.$details['id'].'" title="">'.$details['name'].'</a></li>';
                                                                                }
                                                                            }
                                                                        }

                                                                    ?>
                                                                    
                                                                    
                                                                </ul>

                                                            </li>
                                                            <li class="level2 col-4">
                                                                <a href="accessorieshome.php?sort=discountza">Discount Product<span class="h-ribbon v3 e-red h-pos">Hot</span></a>
                                                                <ul class="menu-level-2">
                                                                    <?php  
                                                                        $sql = "SELECT * FROM items ORDER BY discount DESC LIMIT 10";
                                                                        $result = mysqli_query($conn,$sql);
                                                                        if ($result) {
                                                                            if (mysqli_num_rows($result)>0) {
                                                                                while ($details=mysqli_fetch_assoc($result)) {
                                                                                    echo '<li class="level3"><a href="product.php?id='.$details['id'].'" title="">'.$details['name'].'</a><span class="h-ribbon v3 e-red h-pos">'.$details['discount'].'</span></li>';
                                                                                }
                                                                            }
                                                                        }

                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="level2 col-4">
                                                                
                                                                    <a href="accessorieshome.php?sort=priceaz">New Product<span class="h-ribbon v3 e-skyblue h-pos">New</span></a>
                                                                    <ul class="menu-level-2">
                                                                        <?php
                                                                            $sql = "SELECT * FROM items ORDER BY id DESC LIMIT 10";
                                                                            $result = mysqli_query($conn,$sql);
                                                                            if ($result) {
                                                                                if (mysqli_num_rows($result)>0) {
                                                                                    while ($details=mysqli_fetch_assoc($result)) {
                                                                                        echo '<li class="level3"><a href="product.php?id='.$details['id'].'" title="">'.$details['name'].'</a></li>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </ul>
                                                                
                                                            </li>
                                                        </ul>
                                                        <div class="clearfix"></div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                   <div class="header-bottom-right hidden-xs hidden-sm">
                                       <img src="img/icon-ship.png" alt="" class="img-reponsive">
                                       <span>Free Shipping on Orders Rs:1000</span>
                                   </div>
                                </div>
                           </div>
                       </div>
               </div>
           </div>
        </header>
        <!-- /header -->
        <!--content-->
        <div class="main-content space1">
            <div class="container container-240">
                <ul class="breadcrumb">
                    <li>Home</li>
                    <li class="active">Add Users</li>
                </ul>
                
                <form name="checkout" method="post" class="co" action="addusers.php">
                    <div class="cart-box-container-ver2">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="co-left bd-7">
                                    <div class="cmt-title text-center abs">
                                        <h1 class="page-title v1">Manage Users</h1>
                                        <p><?php print_error($error,$lenth_error); ?></p>
                                    </div>
                                    <div class="row form-customer">
                                        <div class="form-group col-md-12">
                                            <label for="inputfname_2" class=" control-label">User Id</label>
                                            <input type="number" name="id" id="id" class="form-control form-account" value="<?php echo $id; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputlname" class=" control-label"> Name <span class="f-red">*</span></label>
                                            <input type="text" id="name" name="name" class="form-control form-account" value="<?php echo $name; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputcompany" class=" control-label">Address</label>
                                            <input type="text" id="address" name="address" class="form-control form-account" value="<?php echo $address; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputcountry1" class=" control-label">Phone <span class="f-red">*</span></label>
                                            
                                            <input type="text" id="phone" name="phone" class="form-control form-account" value="<?php echo $phone; ?>">
                                        </div>                                    
                                        <div class="form-group col-md-12">
                                            <label for="inputstreet" class=" control-label">E-mail <span class="f-red">*</span></label>
                                            <input type="text" id="email" name="email" class="form-control form-account" value="<?php echo $email; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputpostcode" class=" control-label">Password <span class="f-red">*</span></label>
                                            <input type="password" id="password" name="password" class="form-control form-account">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="submit" name="submit" class="btn-gradient btn-checkout btn-co-order" value="Submit">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- End contact-form -->
                            <div class="col-md-4">
                                <div class="cart-total bd-7">
                                    <div class="cmt-title text-center abs">
                                        <h1 class="page-title v3">User List</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="co-pd">
                                            <p class="co-title">
                                                Admin List
                                            </p>
                                            <table class="shop_table">
                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Name</th>
                                                        <td>Edit</td>
                                                    </tr>
                                                    <?php 
                                                        $sql = "SELECT * FROM users WHERE position='admin'";
                                                        $result = mysqli_query($conn,$sql);
                                                        if ($result) {
                                                            if (mysqli_num_rows($result)>0) {
                                                                while ($details=mysqli_fetch_assoc($result)) {
                                                                    echo '<tr class="cart-shipping v2">
                                                                            <td>'.$details['name'].'</td>
                                                                            <td><a href="addusers.php?id='.$details['id'].'">Edit</a></td>
                                                                        </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        
                                        <div class="co-pd">
                                            <p class="co-title">
                                                Customers List
                                            </p>
                                            <table class="shop_table">
                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Name</th>
                                                        <td>Edit</td>
                                                    </tr>
                                                    <?php 
                                                        $sql = "SELECT * FROM users WHERE position='customer'";
                                                        $result = mysqli_query($conn,$sql);
                                                        if ($result) {
                                                            if (mysqli_num_rows($result)>0) {
                                                                while ($details=mysqli_fetch_assoc($result)) {
                                                                    echo '<tr class="cart-shipping v2">
                                                                            <td>'.$details['name'].'</td>
                                                                            <td><a href="addusers.php?id='.$details['id'].'">Edit</a></td>
                                                                        </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
        <!-- e-category  -->
        <?php  require_once('e_category.php') ?>
        <div class="feature">
            <div class="container container-240">
                <div class="feature-inside">
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="img/feature/truck.png" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Town Area Delivery</h3>
                            <p>We are delivery matara town area.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="img/feature/credit-card.png" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Safe Payment</h3>
                            <p>Payment can be made upon receipt of the goods.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="img/feature/safety.png" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Shop with Confidence</h3>
                            <p>Our Buyer Protection covers your purchase from click to delivery.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="img/feature/telephone.png" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>24/7 Help Center</h3>
                            <p>Round-the-clock assistance for a smooth shopping experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</body>

</html>