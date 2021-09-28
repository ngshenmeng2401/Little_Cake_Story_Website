<?php
session_start();
include("dbconnect.php");

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];
$status = "active";
$otp = "0";
// $otp = rand(1000, 9999);
$credit = "0";

if (isset($_POST['signup'])) {
    if($password != $confirmPassword){
            //this is javascript - message box and bring u to another page
            echo "<script type='text/javascript'>alert('Password Not match!');window.location.assign('register_user.php');</script>'";
    }else{
        $sqlregister = "INSERT INTO `tbl_user`(`user_name`, `user_email`, `password`, `otp`, `credit`, `status`) VALUES ('$name','$email','$password','$otp','$credit','$status')";
        try {
            $con->exec($sqlregister);
            echo "<script>alert('Registration successful')</script>";
            echo "<script>window.location.replace('../php/login.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Registration failed')</script>";
            echo "<script>window.location.replace('../php/register_user.php')</script>";
        }
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
    <link rel="stylesheet" href="../css/register_style.css">

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
            <a class="navbar-brand" href="./home.html">LITTLE CAKE STORY</a>
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
                    <a class="nav-link" aria-current="page" href="./home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Bento Cake</a></li>
                    <li><a class="dropdown-item" href="#">Cake</a></li>
                    <li><a class="dropdown-item" href="#">Cup Cake</a></li>
                    <li><a class="dropdown-item" href="#">Tart</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about_us.php">About Us</a>
                </li>
            </ul>
            <form class="d-flex" >
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" required>
                <button class="btn me-5 nav-btn-color" type="submit">Search</button>
            </form>
            <ul class="navbar-nav" >
                <li class="nav-item me-3">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./signup.php">SignUp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ></a>
                </li>
            </ul>
        </div>
        </div>

    </nav>

    <!-- body -->
    <div class="container mt-5">
        <div class="row gx-5 gy-2">
            <div class="col-md-6">
                <h3>Create Account</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" id="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <div>
                        <p id="length" class="invalid">Min 8 characters</p>
                    </div>
                    <button type="submit" class="btn dropdown-btn-color" id="signup" name="signup" value="signup" disabled>Sign Up</button>
                  </form>
                </div>
            <div class="col-md-6">
                <img src="../assets/signup.jpg" alt="img" class="signupimg img-fluid" />
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="main-footer position">
        <div class="footer-middle" style="background: #F2F2F2">
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
    
    <script>
        var password = document.getElementById("password");
        var length = document.getElementById("length");
        var signupbtn = document.getElementById("signup");

        // When the user clicks on the password field, show the message box
        password.onfocus = function() {
        document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        password.onblur = function() {
        document.getElementById("message").style.display = "none";
        }

        password.onkeyup = function(){
            if(password.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
                signupbtn.disabled = false;

            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
                signupbtn.disabled = true;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" 
    crossorigin="anonymous"></script>
</body>
</html>