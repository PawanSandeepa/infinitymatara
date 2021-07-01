<?php require_once('external_php.php'); ?>
<?php require_once('connection.php'); ?>

<?php 


    $filter ="";
    $list = "";
    $page_detail = "";
    $number_of_result = 0;
    $page_no = 1;
    $rows_per_page = 12;

    //get page number------------------
    if (isset($_GET['page_no'])) {
        $page_no = mysqli_real_escape_string($conn,$_GET['page_no']);
    } else {
        $page_no = 1;
    }

    $start_page = ($page_no-1) * $rows_per_page;
    

    //create movies list ------------------------------
    $sql_all = "SELECT * FROM games ORDER BY id DESC";
    $sql = "SELECT * FROM games ORDER BY id DESC LIMIT {$start_page}, {$rows_per_page}";


    // filter the list---------------------------------

    if (isset($_GET['filter'])) {
        $filter = mysqli_real_escape_string($conn,$_GET['filter']);
        $page_detail .= "&&filter=".$filter;

        $sql_all = "SELECT * FROM games WHERE name LIKE '%$filter%' OR description LIKE '%$filter%' OR tag LIKE '%$filter%'";
        $sql = "SELECT * FROM games WHERE name LIKE '%$filter%' OR description LIKE '%$filter%' OR tag LIKE '%$filter%' LIMIT {$start_page}, {$rows_per_page}";
        
    }

    //search--------------------------------

    if (isset($_POST['searchsubmit'])) {
        $search_text = "";

        $search_text = mysqli_real_escape_string($conn,$_POST['search_text']);
        $page_detail .= "&&search_text=".$search_text;

        $sql_all = "SELECT * FROM games WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%' OR tag LIKE '%$search_text%'";
        $sql = "SELECT * FROM games WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%' OR tag LIKE '%$search_text%' LIMIT {$start_page}, {$rows_per_page}";

        

        
    }

    $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result)>0) {
                while ($details = mysqli_fetch_assoc($result)) {
                    $list .= '<div class="col-md-4 col-sm-6 col-xs-12 blog-post-item">
                                <div class="blog-img">
                                    <img src="'.$details['img'].'" alt="" class="img-reponsive">
                                    <div class="blog-post-date e-gradient abs">
                                        <span class="b-date">'.$details['dvd'].'</span>
                                        <span class="b-month">DVD</span>
                                    </div>
                                </div>
                                <div class="blog-info">
                                    <h3 class="blog-post-title">'.$details['name'].'</h3>
                                    <p class="blog-post-desc">'.$details['description'].'</p>
                                    <div class="blog-post-author">
                                        <div class="author">Posted by <span class="c-black">Admin</span></div>
                                         <div class="blog-post-comment"><span class="c-black"></span>2</div>
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
            $first = '<li><a href="gameshome.php?page_no=1'.$page_detail.'">First</a></li>';
        }

        //prev page............
        if ($page_no<=1) {
            $prev = '<li><a><i class="ion-ios-arrow-back"></i></a></li>';
        } else {
            $prev = '<li><a href="gameshome.php?page_no='.$prev_no.''.$page_detail.'"><i class="ion-ios-arrow-back"></i></a></li>';
        }

        //current page............
        $current = '<li><a> Page '.$page_no.' of '.$last_page_no.'</a></li>';

        //next page..........
        if ($page_no>=$last_page_no) {
            $next = '<li><a><i class="ion-ios-arrow-forward"></i></a></li>';
        } else {
            $next = '<li><a href="gameshome.php?page_no='.$next_no.''.$page_detail.'"><i class="ion-ios-arrow-forward"></i></a></li>';
        }

        //last page................
        if ($page_no>=$last_page_no) {
            $last = '<li><a>Last</a></li>';
        } else {
            $last = '<li class="active"><a href="gameshome.php?page_no='.$last_page_no.''.$page_detail.'">Last</a></li>';
        }

        
        $pagination = $first.$prev.$current.$next.$last;



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Infinity Games</title>
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
            <form role="search" method="post" id="searchform" class="searchform" action="gameshome.php">
                <div>
                    <label class="screen-reader-text" for="q"></label>
                    <input type="text" placeholder="Search..." value="" name="search_text" id="q" autocomplete="off">
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
        <header id="header" class="header-v2">
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
                            <form method="post" class="searchform ajax-search" action="gameshome.php" role="search">
                                <input type="text" name="search_text" class="form-control" placeholder="i’m shoping for...">
                                
                                <div class="search-panel">
                                    
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
                        <div class="col-lg-12 widget-middle">
                            <div class="flex lr">
                                <nav class="main-menu">
                                    <div class="collapse navbar-collapse" id="myNavbar">
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
                                            <li class="level1"><a href="gameshome.php?sort=newaz">Latest Games<span class="h-ribbon h-pos e-green v4">new</span></a></li>
                                            <li class="level1"><a href="gameshome.php?filter=racing">Racing</a></li>
                                            <li class="level1"><a href="gameshome.php?filter=camando">Camando</a></li>
                                            <li class="level1"><a href="gameshome.php?filter=playstation">Playstation<span class="h-ribbon h-pos e-red v4">hot</span></a></li>
                                            
                                        </ul>
                                    </div>
                                </nav>
                                <!-- <div class="header-bottom-right hidden-xs hidden-sm">
                                    <img src="img/icon-ship.png" alt="" class="img-reponsive">
                                    <span>Free Shipping on Orders $100</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /header -->
            

            <!--content-->
            <div class="container container-240">
                <div class="blog-banner pd-banner v2">
                   <a class="effect_img2"><img src="img/banner/gamebaner.jpg" alt="" class="img-reponsive"></a> 
                </div>
                <div class="blog spc1">
                    <ul class="breadcrumb">
                        <li>Home</li>
                        <li class="active">Games</li>
                    </ul>
                    <div class="blog-grid">
                        <h1 class="blog-heading text-center">Games</h1>
                        <div class="row">
                            
                            <?php echo $list; ?>
                            
                        </div>
                    </div>
                    <ul class="pagination">
                        <?php echo $pagination; ?>
                    </ul>
                </div>
            </div>

            <!-- Banner -->
                <?php require_once('e_category.php'); ?>
            <footer>
                <?php require_once('footer.php'); ?>
                <?php require_once('dev_footer.php'); ?>
            </footer>
            <!-- /footer -->
            <!-- /footer -->
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/main.js"></script>
</body>

</html>