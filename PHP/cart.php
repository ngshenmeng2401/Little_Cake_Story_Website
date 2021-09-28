<?php
session_start();
include("dbconnect.php");
$email = $_SESSION["email"];

if (isset($_SESSION["session_id"])){
    
    $sqlloadcart = "SELECT tbl_product.product_no, tbl_product.product_name, tbl_product.rating, tbl_cart.product_size, tbl_cart.eggless, tbl_cart.product_qty, tbl_cart.product_price FROM tbl_product INNER JOIN tbl_cart ON tbl_cart.product_no = tbl_product.product_no WHERE tbl_cart.user_email = '$email'";

    $stmt = $con->prepare($sqlloadcart);
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    
    if(isset($_POST['delete'])){
    
        $productNo = $_POST['product_no'];
        $product_price = $_POST['product_price'];
        
        try {
            $sqldelete = "DELETE FROM tbl_cart WHERE user_email = '$email' AND product_no = '$productNo' AND product_price = '$product_price'";
            
            $stmt = $con->prepare($sqldelete);
        
            // execute the query
            $stmt->execute();
            
            echo "<script>alert('Success')</script>";
            echo "<script> window.location.replace('cart.php')</script>";
            
        }catch(PDOException $e) {
            
            echo "<script>alert('$e')</script>";
            echo "<script> window.location.replace('cart.php')</script>";
        }
    }
    
    if(isset($_POST['checkout'])){
        
        $productNo = $_POST['product_no'];
        $product_price = $_POST['product_price'];
        $qty = $_POST['product_qty'];
        $count = count($productNo);
        
        try {
            
            for($i=0;$i<$count;$i++){
            
                $sqlupdatecart = "UPDATE tbl_cart SET product_qty = '$qty[$i]' WHERE user_email = '$email' AND product_no = '$productNo[$i]' AND product_price = '$product_price[$i]'";
                
                $stmt = $con->prepare($sqlupdatecart);
        
                // execute the query
                $stmt->execute();
                
                echo "<script>console.log('Success')</script>";
                // echo "<script> window.location.replace('cart.php')</script>";
                
            }
        }catch(PDOException $e) {
            
            echo "<script>console.log('$e')</script>";
            echo "<script> window.location.replace('cart.php')</script>";
        }
        
        $date = date('Y-m-d', strtotime($_POST['date'])); 
        $time = $_POST['time'];
        $dateTime = $date . ' ' . $time;
        
        $phoneNo = "012-5612345"; 
        $name = $_SESSION["name"]; 
        $totalPayment = $_POST['total_payment']; 
        $message = "No Message"; 
        $address = "-"; 
        $total_qty = $_POST['total_qty']; 
        $option = $_POST['option'];
        
        $api_key = '4418812d-7f79-4707-afdb-8b9e213b9f1f';
        $collection_id = 'dvdnzrty';
        $host = 'https://billplz-staging.herokuapp.com/api/v3/bills';
        
        $data = array(
            'collection_id' => $collection_id,
            'email' => $email,
            'mobile' => $phoneNo,
            'name' => $name,
            'amount' => $totalPayment * 100, // RM20
            'description' => 'Payment for order' ,
            'callback_url' => "https://javathree99.com/s271059/littlecakestory_website/php/return_url",
            'redirect_url' => "https://javathree99.com/s271059/littlecakestory_website/php/update_payment.php?email=$email&phoneNo=$phoneNo&name=$name&totalPayment=$totalPayment&dateTime=$dateTime&message=$message&address=$address&item_qty=$total_qty&option=$option" 
        );
        
        
        $process = curl_init($host );
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data) ); 
        
        $return = curl_exec($process);
        curl_close($process);
        
        $bill = json_decode($return, true);
        
        echo "<pre>".print_r($bill, true)."</pre>";
        header("Location: {$bill['url']}");
    }
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
    <link rel="stylesheet" href="../css/cart_style.css">
    
    <!-- Header & Footer CSS -->
    <link rel="stylesheet" href="../css/header_style.css">
    <link rel="stylesheet" href="../css/footer_style.css">

    <title>Little Cake Story</title>
