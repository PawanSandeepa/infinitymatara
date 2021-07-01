<?php //require_once('external_html.php'); ?>
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


  if (isset($_POST['model_submit'])) {

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $date = date('d-m-y h:i:s');

    //check empty fild......
    $req_field = array('name','description','category');
    $error=array_merge($error, check_empty($req_field));

    //check lenth ..........
    $max_length = array('name'=>100,'description'=>255,'category'=>20);
    $lenth_error=array_merge($lenth_error, check_length($max_length));

    if (empty($error)&&empty($lenth_error)) {
      $query = "INSERT INTO model(name,category,description) VALUES('{$name}','{$category}','{$description}')";
      $result = mysqli_query($conn , $query);
      if ($result) {
        $msg = ("model added");
        
      }else{
        $error[]="Query error";
      }
    }
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
    $date = date('d-m-y h:i:s');

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

    //check image............
    if (preg_match("!image!",$_FILES['image']['type'])) {
      $image = mysqli_real_escape_string($conn,'img/item/'.$name.$_FILES['image']['name']);
      if (copy($_FILES['image']['tmp_name'],$image)) {
        $date = date('d-m-y h:i:s');
        if (empty($error)&&empty($lenth_error)) {
            // echo $name.$description.$price.$tag.$model_id.$discount.$image.$quantity.$date;
          $query = "INSERT INTO items(name,description,price,tag,model_id,discount,img,quantity,added_time) VALUES('{$name}','{$description}',{$price},'{$tag}',{$model_id},{$discount},'{$image}',{$quantity},'{$date}')";
          $result = mysqli_query($conn , $query);
          if ($result) {
            $msg = ("item added");
            // if (mail($mail,$title,$msg,$header)) {
            //     echo '<script type="text/javascript">';
            //       echo 'alert(\'payment succed. check your mail.\')';
            //     echo '</script>';
            // }else{
            //     echo '<script type="text/javascript">';
            //       echo 'alert(\'payment succed. But can\'t send mail.!!!\')';
            //     echo '</script>';
            // }
            
          }else{
            $error[]="Query error";
          }
        }
      }
    }else{
      $error[]="invalid image type";
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
                    <li><a href="admin_dashbord.php">Admin</a></li>
                    <li class="active">Add Accesories</li>
                </ul>
                <div class="row flex pd">
                    <div class="account-element bd-7 e-left">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v1">Model</h1>
                        </div>
                        <div class="page-content">
                            <p>Add Model for Items</p>
                            <form class="login-form" method="post" action="additems.php" enctype = "multipart/form-data">
                                <div class="alert-danger"><p id="error"><?php print_error($error,$lenth_error); ?></p></div>
                                <div class="alert-success"><p id="msg"></p></div> 
                                  <div class="form-group">
                                    <label>Model Name <span class="f-red">*</span></label>
                                      <input type="text" id="name" class="form-control bdr" name="name" value="">
                                    <label>Category <span class="f-red">*</span></label>
                                      <select class="form-control bdr" name="category" id="category">
                                          <option value="both">Both</option>
                                          <option value="computer">Computer</option>
                                          <option value="phone">Phone</option>
                                      </select>
                                    <label>Description <span class="f-red">*</span></label>
                                      <input type="text" id="description" class="form-control bdr" name="description" value="">
                                  </div>
                                  <div class="flex lr">
                                      <button type="submit" name="model_submit" class="btn btn-submit btn-gradient">
                                          Add
                                        </button>
                                  </div>
                            </form>
                        </div>
                    </div>
                    <div class="account-element bd-7 e-left">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v1">Accesseries</h1>
                        </div>
                        <div class="page-content">
                            <p>Add computer or phone accesseries</p>
                            <form class="login-form" method="post" action="additems.php" enctype = "multipart/form-data">
                                <div class="alert-danger"><p id="error"><?php print_error($error,$lenth_error); ?></p></div>
                                <div class="alert-success"><p id="msg"></p></div> 
                                  <div class="form-group">
                                    <label>Item Name <span class="f-red">*</span></label>
                                      <input type="text" id="name" class="form-control bdr" name="name" value="">
                                      <label>Description <span class="f-red">*</span></label>
                                      <input type="text" id="description" class="form-control bdr" name="description" value="">
                                      <label>Price <span class="f-red">*</span></label>
                                      <input type="number" id="price" class="form-control bdr" name="price" value="">
                                      <label>Tags <span class="f-red">*</span></label>
                                      <input type="text" id="tag" class="form-control bdr" name="tag" value="">
                                      <label>Model <span class="f-red">*</span></label>
                                      <input list="brow" class="form-control bdr" placeholder="" name="model" id="model">
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
                                      <label>Discount <span class="f-red">*</span></label>
                                      <input type="number" id="discount" class="form-control bdr" name="discount" value="0">
                                      <label>Quantity <span class="f-red">*</span></label>
                                      <input type="number" id="quantity" class="form-control bdr" name="quantity" value="1">
                                      <label>Image <span class="f-red">*</span></label>
                                      <input class="form-control bdr" type="file" name="image" id="image" accept="image/*">
                                  </div>
                                  <div class="flex lr">
                                      <button type="submit" name="item_submit" class="btn btn-submit btn-gradient">
                                          Add
                                        </button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="e-category">
            <div class="container">
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <h1 class="cate-title">Last Added Models</h1>
                        <div class="cate-item">
                            <div class="product-img">
                                
                            </div>
                            <div class="product-info">
                                <?php
                                    $sql = "SELECT * FROM model ORDER BY id DESC LIMIT 5";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result)>0) {
                                            while($detail=mysqli_fetch_assoc($result)){
                                                echo '<h3 class="product-title"><a href="#">'.$detail['name'].' </a></h3>';
                                                echo '<div class="product-price v2"><span>'.$detail['description'].'</span></div>';
                                            }
                                        }
                                    }
                                ?>
                                
                                
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <h1 class="cate-title">Last Added Item</h1>
                        <div class="cate-item">
                            <?php
                                $sql = "SELECT * FROM items ORDER BY id DESC LIMIT 5";
                                $result = mysqli_query($conn,$sql);
                                if ($result) {
                                    if (mysqli_num_rows($result)>0) {
                                        while($detail=mysqli_fetch_assoc($result)){
                                            echo '<div class="product-img">';
                                            echo '<a href="product.php?id='.$detail['id'].'"><img src="'.$detail['img'].'" alt="" class="img-reponsive"></a>';
                                            echo '</div><div class="product-info">';
                                            echo '<h3 class="product-title"><a href="product.php?id='.$detail['id'].'">'.$detail['name'].' </a></h3>';
                                            echo '<div class="product-price v2"><span>'.$detail['description'].'</span></div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            ?>    
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

      <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>