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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Infinity Admin</title>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="shortcut icon" href="img/titlelogo.png" type="image/png">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
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
    <div class="wrappage">
        <header id="header" class="header-v5">
           <div class="header-top-banner">
               <a href="home2.php"><img src="img/banner-top.jpg" alt="" class="img-reponsive"></a>
           </div>
           <?php require_once('top_bar_menu.php'); ?>
           <div class="header-center">
                <div class="container container-240">
                    <div class="row flex">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 v-center header-logo order-1 order-lg-1">
                            <a href="#"><img src="img/logo.png" alt="" class="img-reponsive"></a>
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
            <ul class="breadcrumb">
                <li>Home</li>
                <li class="active">Contact </li>
            </ul>
            <div class="e-contact">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="hot-line e-gradient">
                            <a href="addmovies.php">
                                <p>New Movies/Games</p>
                                <div class="flex align-center tele">
                                    <div class="phone-number">
                                        <p>Add Movies/Games</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 pdl">
                        <div class="hot-line e-gradient">
                            <a href="additems.php">
                                <p>New Accessories</p>
                                <div class="flex align-center tele">
                                    <div class="phone-number">
                                        <p>Add Accessories</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 pdl">
                        <div class="hot-line e-gradient">
                            <a href="addusers.php">
                                <p>New Users</p>
                                <div class="flex align-center tele">
                                    <div class="phone-number">
                                        <p>Add User</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>