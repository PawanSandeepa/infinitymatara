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
  }
?>

<?php 

    $name = "";
    $description = "";
    $price = "";
    $gat = "";
    $model_id = "";
    $discount = "";
    $img = "";
    $quantity = "";
    $added_time = "";
    $model_name = "";
    
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn,$_GET['id']);

        $sql = "SELECT * FROM items WHERE id = {$id} LIMIT 1";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result)>0) {
                while ($details=mysqli_fetch_assoc($result)) {
                    $name = $details['name'];
                    $description = $details['description'];
                    $price = $details['price'];
                    $tag = $details['tag'];
                    $model_id = $details['model_id'];
                    $discount = $details['discount'];
                    $img = $details['img'];
                    $quantity = $details['quantity'];
                    $added_time = $details['added_time'];
                }
                $get_model_name = "SELECT name FROM model WHERE id={$model_id} LIMIT 1";
                $model_name_result = mysqli_query($conn,$get_model_name);
                if ($model_name_result) {
                    if (mysqli_num_rows($model_name_result)==1) {
                        while ($model_detail = mysqli_fetch_assoc($model_name_result)) {
                            $model_name = $model_detail['name'];
                        }
                    }
                }
            }
        }
    }else{
        header('Location:accessorieshome.php');
    }



      if (isset($_POST['item_submit'])) {
    $discount=0;

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $tag = mysqli_real_escape_string($conn,$_POST['tag']);
    $model = mysqli_real_escape_string($conn,$_POST['model']);
    $discount = mysqli_real_escape_string($conn,$_POST['discount']);
    $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);

    //check empty fild......
    $req_field = array('name','description','price','tag','model','quantity');
    $error=array_merge($error, check_empty($req_field));

    //check lenth ..........
    $max_length = array('name'=>100,'description'=>800,'price'=>11,'tag'=>800,'model'=>11,'discount'=>11,'quantity'=>11);
    $lenth_error=array_merge($lenth_error, check_length($max_length));

    if (empty($error)&&empty($lenth_error)) {
        $sql = "SELECT * FROM model WHERE name='{$model}' limit 1";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            if (mysqli_num_rows($result)==1) {
                while ($detail=mysqli_fetch_assoc($result)) {
                    $model_id=$detail['id'];
                }
            }else{
                $error[]='invalid model';
            }
        }
    }

    if (empty($error)&&empty($lenth_error)) {
        $query = "UPDATE items SET name='{$name}',description='{$description}',price={$price},tag='{$tag}',model_id={$model_id},discount={$discount},quantity={$quantity} WHERE id={$id} LIMIT 1";
      $result = mysqli_query($conn , $query);
      if ($result) {
        header('Location:product.php?id='.$id.'&&status=ProductUpdated');
        
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
    <title>Infinity Product</title>
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
                                                <li class="level1 dropdown hassub"><a href="accessorieshome.php">Shop<span class="h-ribbon h-pos e-green">sale</span></a>

                                                    <span class="plus js-plus-icon"></span>
                                                    <div class="menu-level-1 dropdown-menu">
                                                        <ul class="level1">
                                                            <li class="level2 col-4">
                                                                <a href="accessorieshome.php?filter=phone">Phone Accessories</a>
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
                                                                <a href="accessorieshome.php?filter=computer">Computer Accessories</a>
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
             <div class="single-product-detail product-bundle product-aff">
                <ul class="breadcrumb">
                    <li><a href="accessorieshome.php">Home</a></li>
                    <li class="active">Accessories</li>
                    <li class="active"><?php echo $name;?> </li>
                </ul>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        
                        <div class="flex product-img-slide">
                            
                        
                            <div class="product-images">
                                <div class="main-img js-product-slider">
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                    <a class="hover-images effect"><img src="<?php echo $img; ?>" alt="photo" class="img-reponsive"></a>
                                </div>
                            </div>
                            <div class="multiple-img-list-ver2 js-click-product">
                                <div class="product-col">
                                    <div class="img active">
                                        <img src="<?php echo $img; ?>" alt="photo" class="img-reponsive">
                                    </div>
                                </div>
                                <div class="product-col">
                                    <div class="img">
                                        <img src="<?php echo $img; ?>" alt="images" class="img-responsive">
                                    </div>
                                </div>
                                <div class="product-col">
                                    <div class="img">
                                        <img src="<?php echo $img; ?>" alt="images" class="img-responsive">
                                    </div>
                                </div>
                                <div class="product-col">
                                    <div class="img">
                                        <img src="<?php echo $img; ?>" alt="images" class="img-responsive">
                                    </div>
                                </div>
                                <div class="product-col">
                                    <div class="img">
                                        <img src="<?php echo $img; ?>" alt="images" class="img-responsive">
                                    </div>
                                </div>
                                <div class="product-col">
                                    <div class="img">
                                        <img src="<?php echo $img; ?>" alt="images" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                           
                        
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="single-flex">
                            <div class="single-product-info product-info product-grid-v2 s-50">
                                <p class="product-cate"><?php echo $name; ?></p>
                                <div class="product-rating">
                                    <span class="star star-5"></span>
                                    <span class="star star-4"></span>
                                    <span class="star star-3"></span>
                                    <span class="star star-2"></span>
                                    <span class="star star-1"></span>
                                    <!-- <div class="number-rating">( 896 reviews )</div> -->
                                </div>
                                <form method="post" class="myaccount form-customer form-login js-openlogin">
                                    <p>Edit Product Details.</p>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">Product ID</label>
                                        <input type="text" class="form-control form-account form-account" name="id" value="<?php echo $id;?>" readonly>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Name *</label>
                                        <input type="text" class="form-control form-account form-account" name="name" value="<?php echo $name;?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Description *</label>
                                        <input type="text" class="form-control form-account form-account" name="description" value="<?php echo $description;?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Price *</label>
                                        <input type="number" class="form-control form-account form-account" name="price" value="<?php echo $price;?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Tag *</label>
                                        <input type="text" class="form-control form-account form-account" name="tag" value="<?php echo $tag;?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Model *</label>
                                        <input list="brow" class="form-control bdr" placeholder="" name="model" id="model" value="<?php echo $model_name;?>">
                                          <datalist id="brow">
                                            <?php
                                            /*--------------- model--------------------*/
                                              $model = "SELECT * FROM model";
                                              $model_result = mysqli_query($conn, $model) or die (mysqli_error($conn));
                                              /*--------------------model shipping table have model-------------------------*/ 
                                              if(mysqli_num_rows($model_result) > 0){
                                                while ($model_result_row = $model_result-> fetch_assoc()){
                                                  echo'<option value="'.$model_result_row['name'].'">';
                                                }
                                              }
                                          ?>
                                        </datalist>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Discount *</label>
                                        <input type="number" class="form-control form-account form-account" name="discount" value="<?php echo $discount;?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputPassword1">Quanity *</label>
                                        <input type="number" class="form-control form-account form-account" name="quantity" value="<?php echo $quantity;?>">
                                    </div>
                                    <div class="form-check ">
                                        <button type="submit" name="update" class="btn btn-submit btn-gradient">Update</button>
                                    </div>
                                </form>

                                
                            
                            </div>
                            <div class="single-product-feature s-50 hidden-xs hidden-sm">
                                <div class="bd-7">
                                    <div class="single-feature-box">
                                        <div class="single-feature-img">
                                            <img src="img/feature/credit-card2.png" alt="">
                                        </div>
                                        <div class="single-feature-info">
                                            <h3>Safe Payment</h3>
                                            <p>Payment can be made upon receipt of the goods.</p>
                                        </div>
                                    </div>

                                    <div class="single-feature-box">
                                        <div class="single-feature-img">
                                            <img src="img/feature/safety2.png" alt="">
                                        </div>
                                        <div class="single-feature-info">
                                            <h3>Confidence</h3>
                                            <p>Our Buyer Protection covers your purchase from click to delivery.</p>
                                        </div>
                                    </div>

                                    <div class="single-feature-box">
                                        <div class="single-feature-img">
                                            <img src="img/feature/truck2.png" alt="">
                                        </div>
                                        <div class="single-feature-info">
                                            <h3>Town Area Delivery</h3>
                                            <p>We are delivery matara town area.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="hot-line e-gradient">
                                    <p>Hotline</p>
                                    <div class="flex align-center tele">
                                        <img src="img/feature/hotline.png" alt="">
                                        <div class="phone-number">
                                            <p>071 720 6006</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="bestseller">
                <div class="ecome-heading style5v3 spc5v3">
                    <h1>Related products</h1>
                    <a href="accessorieshome.php?filter=<?php echo $tag; ?>" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <div class="owl-carousel owl-theme owl-cate v2 js-owl-cate">
                    <?php 
                        $sql = "SELECT * FROM items WHERE tag LIKE '%$tag%' ORDER BY id DESC LIMIT 12";
                        $result = mysqli_query($conn,$sql);
                        if ($result) {
                            if (mysqli_num_rows($result)>0) {
                                while ($details=mysqli_fetch_assoc($result)) {
                                    echo '<div class="product-item">
                                        <div class="pd-bd product-inner">
                                            <div class="product-img">
                                                <a href="product.php?id='.$details['id'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                            </div>
                                            <div class="product-info">
                                                <div class="color-group">
                                                </div>
                                                <div class="element-list element-list-left">
                                                </div>
                                                <div class="element-list element-list-middle">
                                                    <h3 class="product-title"><a href="product.php?id='.$details['id'].'">'.$details['name'].'</a></h3>
                                                    <p class="product-cate">'.$details['description'].'</p>
                                                    <div class="product-bottom">
                                                        <div class="product-price"><span>'.($details['price']-$details['discount']).'</span></div>
                                                        <a href="#" class="btn-icon btn-view">
                                                            <span class="icon-bg icon-view"></span>
                                                        </a>
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
                                        </div>
                                    </div>';
                                }
                            }
                        }

                    ?>
                    

                </div>
            </div>
            
            <div class="bestseller single-space">
                <div class="ecome-heading style5v3 spc5v3">
                    <h1>Similar Brand</h1>
                    <a href="accessorieshome.php?model=<?php echo $model_id; ?>" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <div class="owl-carousel owl-theme owl-cate v2 js-owl-cate">
                    <?php 
                        $sql = "SELECT * FROM items WHERE model_id={$model_id} LIMIT 12";
                        $result = mysqli_query($conn,$sql);
                        if ($result) {
                            if (mysqli_num_rows($result)>0) {
                                while ($details=mysqli_fetch_assoc($result)) {
                                    echo '<div class="product-item">
                                        <div class="pd-bd product-inner">
                                            <div class="product-img">
                                                <a href="product.php?id='.$details['id'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                            </div>
                                            <div class="product-info">
                                                <div class="color-group">
                                                </div>
                                                <div class="element-list element-list-left">
                                                </div>
                                                <div class="element-list element-list-middle">
                                                    <h3 class="product-title"><a href="product.php?id='.$details['id'].'">'.$details['name'].'</a></h3>
                                                    <p class="product-cate">'.$details['description'].'</p>
                                                    <div class="product-bottom">
                                                        <div class="product-price"><span>'.($details['price']-$details['discount']).'</span></div>
                                                        <a href="#" class="btn-icon btn-view">
                                                            <span class="icon-bg icon-view"></span>
                                                        </a>
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
                                        </div>
                                    </div>';
                                }
                            }
                        }

                    ?>
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
    <script src="js/main.js"></script>
</body>

</html>