</head>
<body>
    
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light nav-bg-color">
        <div class="container-fluid">
            <img src="../assets/logo2.png" alt="logo" class="logoimg" >
            <a class="navbar-brand" href="home.php">LITTLE CAKE STORY</a>
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
                    <a class="nav-link" aria-current="page" href="home.php">Home</a>
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
                    <a class="nav-link active" href="./cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about_us.php">About Us</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" required>
                <button class="btn me-5 nav-btn-color" type="submit">Search</button>
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
    
    <section class="cart-list-section">
        <div class="container cart-con">
            <!--<div class="row my-5">-->
            <!--    <div class="col-lg-1 col-md-12 col-12"></div>-->
            <!--    <div class="col-lg-5 col-md-6 col-6 ">-->
            <!--        <h2>-->
            <!--            Total (RM):-->
            <!--        </h2>-->
            <!--    </div>-->
            <!--    <div class="col-lg-5 col-md-6 col-6 text-end">-->
            <!--        <h2>-->
            <!--            999.00-->
            <!--        </h2>-->
            <!--    </div>-->
            <!--    <div class="col-lg-1 col-md-12 col-12"></div>-->
            <!--</div>-->
            <div class="row my-2">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    Please double check all details
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row vertical-center">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table">
                        <thead>
                          <tr class="th-bg-color">
                            <th scope="col">Product</th>
                            <th scope="col"></th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Price (RM)</th>
                            <th scope="col" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($rows)){
                            foreach ($rows as $cart) {
                                extract($cart);
                                $totalprice = $product_price* $product_qty;
                                ?>
                                <tr class="align-middle">
                                    <td class="col-2">
                                        <div class="col ">
                                            <img src="../../littlecakestory/images/product/<?php echo $product_no ?>.png" class="img-fluid rounded " alt="img">
                                        </div>
                                    </td>
                                    <td class="col-4">
                                        <div >
                                            <span><?php echo $product_name ?></span>
                                        </div>
                                        <?php 
                                        if($product_size=="false"){
                                            ?>
                                            <div >
                                                <span></span>
                                            </div>
                                        <?php 
                                        }else if($product_size=="slice"){
                                            ?>
                                            <div >
                                                <span><?php echo $product_size ?></span>
                                            </div>
                                            <?
                                        }else{
                                            ?>
                                            <div >
                                                <span><?php echo $product_size ?> inch</span>
                                            </div>
                                        <?php 
                                        }
                                        if($eggless=="true"){
                                            ?>
                                            <div >
                                                <span>Eggless</span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div>
                                            <span>RM <?php echo $product_price ?></span>
                                            <input type="hidden" class="form-control" id="product_price" value="<?php echo $product_price ?>">
                                        </div>
                                        <div class = "rating d-flex mt-1">
                                            <span class="me-2"><?php echo $rating ?></span>
                                            <i class = "bi bi-star-fill"></i>
                                            <i class = "bi bi-star-fill"></i>
                                            <i class = "bi bi-star-fill"></i>
                                            <i class = "bi bi-star-fill"></i>
                                            <i class = "bi bi-star-fill"></i>
                                        </div>
                                    </td>
                                    <td class="col-2">
                                        <div class="row">
                                            <div class="col-4 text-center btns py-0 px-0">
                                                <button onclick="calcTotalPrice('minus','<?php echo $product_price ?>','<?php echo $product_no ?>');calcSubTotal('<?php echo $product_no ?>')">
                                                    <i class = "bi bi-dash-circle"></i>
                                                </button>
                                            </div>
                                            <div class="col-4 text-center py-0 px-0">
                                                <p class="my-0 mx-0 text-center" id="<?php echo $product_no ?>"><?php echo $product_qty ?></p>
                                            </div>
                                            <div class="col-4 text-center btns py-0 px-0">
                                                <button onclick="calcTotalPrice('plus','<?php echo $product_price ?>','<?php echo $product_no ?>');calcSubTotal('<?php echo $product_no ?>')">
                                                    <i class = "bi bi-plus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-2 text-center">
                                        <div>
                                            <span class="totalprice" id="totalprice<?php echo $product_no ?>"><?php echo number_format($totalprice, 2) ?></span>
                                        </div>
                                    </td>
                                    <td class="col-2 text-center">
                                        <div class="btns w-10 h-20">
                                            <form method="post">
                                                <input type="hidden" class="form-control" name="product_no" id="product_no" value="<?php echo $product_no ?>">
                                                <input type="hidden" class="form-control" name="product_price" id="product_price" value="<?php echo $product_price ?>">
                                                <button type="submit" name="delete" class = "col-7 py-1">
                                                    <i class = "bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $subtotal = $totalprice + $subtotal;
                            }
                        }else{
                        ?>
                            <tr class="align-middle">
                                <td class="col-2 text-center">
                                <div>
                                    <span class="totalprice" >No Data</span>
                                </div>
                                </td>
                                <td class="col-4 text-center">
                                    <div>
                                        <span class="totalprice" >No Data</span>
                                    </div>
                                </td>
                                <td class="col-2 text-center">
                                    <div>
                                        <span class="totalprice" >No Data</span>
                                    </div>
                                </td>
                                <td class="col-2 text-center">
                                    <div>
                                        <span class="totalprice" >No Data</span>
                                    </div>
                                </td>
                                <td class="col-2 text-center">
                                    <div>
                                        <span class="totalprice" >No Data</span>
                                    </div>
                                </td>
                            </tr>
                        <?
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-12 col-12 "></div>
                <div class="col-lg-3 col-md-12 col-12 "></div>
                <div class="col-lg-3 col-md-4 col-12 "></div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="row mb-2">
                        <span>Date:</span>
                    </div>
                    <div class="row my-1">
                        <span>Time (9:00am - 6:00pm):</span>
                    </div>
                    <div class="row mt-1">
                        <span>Subtotal (RM):</span>
                    </div>
                    <div class="row">
                        <span>Options:</span>
                    </div>
                    <br>
                    <div class="row">
                        <span>----------------</span>
                    </div>
                    <div class="row">
                        <span>Total (RM):</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <form method="post">
                    <div class="row">
                        
                        <input class="date-style rounded " type="date" id="date" name="date" required>
                    </div>
                    <div class="row">
                        <input class="time-style rounded mt-1" type="time" id="time" name="time" min="09:00" max="18:00" required>
                    </div>
                    <div class="row mt-1">
                        <span class="text-end" id="subtotal"><?php echo number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="row">
                        <div class="form-check my-0 text-end align-right">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <input class="form-check-input float-end" type="radio" name="option" id="pickup" value="Pickup" onclick="calcTotalPayment('pickup')" required>
                                </div>
                                <div class="col-md-6 col-6">
                                    <label class="form-check-label" for="flexRadioDefault1">PickUp</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check my-0 text-end">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <input class="form-check-input float-end " type="radio" name="option" id="delivery" value="Delivery" onclick="calcTotalPayment('delivery')" required>
                                </div>
                                <div class="col-md-6 col-6">
                                    <label class="form-check-label" for="flexRadioDefault1">Delivery</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <span class="text-end">----------------</span>
                    </div>
                    <div class="row mb-4">
                        <span class="text-end" id="totalPayment">0.00</span>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-5"></div>
                        <div class="col-md-8 col-7 ">
                        <?php
                        foreach ($rows as $cart) {
                            extract($cart);
                            $totalqty = $totalqty + $product_qty;
                            ?>
                            <input type="hidden" class="form-control" name="product_no[]" id="product_no" value="<?php echo $product_no ?>">
                            <input type="hidden" class="form-control" name="product_price[]" id="product_price" value="<?php echo $product_price ?>">
                            <input type="hidden" class="form-control" name="product_qty[]" id="qty<?php echo $product_no ?>" value="<?php echo $product_qty ?>">
                            
                        <?php
                        }
                        ?>
                            <input type="hidden" class="form-control" name="total_qty" id="product_no" value="<?php echo $totalqty ?>">
                            <input type="hidden" class="form-control" name="total_payment" id="total_payment">
                            <button type="submit" class="btn checkout-btn w-100" name="checkout">Checkout</button>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-12 col-12"></div>
            </div>
        </div>
    </section>

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

    <script>

        function calcTotalPrice(op, price, productNo){
            
            var qty =  document.getElementById(""+productNo).innerHTML;
            
            if(op == 'plus'){
                
                qty++;
            }
            if(op == 'minus'){
                qty--;
                if(qty==0){
                    qty=1;
                }
            }
            var totalPrice = price*qty;
            // console.log(qty);
            // console.log(totalPrice);
            
            document.getElementById(""+productNo).innerHTML = qty;
            document.getElementById("qty"+productNo).value = qty;
            document.getElementById("totalprice"+productNo).innerHTML = totalPrice.toFixed(2);
        }
        
        function calcSubTotal(productNo){
            
            var totalPrice = document.getElementsByClassName("totalprice");
            var subtotal = 0;

            for(var i = 0 ; i < totalPrice.length; i++){
                subtotal = subtotal + parseFloat(totalPrice[i].innerHTML);
                // console.log(parseFloat(totalPrice[i].innerHTML));
            }
            // console.log(subtotal);
            document.getElementById("subtotal").innerHTML = subtotal.toFixed(2);
        }
        
        function calcTotalPayment(op){
            
            var subtotal = document.getElementById("subtotal");
            var totalPayment = 0.00;
            
            if(op == "pickup"){
                
                totalPayment = parseFloat(subtotal.innerHTML);
            }
            if(op == "delivery"){
                
                totalPayment = parseFloat(subtotal.innerHTML) + 10;
            }
            console.log(totalPayment);
            document.getElementById("totalPayment").innerHTML = totalPayment.toFixed(2);
            document.getElementById("total_payment").value = totalPayment.toFixed(2);
        }
        
    </script>
</body>
</html>