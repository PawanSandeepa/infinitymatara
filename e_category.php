<div class="e-category">
    <div class="container container-240">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <a href="accessorieshome.php"><h1 class="cate-title">Latest Products</h1></a>
                <?php 
                    $sql = "SELECT * FROM items ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        if (mysqli_num_rows($result)>0) {
                            while ($details=mysqli_fetch_assoc($result)) {
                                echo '<div class="cate-item">
                                    <div class="product-img">
                                        <a href="product.php?id='.$details['id'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="product.php?id='.$details['id'].'">'.$details['name'].'</a></h3>
                                        <div class="product-price v2"><span>'.$details['description'].'</span></div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <a href="movieshome.php"><h1 class="cate-title">Latest Movies</h1></a>
                <?php 
                    $sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        if (mysqli_num_rows($result)>0) {
                            while ($details=mysqli_fetch_assoc($result)) {
                                echo '<div class="cate-item">
                                    <div class="product-img">
                                        <a href="movieshome.php?filter='.$details['name'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="movieshome.php?filter='.$details['name'].'">'.$details['name'].'</a></h3>
                                        <div class="product-price v2"><span>'.$details['description'].'</span></div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <a href="gameshome.php"><h1 class="cate-title">Latest Games</h1></a>
                <?php 
                    $sql = "SELECT * FROM games ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        if (mysqli_num_rows($result)>0) {
                            while ($details=mysqli_fetch_assoc($result)) {
                                echo '<div class="cate-item">
                                    <div class="product-img">
                                        <a href="gameshome.php?filter='.$details['name'].'"><img src="'.$details['img'].'" alt="" class="img-reponsive"></a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="gameshome.php?filter='.$details['name'].'">'.$details['name'].'</a></h3>
                                        <div class="product-price v2"><span>'.$details['description'].'</span></div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>