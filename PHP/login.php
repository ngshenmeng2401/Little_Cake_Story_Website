<?php
session_start();
include("dbconnect.php");

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $sqllogin = "SELECT * FROM tbl_user WHERE user_email = '$email' AND password = '$password'";

    $select_stmt = $con->prepare($sqllogin);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    if ($select_stmt->rowCount() > 0) {
        $_SESSION["session_id"] = session_id();
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $row['user_name'];
        // $_SESSION["phone"] = $row['phone_no'];
        $_SESSION["datereg"] = $row['date_reg'];
        $_SESSION["pass"] = $row['password'];
        echo "<script> alert('Login successful')</script>";
        echo "<script> window.location.replace('home.php')</script>";
    } else {
        session_unset();
        session_destroy();
        echo "<script> alert('Login fail')</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
}

if (isset($_GET["status"])) {
    if (($_GET["status"] == "logout")) {
        session_unset();
        session_destroy();
        echo "<script> alert('Session Cleared')</script>";
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
    <link rel="stylesheet" href="../css/login_style.css">
    <link rel="stylesheet" href="../css/header_style.css">
    <link rel="stylesheet" href="../css/footer_style.css">
    
    <title>Little Cake Story</title>
    <script src="../javascript/script.js"></script>
</head>
<body onload="loadCookies()">
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
                    <a class="nav-link" aria-current="page" href="./home.php">Home</a>
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
            <form class="d-flex">
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" required>
                <button class="btn me-5 nav-btn-color" type="submit">Search</button>
            </form>
            <ul class="navbar-nav" >
                <li class="nav-item me-3">
                    <a class="nav-link active" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">SignUp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ></a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- body -->
    <!-- <div class="container-md mb-2" style="background: gray;">100% wide until large breakpoint</div> -->
    <div class="container mt-5 login-con">
        <div class="row gx-5 gy-2">
            <div class="col-md-6">
                <img src="../assets/loginimg.jpg" class="loginimg img-fluid" alt="image" />
            </div>
            <div class="col-md-6 padding">
                <h3>Login</h3>
                <form method="post" name="loginForm" onsubmit="return validateLoginForm()">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <p class="text-muted">
                            We'll never share your email with anyone else.
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="rememberme" name="rememberme">
                        <label class="form-check-label" for="flexCheckChecked">
                        Remember Me
                        </label>
                    </div>
                    <div class="gap-2 d-md-block">
                        <button type="submit" class="btn login-btn-color" name="login" value="login">Login</button>
                        <button class="forgetbtn btn btn-outline-warning">Forgot Your Password ?</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="container-xl mb-2" style="background: red;">100% wide until large breakpoint</div> -->
    <!-- <div class="container-xxl mb-2" style="background: orange;">100% wide until large breakpoint</div> -->

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
    function validateLoginForm() {
        var email = document.forms["loginForm"]["email"].value;
        var password = document.forms["loginForm"]["password"].value;
        if ((email === "") || (password === "")) {
            alert("Please fill out your email/password");
            return false;
        }
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(String(email))) {
            alert("Please correct your email");
            return false;
        }
        setCookies(10);
    }

    function setCookies(exdays) {
        var email = document.forms["loginForm"]["email"].value;
        var password = document.forms["loginForm"]["password"].value;
        var rememberme = document.forms["loginForm"]["rememberme"].checked;
        console.log(email, password, rememberme);
        if (rememberme) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "cusername=" + email + ";" + expires + ";path=/";
            document.cookie = "cpass=" + password + ";" + expires + ";path=/";
            document.cookie = "rememberme=" + rememberme + ";" + expires + ";path=/";
    
        } else {
            document.cookie = "cusername=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
            document.cookie = "cpass=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
            document.cookie = "rememberme=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
        }
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function loadCookies() {
        var username = getCookie("cusername");
        var password = getCookie("cpass");
        var rememberme = getCookie("rememberme");
        console.log("COOKIES:" + username, password, rememberme);
        document.forms["loginForm"]["email"].value = username;
        document.forms["loginForm"]["password"].value = password;
        if (rememberme) {
            document.forms["loginForm"]["rememberme"].checked = true;
        } else {
            document.forms["loginForm"]["rememberme"].checked = false;
        }
    }
    </script>
</body>
</html>