<?php require_once('connection.php'); ?>

<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  } 
?>

<?php 

    if (isset($_POST['submit'])) {
        $search = mysqli_real_escape_string($conn,$_POST['search_text']);
        $category = mysqli_real_escape_string($conn,$_POST['category']);

        switch ($category) {
            case 'movies':
                header('Location:movieshome.php?filter='.$search);
                break;

            case 'games':
                header('Location:gameshome.php?filter='.$search);
                break;
            
            default:
                header('Location:accessorieshome.php?filter='.$search);
                break;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>InfinityCom Matara</title>
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
    <!-- push menu-->
    <div class="pushmenu menu-home5">
        <div class="menu-push">
            <span class="close-left js-close"><i class="icon-close f-20"></i></span>
            <div class="clearfix"></div>
            <form role="search" method="post" id="searchform" class="searchform" action="accessorieshome.php">
                <div>
                    <label class="screen-reader-text" for="q"></label>
                    <input type="text" placeholder="Search for products" name="search_text" value="" name="q" id="q" autocomplete="off">
                    <input type="hidden" name="type" value="product">
                    <button type="submit" id="searchsubmit" name="searchsubmit"><i class="ion-ios-search-strong"></i></button>
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
        <header id="header" class="header-v2">
            <div class="header-top-banner">
                <img src="img/banner-top.jpg" alt="" class="img-reponsive">
            </div>
            <?php require_once('top_bar_menu.php'); ?>
            <div class="header-center">
                <div class="container container-240">
                    <div class="row flex">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 v-center header-logo order-1 order-lg-1">
                            <a href="home2.php"><img src="img/logo.png" alt="" class="img-reponsive"></a>
                        </div>
                        <div class="col-lg-7 col-md-7 v-center header-search order-1 order-lg-1 hidden-xs hidden-sm">
                            <form method="post" class="searchform ajax-search" action="home2.php" role="search">
                                <input type="hidden" name="type" value="product">
                                <input type="text" name="search_text" class="form-control" placeholder="i’m shoping for...">
                                <!-- <ul class="list-product-search hidden-xs hidden-sm">
                                    <li>
                                        <a class="flex align-center" href="">
                                            <div class="product-img">
                                                <img src="img/product/iphonex.jpg" alt="">
                                            </div>
                                            <h3 class="product-title">Notebook Black Spire Smartphone Black 2.0</h3>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="flex align-center" href="">
                                            <div class="product-img">
                                                <img src="img/product/sound.jpg" alt="">
                                            </div>
                                            <h3 class="product-title">Smartphone 6S 64GB LTE</h3>
                                        </a>
                                    <li>
                                </ul> -->
                                <div class="search-panel">
                                    <select class="dropdown-toggle" data-toggle="dropdown" name="category">
                                            <option value="Accessories">Accessories</option>
                                            <option value="Movies">Movies</option>
                                            <option value="Games">Games</option>
                                    </select>
                                </div>
                                <span class="input-group-btn">
                                          <button class="button_search" type="submit"><i class="ion-ios-search-strong"></i></button>
                                </span>
                            </form>
                            <!-- <div class="tags">
                                <span>Most searched :</span>
                                <a href="#">umbrella</a>
                                <a href="#">hair accessories </a>
                                <a href="#">diamond</a>
                                <a href="#"> painting slime</a>
                                <a href="#">sunglasses</a>
                            </div> -->
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
        <!-- Slide -->
        <div class="slide-fullw">
            <div class="js-slider-home2">
                <div class="e-slide-img">
                    <img src="img/slider/acceseriascover.jpg" alt="">
                    <div class="slide-content v4 box-center">
                        <div class="container container-240">
                            <p class="cate white">Accesories</p>
                            <h3 class="v4">Phone And Computer Accesories</h3>
                            <p class="sale v3 white">Sale up to <span class="text-white">30%</span> off</p>
                            <a href="accessorieshome.php?sort=discountza" class="slide-btn e-orange-gradient" tabindex="0">Shop now<i class="ion-ios-arrow-forward"></i></a>
                        </div>
                    </div>
                </div>

                <div class="e-slide-img">
                    <img src="img/slider/gamesascover.jpg" alt="">
                    <div class="slide-content v4 box-center">
                        <div class="container container-240">
                            <p class="cate white">Games </p>
                            <h3 class="v4 ">PC and Playstation Games</h3>
                            <p class="sale v3 white">Come And Enjoy</p>
                            <a href="gameshome.php" class="slide-btn e-pink-gradient" tabindex="0">See now<i class="ion-ios-arrow-forward"></i></a>
                        </div>
                    </div>
                </div>

                <div class="e-slide-img">
                    <img src="img/slider/moviesascover.jpg" alt="">
                    <div class="slide-content v4 box-center">
                        <div class="container container-240">
                            <p class="cate white">Vides </p>
                            <h3 class="v4">Movies\TV Series</h3>
                            <p class="sale v3 white">Movies,TV Series, Songs, Short Movies</p>
                            <a href="movieshome.php" class="slide-btn e-orange-gradient" tabindex="0">Shop now<i class="ion-ios-arrow-forward"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Slide -->
        <!-- Homepage banner -->
        <div class="homepage-banner spc2">
            <div class="container container-240">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="banner-img effect-img3 plus-zoom">
                            <a href="movieshome.php" class=""><img src="img/banner/movie.jpg" alt="" class="img-responsive"></a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="banner-img effect-img3 plus-zoom">
                            <a href="gameshome.php"><img src="img/banner/game.jpg" alt="" class="img-responsive"></a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="banner-img effect-img3 plus-zoom">
                            <a href="accessorieshome.php"><img src="img/banner/accessorie.jpg" alt="" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Homepage banner -->
        <!-- super deal -->
        <div class="super-deal v2">
            <div class="container container-240">
                <div class="owl-carousel owl-theme owl-cate  js-oneitem2">
                    <?php
                        $sql = "SELECT * FROM items ORDER BY discount DESC LIMIT 5";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result)>0) {
                                while ($details=mysqli_fetch_assoc($result)) {
                                    echo '<div class="row">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="product-countd pd-bd spc2 bg product-inner">
                                                    <div class="product-item-countd">
                                                        <div class="product-info">
                                                            <h1 class="deal-title text-center">Super Deals</h1>';
                                    echo '<a href="product.php?id='.$details['id'].'"><h3 class="product-title text-center v4">'.$details['name'].'</h3>';
                                    echo '<div class="product-price thin-price v3 no-bg bd">';
                                    echo '<span class="red">'.($details['price']-$details['discount']).'</span>';
                                    echo '<span class="old">'.$details['price'].'</span>';
                                    echo '</div></a>
                                            <div class="deal-progress">
                                                <div class="deal-stock">';
                                    echo '<span class="stock-sold">1 already claimed</span>';
                                    echo '<span class="stock-available">Available: <strong>'.$details['quantity'].'</strong></span>';
                                    echo '</div>
                                            <div class="progress">
                                                <span class="progress-bar" style="width:27.5956%"></span>
                                            </div>
                                        </div>
                                        <div class="time-cound">';
                                    // echo '<p class="text-center">Deal ends in :</p>';
                                    // echo '<div class="countdown countdown-time" data-countdown="countdown" data-date="$details['end_date']">
                                    //         </div>';
                                    echo '</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    echo '<div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="product-wrapper">
                                            <div class="flex product-img-slide">
                                                <div class="product-images v2">
                                                    <div class="main-img v2 js-product-slider">
                                                        <a href="product.php?id='.$details['id'].'" class="hover-images effect"><img src="'.$details['img'].'" alt="photo" class="img-fluid. max-width: 10%"></a>
                                                        <a href="product.php?id='.$details['id'].'" class="hover-images effect"><img src="'.$details['img'].'" alt="photo" class="img-fluid. max-width: 10%"></a>
                                                        <a href="product.php?id='.$details['id'].'" class="hover-images effect"><img src="'.$details['img'].'" alt="photo" class="img-fluid. max-width: 10%"></a>
                                                        <a href="product.php?id='.$details['id'].'" class="hover-images effect"><img src="'.$details['img'].'" alt="photo" class="img-fluid. max-width: 10%"></a>
                                                    </div>
                                                </div>
                                                <div class="multiple-img-list-ver2 v2 js-click-product">
                                                    <div class="product-col v2">
                                                        <div class="img active">
                                                            <img src="'.$details['img'].'" alt="photo" class="img-reponsive">
                                                        </div>
                                                    </div>
                                                    <div class="product-col v2">
                                                        <div class="img">
                                                            <img src="'.$details['img'].'" alt="images" class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="product-col v2">
                                                        <div class="img">
                                                            <img src="'.$details['img'].'" alt="images" class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="product-col v2">
                                                        <div class="img">
                                                            <img src="'.$details['img'].'" alt="images" class="img-responsive">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- End super deal -->
        <!-- feature product -->
        <!-- <div class="feature-product spc2"> -->
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1>Featured Products</h1>
                    <a href="accessorieshome.php" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc2">Come and get any Accessories you want.</p>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <ul class="tab-link">
                            <?php 
                                $sql = "SELECT * FROM model ORDER BY id DESC LIMIT 12";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    if (mysqli_num_rows($result)>0) {
                                        while ($details=mysqli_fetch_assoc($result)) {
                                            echo '<li class="">
                                                <a data-toggle="tab" href="#'.$details['id'].'">
                                                    <div class="tab-link-info flex align-center">
                                                        <span>'.$details['name'].'</span>
                                                    </div>
                                                </a>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </div>

                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="tab-content">
                            <?php 
                                $sql = "SELECT * FROM model ORDER BY id DESC LIMIT 12";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    if (mysqli_num_rows($result)>0) {
                                        $x=1;
                                        while ($details=mysqli_fetch_assoc($result)) {
                                            if ($x==1) {
                                                echo '<div id="'.$details['id'].'" class="tab-pane fade in active">';
                                                $x=2;
                                            } else {
                                                echo '<div id="'.$details['id'].'" class="tab-pane fade in">';
                                            }
                                            
                                                echo '<div class="row">';
                                                    $get_product = "SELECT * FROM items WHERE model_id=".$details['id']." ORDER BY id DESC LIMIT 12";
                                                    $product_result = mysqli_query($conn,$get_product);
                                                    if ($product_result) {
                                                        if (mysqli_num_rows($product_result)>0) {
                                                            while ($product_details=mysqli_fetch_assoc($product_result)) {
                                                                echo '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 product-item">
                                                                    <div class="pd-bd product-inner">
                                                                        <div class="product-img">
                                                                            <a href="product.php?id='.$product_details['id'].'"><img src="'.$product_details['img'].'" alt="" class="img-reponsive"></a>
                                                                        </div>
                                                                        <div class="product-info">
                                                                            <!--<div class="color-group">
                                                                                <a href="#" class="circle black"></a>
                                                                                <a href="#" class="circle red"></a>
                                                                                <a href="#" class="circle gray"></a>
                                                                            </div>-->
                                                                            <div class="element-list element-list-left">
                                                                                <ul class="desc-list">
                                                                                   <li>'.$product_details['tag'].'</li>  
                                                                                </ul>
                                                                            </div>
                                                                            <div class="element-list element-list-middle">
                                                                                <div class="product-rating bd-rating">
                                                                                    <span class="star star-5"></span>
                                                                                    <span class="star star-4"></span>
                                                                                    <span class="star star-3"></span>
                                                                                    <span class="star star-2"></span>
                                                                                    <span class="star star-1"></span>
                                                                                    <!--<div class="number-rating">( )</div>-->
                                                                                </div>
                                                                                <h3 class="product-title"><a href="product.php?id='.$product_details['id'].'"">'.$product_details['name'].'</a></h3>
                                                                                <p class="product-cate">'.$product_details['description'].'</p>
                                                                                <div class="product-bottom">
                                                                                    <div class="product-price"><span>Rs: '.($product_details['price']-$product_details['discount']).'</span></div>
                                                                                    <a href="product.php?id='.$product_details['id'].'" class="btn-icon btn-view">
                                                                                        <span class="icon-bg icon-view"></span>
                                                                                    </a>
                                                                                </div>    
                                                                                <div class="product-bottom-group">
                                                                                    <a href="#" class="btn-icon">
                                                                                        <span class="icon-bg icon-cart"></span>
                                                                                    </a>
                                                                                    <a href="#" class="btn-icon">
                                                                                        <span class="icon-bg icon-wishlist"></span>
                                                                                    </a>
                                                                                    <a href="#" class="btn-icon">
                                                                                        <span class="icon-bg icon-compare"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>                                 
                                                                        </div>
                                                                        <div class="product-button-group">
                                                                            <a href="#" class="btn-icon">
                                                                                <span class="icon-bg icon-cart"></span>
                                                                            </a>
                                                                            <a href="#" class="btn-icon">
                                                                                <span class="icon-bg icon-wishlist"></span>
                                                                            </a>
                                                                            <a href="#" class="btn-icon">
                                                                                <span class="icon-bg icon-compare"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                            }
                                                        }
                                                    }
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            ?>
     
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- End feature product -->
        <!-- Homepage banner -->
        <!-- <div class="homepage-banner spc3">
            <div class="container container-240">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="banner-img effect-img3 plus-zoom">
                            <a href="#" class=""><img src="img/banner/h2_b4.jpg" alt="" class="img-responsive"></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="banner-img effect-img3 plus-zoom">
                            <a href="#"><img src="img/banner/h2_b5.jpg" alt="" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End Homepage banner -->
        <!-- best seller -->
        <!-- <div class="feature-product spc3"> -->
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1>Latest Movies</h1>
                    <a href="movieshome.php" class="btn-show">See more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc3">Come and get any movies you want.</p>
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <ul class="tab-link">
                            <?php
                                $sql = "SELECT distinct(language) FROM movies ORDER BY id DESC LIMIT 12";
                                $result = mysqli_query($conn,$sql);
                                if ($result) {
                                    if (mysqli_num_rows($result)>0) {
                                        while ($details = mysqli_fetch_assoc($result)) {
                                            echo '<li class="">
                                                <a data-toggle="tab" href="#'.$details['language'].'">
                                                    <div class="tab-link-info flex align-center">
                                                        <span>'.$details['language'].'</span>
                                                    </div>
                                                </a>
                                            </li>';
                                        }
                                    }
                                }
                            ?>
                            
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="tab-content">
                            <?php 
                                $sql = "SELECT distinct(language) FROM movies ORDER BY id DESC LIMIT 12";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    if (mysqli_num_rows($result)>0) {
                                        $x=1;
                                        while ($details=mysqli_fetch_assoc($result)) {
                                            if ($x==1) {
                                                echo '<div id="'.$details['language'].'" class="tab-pane fade in active">';
                                                $x=2;
                                            } else {
                                                echo '<div id="'.$details['language'].'" class="tab-pane fade in">';
                                            }
                                                echo '<div class="row">';
                                                    $get_movie = "SELECT * FROM movies WHERE language='".$details['language']."' ORDER BY id DESC LIMIT 12";
                                                    $movie_result = mysqli_query($conn,$get_movie);
                                                    if ($movie_result) {
                                                        if (mysqli_num_rows($movie_result)>0) {
                                                            while ($movie_details=mysqli_fetch_assoc($movie_result)) {
                                                                echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 product-item">
                                                                    <div class="blog-img">
                                                                        <a href="movieshome.php?filter='.$movie_details['name'].'" class="hover-images"><img src="'.$movie_details['img'].'" alt="" class="img-reponsive"></a>
                                                                        
                                                                    </div>
                                                                    <div class="blog-info">
                                                                        <h3 class="blog-post-title"><a href="movieshome.php?filter='.$movie_details['name'].'">'.$movie_details['name'].'</a></h3>
                                                                        <p class="blog-post-desc">'.$movie_details['description'].'</p>
                                                                        <div class="blog-post-author">
                                                                            <div class="author">Posted by <span class="c-black">Admin</span></div>
                                                                             <div class="blog-post-comment"><span class="c-black"></span>2</div>
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                            }
                                                        }
                                                    }
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- End best seller -->
        <!-- Brand  -->
        <div class="brand v2">
            <div class="container container-240">
                <div class="owl-carousel owl-theme owl-brand js-owl-brand2">
                    
                    <?php 
                        $sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 20";
                        $result = mysqli_query($conn,$sql);
                        if ($result) {
                            if (mysqli_num_rows($result)>0) {
                                while ($details=mysqli_fetch_assoc($result)) {
                                    echo '<div class="brand-item">
                                        <a href="movieshome.php?filter='.$details['name'].'" class="hover-images"><img src="'.$details['img'].'" alt=""></a>
                                        <span>'.$details['name'].'</span>
                                    </div>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- End Brand  -->
        <!-- Our blog -->
        <div class="our-blog bg">
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1 class="v2">Latest Games</h1>
                    <a href="gameshome.php" class="btn-show">View more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc2">Come and get any games you want.</p>
                <div class="product-tab-pd owl-carousel owl-theme js-owl-blog owl-custom-dots v2">
                    <?php 
                        $sql = "SELECT * FROM games ORDER BY id DESC LIMIT 9";
                        $result = mysqli_query($conn,$sql);
                        if ($result) {
                            if (mysqli_num_rows($result)>0) {
                                while ($details=mysqli_fetch_assoc($result)) {
                                    echo '<div class="blog-post-item v3">
                                        <div class="blog-img">
                                            <a href="gameshome.php?filter='.$details['name'].'" class="hover-images"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                        </div>
                                        <div class="heading-blog flex align-center">
                                            <div class="blog-post-date e-gradient">
                                                <span class="b-date">'.$details['dvd'].'</span>
                                                <span class="b-month">DVD</span>
                                            </div>
                                            <h3 class="blog-post-title"><a href="gameshome.php?filter='.$details['name'].'">'.$details['name'].'</a></h3>
                                        </div>
                                        <p class="blog-post-desc">'.$details['description'].'</p>
                                        <div class="blog-post-author">
                                            <div class="author">Available since <span class="c-black">'.$details['available'].'</span></div>
                                            <div class="blog-post-comment"><span class="c-black"></span>2</div>
                                        </div>
                                    </div>';
                                }
                            }
                        }

                    ?>
                    
                    
                </div>
            </div>
        </div>
        <!-- End blog -->
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
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/main.js"></script>

    <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>