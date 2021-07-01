<?php require_once('connection.php'); ?>

<?php 
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  } 
?>

<div class="topbar">
   <div class="container container-240">
       <div class="row flex">
           <div class="col-md-6 col-sm-6 col-xs-4 flex-left">
               <div class="topbar-left">
                   <div class="element element-store hidden-xs hidden-sm">
                        <a id="label1" class="dropdown-toggle" data-toggle="dropdown" role="button" href="contactus.php">
                        <img src="img/icon-map.png" alt="">
                          <span>Store Location</span>
                          
                        </a>
                    </div>
                    <!-- <div class="element hidden-xs hidden-sm">
                        <a href="#"><img src="img/icon-track.png" alt=""><span>Track Your Order</span></a>
                    </div> -->
                    <div class="element element-account">
                        <a href="login.php">
                          <span>My Account</span>
                        </a>
                    </div>
                    <?php 
                        if (isset($_SESSION['position'])) {
                            if ($_SESSION['position']=='admin') {
                                echo '<div class="element element-account">
                                    <a href="admin.php">
                                      <span>Admin Panel</span>
                                    </a>
                                </div>';
                            }
                        }

                    ?>
                </div>
           </div>
           <div class="col-md-6 col-sm-6 col-xs-8 flex-right">
                <div class="topbar-right">
                   
                    <div class="element ">
                        <a href="contactus.php">Help</a>
                    </div>
                    <div class="element ">
                        <a href="aboutus.php">About Us</a>
                    </div>
                </div>
           </div>
            
       </div>
   </div>
</div>