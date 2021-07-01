<?php require_once('connection.php'); ?>

<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  } 
?>


<?php
    $filter ="";
    $list = "";
    $page_detail = "";
    $number_of_result = 0;
    $page_no = 1;
    $rows_per_page = 16;

    //get page number------------------
    if (isset($_GET['page_no'])) {
        $page_no = mysqli_real_escape_string($conn,$_GET['page_no']);
    } else {
        $page_no = 1;
    }

    $start_page = ($page_no-1) * $rows_per_page;
    

    //create items list ------------------------------
    $sql = "SELECT * FROM items";


    // filter the list---------------------------------

    if (isset($_GET['model'])) {
        $model = mysqli_real_escape_string($conn,$_GET['model']);
        $page_detail .= "&&model=".$model;

        $sql = "SELECT * FROM items WHERE model_id={$model}";
        
    }

    if (isset($_GET['filter'])) {
        $filter = mysqli_real_escape_string($conn,$_GET['filter']);
        $page_detail .= "&&filter=".$filter;

        $sql = "SELECT * FROM items WHERE name LIKE '%$filter%' OR description LIKE '%$filter%'OR tag LIKE '%$filter%'";
        
    }

    //search--------------------------------

    if (isset($_GET['searchsubmit'])) {
        $search_text = "";
        $search_category = "";

        $search_text = mysqli_real_escape_string($conn,$_POST['search_text']);
        $page_detail .= "&&search_text=".$search_text;

        $sql = "SELECT * FROM items WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%'OR tag LIKE '%$search_text%'";


        
    }

    // sort the list---------------------------------

    if (isset($_GET['sort'])) {
        $sort = mysqli_real_escape_string($conn,$_GET['sort']);
        $page_detail .= "&&sort=".$sort;

        switch ($sort) {
            case 'priceaz':
                $sql .= " ORDER BY price";
                break;

            case 'priceza':
                $sql .= " ORDER BY price DESC";
                break;

            case 'discountaz':
                $sql .= " ORDER BY discount";
                break;

            case 'discountza':
                $sql .= " ORDER BY discount DESC";
                break;

            case 'newaz':
                $sql .= " ORDER BY id DESC";
                break;

            case 'newza':
                $sql .= " ORDER BY id";
                break;
            
            default:
                $sql .= " ORDER BY id DESC";
                break;
        }

        
    }else{
        $sql .= " ORDER BY id DESC";
    }

    $sql_all = $sql;
    $sql .= " LIMIT {$start_page}, {$rows_per_page}";

    $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result)>0) {
                while ($details = mysqli_fetch_assoc($result)) {
                    $list .= '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 product-item">
                            <div class="pd-bd product-inner">
                                <div class="product-img">
                                    <a href="product.php?id='.$details['id'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                </div>
                                <div class="product-info">
                                    <!--<div class="color-group">
                                        <a href="#" class="circle black"></a>
                                        <a href="#" class="circle red"></a>
                                        <a href="#" class="circle gray"></a>
                                    </div>-->
                                    <div class="element-list element-list-left">
                                        <ul class="desc-list">
                                           <li>'.$details['tag'].'</li>  
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
                                        <h3 class="product-title"><a href="product.php?id='.$details['id'].'"">'.$details['name'].'</a></h3>
                                        <p class="product-cate">'.$details['description'].'</p>
                                        <div class="product-bottom">
                                            <div class="product-price"><span>Rs: '.($details['price']-$details['discount']).'</span></div>
                                            <a href="product.php?id='.$details['id'].'" class="btn-icon btn-view">
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
                $number_of_result = mysqli_num_rows($result);
            }
        }

            //pagination-----------------------
        $first = '<li></li>';
        $prev = '<li></li>';
        $current = '<li></li>';
        $next = '<li></li>';
        $last = '<li></li>';

        $result_sql_all = mysqli_query($conn,$sql_all);
        $no_fo_record = mysqli_num_rows($result_sql_all);
        $prev_no = ($page_no-1);
        $next_no = ($page_no+1);
        $last_page_no = ceil($no_fo_record/$rows_per_page);

        //first page............
        if ($page_no<=1) {
            $first = '<li><a>First</a></li>';
        } else {
            $first = '<li><a href="accessorieshome.php?page_no=1">First</a></li>';
        }

        //prev page............
        if ($page_no<=1) {
            $prev = '<li><a><i class="ion-ios-arrow-back"></i></a></li>';
        } else {
            $prev = '<li><a href="accessorieshome.php?page_no='.$prev_no.'"><i class="ion-ios-arrow-back"></i></a></li>';
        }

        //current page............
        $current = '<li><a> Page '.$page_no.' of '.$last_page_no.'</a></li>';

        //next page..........
        if ($page_no>=$last_page_no) {
            $next = '<li><a><i class="ion-ios-arrow-forward"></i></a></li>';
        } else {
            $next = '<li><a href="accessorieshome.php?page_no='.$next_no.'"><i class="ion-ios-arrow-forward"></i></a></li>';
        }

        //last page................
        if ($page_no>=$last_page_no) {
            $last = '<li><a>Last</a></li>';
        } else {
            $last = '<li class="active"><a href="accessorieshome.php?page_no='.$last_page_no.'">Last</a></li>';
        }

        
        $pagination = $first.$prev.$current.$next.$last;


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
            <form role="search" method="get" id="searchform" class="searchform" action="accessorieshome.php">
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
                            <form method="get" class="searchform ajax-search" action="accessorieshome.php" role="search">
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
                                                        echo '<li class="vertical-item level1 mega-parent"><a href="accessorieshome.php?model='.$details['id'].'">'.$details['name'].'</a></li>';
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
        <div class="container container-240">
            <div class="e-product">
                <ul class="breadcrumb v4">
                    <li>Home</li>
                    <li class="active">Shop</li>
                </ul>
                <div class="pd-banner">
                   <a class="image-bd effect_img2"><img src="img/banner/Accessoriebaner.jpg" alt="" class="img-reponsive"></a> 
                </div>
                <div class="pd-top">
                    <h1 class="title">Shop</h1>
                    <!-- <div class="show-element"><span>Showing 1–15 of 20 results</span></div> -->
                </div>
                <div class="pd-middle">
                    <div class="view-mode view-group">
                        <a class="grid-icon col active"><img src="img/grid.png" alt=""></a>
                        <a class="grid-icon col2"><img src="img/grid2.png" alt=""></a>
                        <a class="list-icon list"><img src="img/list.png" alt=""></a>
                    </div>
                    <div class="pd-sort">
                        <div class="filter-sort">
                            <div class="dropdown">
                              <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="dropdown-label">Default sorting</span>
                              </button>
                              <ul class="dropdown-menu">
                                  <li><a href="accessorieshome.php?sort=priceaz">Price A-Z</a></li>   
                                  <li><a href="accessorieshome.php?sort=priceza">Price Z-A</a></li>   
                                  <li><a href="accessorieshome.php?sort=discountaz">Discount A-Z</a></li>
                                  <li><a href="accessorieshome.php?sort=discountza">Discount Z-A</a></li>
                                  <li><a href="accessorieshome.php?sort=newaz">New A-Z</a></li>
                                  <li><a href="accessorieshome.php?sort=newza">New Z-A</a></li>
                              </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-collection-grid product-grid spc1">
                    <div class="row">
                        <?php 
                            echo $list;

                        ?>
                        
                    </div>
                </div>
                <div class="pd-middle space-v1">
                    <ul class="pagination">
                        <?php echo $pagination; ?>
                    </ul>
                    <div class="pd-sort hidden-xs hidden-sm">
                        <div class="filter-sort">
                            <div class="dropdown">
                              <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="dropdown-label">Default sorting</span>
                              </button>
                              <ul class="dropdown-menu">
                                  <li><a href="accessorieshome.php?sort=priceaz">Price A-Z</a></li>   
                                  <li><a href="accessorieshome.php?sort=priceza">Price Z-A</a></li>   
                                  <li><a href="accessorieshome.php?sort=discountaz">Discount A-Z</a></li>
                                  <li><a href="accessorieshome.php?sort=discountza">Discount Z-A</a></li>
                                  <li><a href="accessorieshome.php?sort=newaz">New A-Z</a></li>
                                  <li><a href="accessorieshome.php?sort=newza">New Z-A</a></li>
                              </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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