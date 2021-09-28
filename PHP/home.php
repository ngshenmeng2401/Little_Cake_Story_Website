<?php
session_start();
include("dbconnect.php");

if(isset($_POST['addToCart'])){
    
    $product_type = $_GET['product_type'];
    
    if (isset($_SESSION["email"])){
        
        $product_price = $_POST['price'];
        $product_no = $_POST['productNo'];
        $email = $_SESSION["email"];
        $product_qty = "1";
        $product_size = $_POST["size"];
        $eggless = $_POST["eggless"];
        $message = "No Message";
        
        if(isset($product_size)){
            
            if($product_size=="slice"){
                $price1 = round((doubleval($product_price)/6),2);
            }else if($product_size=="6"){
                $price1 = round((doubleval($product_price)),2);
            }else if($product_size=="8"){
                $price1 = round((doubleval($product_price)*1.2),2);
            }else if($product_size=="10"){
                $price1 = round((doubleval($product_price)*1.44),2);
            }else{
                $price1 = $product_price;
            }
        }
        if(isset($eggless)){
            
            if($eggless=="true"){
                $price2 = round((doubleval($price1)*1.1),2);
            }else{
                $price2 = $price1;
            }
            $product_price = $price2;
        }
        
        $sqlloadcart= "SELECT * FROM tbl_cart WHERE user_email = '$email' AND product_no = '$product_no' AND product_price = '$product_price'";
        $stmt = $con->prepare($sqlloadcart);
        $stmt->execute();
        $number_of_result = $stmt->rowCount();
        if ($number_of_result == 0) {
            
            $sqladdcart = "INSERT INTO `tbl_cart`(`user_email`, `product_no`, `product_qty`, `product_price`, `product_size`, `eggless`, `message`) VALUES ('$email','$product_no','$product_qty','$product_price','$product_size','$eggless','$message')";
            if ($con->exec($sqladdcart)) {
                echo "<script>alert('Success')</script>";
                echo "<script> window.location.replace('home.php')</script>";
            } else {
                echo "<script>alert('Failed')</script>";
                echo "<script> window.location.replace('home.php')</script>";
            }
        }else { //update cart if the item already in the cart
            $sqlupdatecart = "UPDATE tbl_cart SET product_qty = product_qty +1 WHERE product_no = '$product_no' AND user_email = '$email' AND product_price = '$product_price'";
            if ($con->exec($sqlupdatecart)) {
                echo "<script>alert('Success')</script>";
                echo "<script> window.location.replace('home.php')</script>";
            } else {
                echo "<script>alert('Failed')</script>";
                echo "<script> window.location.replace('home.php')</script>";
            }
        }
    }else{
        echo "<script>alert('Please login an account');</script>";
        echo "<script> window.location.replace('home.php')</script>";
    }
    
}else if(isset($_POST['search'])){
    
    $product_name = $_POST['product_name'];
    
    echo "<script> window.location.replace('./products.php?product_name=$product_name')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" 
    crossorigin="anonymous">

    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/home_style.css">
    
    <!-- Header & Footer CSS -->
    <link rel="stylesheet" href="../css/header_style.css">
    <link rel="stylesheet" href="../css/footer_style.css">

    <!-- Owl Caruosel CSS -->
    <link rel="stylesheet" href="../css/owl_carousel/owl.carousel.css">
    <link rel="stylesheet" href="../css/owl_carousel/owl.theme.default.css">

    <title>Little Cake Story</title>

    <style>
        .owl-theme .owl-dots .owl-dot.active span, 
        .owl-theme .owl-dots .owl-dot:hover span {

            color: #FCD636;
        }
        .owl-theme .owl-nav .owl-prev:hover,
        .owl-theme .owl-nav .owl-next:hover {

            background: transparent;
        }
        
    </style>
</head>
<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light nav-bg-color">
        <div class="container-fluid">
            <img src="../assets/logo2.png" alt="logo" class="logoimg" >
            <a class="navbar-brand" href="./home.php">LITTLE CAKE STORY</a>
            <button class="navbar-toggler" 
                type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNavDropdown" 
                aria-controls="navbarNavDropdown" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="./products.php?product_type=bento_cake">Bento Cake</a></li>
                    <li><a class="dropdown-item" href="./products.php?product_type=cake">Cake</a></li>
                    <li><a class="dropdown-item" href="./products.php?product_type=cup_cake">Cup Cake</a></li>
                    <li><a class="dropdown-item" href="./products.php?product_type=tart">Tart</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about_us.php">About Us</a>
                </li>
            </ul>
            <form class="d-flex" method="post">
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" name="product_name" required>
                <button class="btn me-5 nav-btn-color" type="submit" name="search">Search</button>
            </form>
            <ul class="navbar-nav" >
                
                <?php
                session_start();
                    if (isset($_SESSION["session_id"])){
                        ?>
                        <li class="nav-item me-4">
                            <img src="../assets/profile.png" class="profileimg" alt="profileimg">
                        </li>
                        <li class="nav-item mt-1">
                            <a class="nav-link cursor-pointer" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Logout</a>
                        </li>
                    <?php
                    }else{
                        ?>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="./login.php" >Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./signup.php">SignUp</a>
                        </li>
                    <?php
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" ></a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Logout ?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are You Sure ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <a href="./login.php?status=logout" >
                <button type="button" class="btn nav-btn-color">Yes</button>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- body -->
    <section class="caruosel-img-slider">
        <div class="container">
            <div class="carousel-con img-fluid" >
                <div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner" >
                      <div class="carousel-item active" >
                        <img src="../assets/banner/little_cake_story.png" class="d-block w-100" alt="img">
                      </div>
                      <div class="carousel-item">
                        <img src="../assets/banner/happy_father_day.png" class="d-block w-100" alt="img">
                      </div>
                      <div class="carousel-item">
                        <img src="../assets/banner/happy_mother_day.png" class="d-block w-100" alt="img">
                      </div>
                      <div class="carousel-item">
                        <img src="../assets/banner/bento_cake_series.png" class="d-block w-100" alt="img">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ------------------------------------ Category Section ------------------------------------ -->

    <section class="cateogry-btn">
        <div class="container">
            <div class="row my-3">
                <h3 class = "text-center">Featured Category</h3>
            </div>

            <div class="row">
                <div class="row g-2">
                    <div class="col-2 col-md-3"></div>
                    <div class="col-8 col-md-3">
                        <a href="./products.php?product_type=bento_cake">
                            <img src="../assets/category/bento_cake.jpg" class="img-fluid" alt="img">
                        </a>
                    </div>
                    <div class="col-2 d-md-none"></div>
                    <div class="col-2 d-md-none"></div>
                    <div class="col-8 col-md-3">
                        <a href="./products.php?product_type=cake">
                            <img src="../assets/category/cake.jpg" class="img-fluid" alt="img">
                        </a>
                    </div>
                    <div class="col-1 col-md-3"></div>
                </div>
                <div class="row g-2">
                    <div class="col-2 col-md-3"></div>
                    <div class="col-8 col-md-3">
                        <a href="./products.php?product_type=cup_cake">
                            <img src="../assets/category/cup_cake.jpg" class="img-fluid" alt="img">
                        </a>
                    </div>
                    <div class="col-2 d-md-none"></div>
                    <div class="col-2 d-md-none"></div>
                    <div class="col-8 col-md-3">
                        <a href="./products.php?product_type=tart">
                            <img src="../assets/category/tart.jpg" class="img-fluid" alt="img">
                        </a>
                    </div>
                    <div class="col-2 col-md-3"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------------------------- Best Selling Products -------------------------------------- -->

    <section class="best-selling-products">

        <div class="container product-con">
            <div class = "row my-5">
                <h3 class = "text-center">Best Selling Products</h3>
            </div>
            <div class="row owl-carousel owl-theme" >
                <?php
                
                $sqlloadproduct= "SELECT * FROM tbl_product ORDER BY product_no ASC LIMIT 10,8";
                
                $stmt = $con->prepare($sqlloadproduct);
                $stmt->execute();
                // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $rows = $stmt->fetchAll();
                
                foreach ($rows as $product){
                    extract($product);
                ?>
                    <div class="col product-item">
                        <div class="product-img">
                            <img src="../../littlecakestory/images/product/<?php echo $product_no ?>.png" class="rounded" alt="product-img">
                            <div class = "row btns w-100 mx-auto text-center">
                                <button type = "button" class = "col-6 py-1 rounded" data-bs-toggle="modal" data-bs-target="#addToCartModal"
                                onclick="addToCartValue('<?php echo $product_no ?>','<?php echo $original_price ?>','<?php echo $product["slice"] ?>','<?php echo $product["6_inch"] ?>','<?php echo $product["8_inch"] ?>','<?php echo $product["10_inch"] ?>')">
                                    <i class = "bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class = "d-block text-dark text-decoration-none py-2 product-name"><?php echo $product_name ?></span>
                            <span class = "product-price">RM <?php echo $original_price ?></span>
                            <div class = "rating d-flex mt-1">
                                    <p class="me-1"><?php echo $rating ?></p>
                                    <i class = "bi bi-star-fill"></i>
                                    <i class = "bi bi-star-fill"></i>
                                    <i class = "bi bi-star-fill"></i>
                                    <i class = "bi bi-star-fill"></i>
                                    <i class = "bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        </div>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="addToCartModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add To Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Size</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="size" id="slice" value="slice" required>
                      <label class="form-check-label" for="flexRadioDefault1">Slice</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="size" id="inch6" value="6" required>
                      <label class="form-check-label" for="flexRadioDefault2">6 inch</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="size" id="inch8" value="8" required>
                      <label class="form-check-label" for="flexRadioDefault2">8 inch</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="size" id="inch10" value="10" required>
                      <label class="form-check-label" for="flexRadioDefault2">10 inch</label>
                    </div>
                    <h6>Eggless</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="eggless" id="eggless" value="true" required>
                      <label class="form-check-label" for="flexRadioDefault1">Yes</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="eggless" id="eggless" value="false" required>
                      <label class="form-check-label" for="flexRadioDefault1">No</label>
                    </div>
                
                    <input type="hidden" class="form-control" id="productNo" name="productNo">
                    <input type="hidden" class="form-control" id="price" name="price">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn nav-btn-color" name="addToCart">Yes</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="main-footer position">
        <div class="footer-middle mt-0" style="background: #F2F2F2">
            <div class="container">
                <div class="row footer">
                    <h4 class="title1 fontsize1 footer-title-text">A fun mix of fantastical flavours, right at your doorstep!</h4>
                    <h5 class="content1 marginbottom" style="color: #5E5E5E">Cakes are meant to bring joy and elevate the mood of any occasion. That is why we at Eat Cake Today strives to be the best cake delivery service in Malaysia. Hundreds of mouth-watering, crave-inducing, luscious cakes are available for purchase and are categorized under a number of collections, namely brownies, bundts, cheesecakes, cupcakes, customized cakes, designer cakes, dessert table, eggless cakes, healthy cakes, halal cakes, jelly cakes, loafs, less sweet cakes, macarons, Mille crepes, pastries, vegan dairy-free cakes, and sugar flowers.</h5>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3 col-sm-6 footer">
                        <h4 class="title1 fontsize2 footer-title-text">Little Cake Story Links</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Best Selling Cakes</a></li>
                            <li><a href="">Cake News</a></li>
                            <li><a href="">Career</a></li>
                            <li><a href="">Contact Us</a></li>
                            <li><a href="">About Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-5 col-sm-7 footer">
                        <h4 class="title1 fontsize2 footer-title-text">Buy Cakes Online For Birthday / Get Together</h4>
                        <ul class="list-unstyled content1 mb-0">
                            <li class="footer-content-text">Little Cake Story is the No.1 Cake Delivery Shop in Kuala Lumpur (KL), Petaling Jaya (PJ), Klang Valley and Selangor, Malaysia. We deliver fresh birthday cakes to your door in 4 hours!</li>
                            <br />
                            <li class="footer-content-text">Together, our 500+ premium cakes (including designer and customized) from local bakers near me and you including special recipe cakes cater for your next corporate/office bulk order, wedding and kids events.</li>
                            <br />
                            <li class="footer-content-text">Buy a cake online for yourself or send a cake to your friends and family today!</li>
                            <br />
                            <li class="footer-content-text"></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-6 footer">
                        <h4 class="title1 fontsize2 footer-title-text">Little Cake Story Newsletter</h4>
                        <form>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label footer-title-text">Email address</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p class="text-xs-center footer-title-text">
                        &copy; <script>document.write(new Date().getFullYear())</script> Little Cake Story - Cake Delevery from Malaysia's Best Baker
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ------------------------------ JQuery ------------------------------ -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" 
    crossorigin="anonymous"></script>

    <!-- ------------------------------ Owl Caruosel ------------------------------ -->
    <script src="../css/owl_carousel/owl.carousel.js"></script>
    <script src="../css/owl_carousel/script.js"></script>
    
    <script>
        function logout() {
            var r = confirm("Logout?");
            if (r == true) {W
                alert('Log out success');
                //Wwindow.location.replace('../php/login.php?status=logout');
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script>
    
    function addToCartValue(productNo, price, slice, inch6, inch8, inch10){
        
        document.getElementById('productNo').value=productNo;
        document.getElementById('price').value=price;
        
        console.log(slice);
        
        if(slice=="false"){
            document.getElementById('slice').disabled=true;
        }
        if(inch6=="false"){
            document.getElementById('inch6').disabled=true;
        }
        if(inch8=="false"){
            document.getElementById('inch8').disabled=true;
        }
        if(inch10=="false"){
            document.getElementById('inch10').disabled=true;
        }
        
    }
    </script>
</body>
</html>