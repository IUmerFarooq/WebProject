<?php
session_start();
include("php scripts/includes/dbh_inc.php");
$con=get_con();
$signedin=false;

if($_SERVER["REQUEST_METHOD"]=="POST")
{   
    if (isset($_POST["signup"])) {
        // code...
    
    $name = mysqli_real_escape_string($con, $_POST['name']);
        $DOB = mysqli_real_escape_string($con, $_POST['dob']);
        $ph = mysqli_real_escape_string($con, $_POST['phone']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $pass = mysqli_real_escape_string($con, $_POST['password']);
        $hash = md5($pass);

        $cmd = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $res = mysqli_query($con, $cmd);
        $user = mysqli_fetch_assoc($res);

        if($user) {
            if($user['email'] === $email) {
                return 5; //return error
            }
        } else {
            $data = "INSERT INTO `teasspices`.`user` (`name`, `dob`, `phone`, `email`, `password`) VALUES ('$name', '$DOB', '$ph', '$email', '$hash')";
    
            if($con -> query($data) == true) {
                $signedin=true;
                $_SESSION['type']="signup";
                header("refresh:0:url=index.php");
            }   
            else    return 2;
        }

    }
    elseif (isset($_POST["login"])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $hash = md5($pass);

        $cmd = "select * from `user` where email = '$email' and password = '$hash'";
        $result = mysqli_query($con, $cmd);
        //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count =  mysqli_num_rows($result);

        if($count == 1) {
            session_start();
            $_SESSION['email'] = $email;
            $signedin=true;
            $_SESSION['type']="login";
            header("refresh:0:url=index.php");
        } else {
            return 2;
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
    <title>Teas & Spices</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
        <?php
        if ($signedin) {
            ?>
        #signedinpopup{
            display: flex;
            align-items: center;
        }
        <?php

        }
        else{
            ?>
            #signedinpopup{
            display: none;
        }
        <?php

        }
        ?>

    </style>

</head>
<body>
    
<!-- header section starts  -->

<header class="header">

    <a href="#" class="logo"> <i class="fas fa-shopping-basket"></i> Teas & Spices</a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#features">features</a>
        <a href="#products">products</a>
        <a href="#categories">categories</a>
        <a href="#review">review</a>
        <a href="#blogs">blogs</a>
    </nav>

    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <div class="fas fa-user" id="login-btn"></div>
        <div class="fas fa-user-plus" id="signUp-btn"></div>
    </div>

    <form action="" class="search-form">
        <input type="search" id="search-box" placeholder="search here...">
        <label for="search-box" class="fas fa-search"></label>
    </form>

    <div class="shopping-cart">
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="image/cart-img-1.jpg" alt="">
            <div class="content">
                <h3>Red Chilli Powder</h3>
                <span class="price">$4.99/kg-</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="image/cart-img-2.jpg" alt="">
            <div class="content">
                <h3>Black Pepper Powder</h3>
                <span class="price">$4.99/kg-</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="image/cart-img-3.jpg" alt="">
            <div class="content">
                <h3>Dark Black Cocoa Beans</h3>
                <span class="price">$4.99/kg-</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="total"> total : $19.69/- </div>
        <a href="#" class="btn">checkout</a>
    </div>

    <form method="post" action="" class="login-form">
        <h3>login now</h3>
        <input type="email" name="email" placeholder="your email" class="box" required>
        <input type="password" name="password" placeholder="your password" class="box" required>
        <p>forget your password <a href="#">click here</a></p>
        <p>don't have an account <a href="#signup-form" onclick="opensignup()">create now</a></p>
        <input type="submit" name="login" value="login now" class="btn">
    </form>

<div id="signup-form-container">
    <form action="" method="post" class="signup-form" id="signup-form">
        <button type="button" class="close-pop-up" onclick="closepopup(this)">X</button>
            <!--a href="javascript:void(0)" id="reg-del" onclick="disNone('reg')">X</a !--> 
            <h3>SignUp</h3>
            <input type="text" name="name" placeholder="Enter Your name"  spellcheck="false" class="box"required/>
            <input type="date" name="dob" placeholder="Enter your Date Of Birth"  class="box" required/>
            <input type="tel" name="phone" placeholder="Enter Phone Number"  class="box" spellcheck="false" required/>
            <input type="email" name="email" placeholder="Enter Email"  class="box" spellcheck="false" required/>
            <input type="password"  name="password" placeholder="Enter Password"  class="box"  required/>
            <input type="password" placeholder="Confirm Password"  class="box" />

            <!-- <button type="submit" id="reg-sub-btn" onclick="message()" onclick="log_suc()" onload="display()"disabled>SignUp</button> -->
            <input type="submit" name="signup" value="sign up" class="btn" >
    </form>
</div>    

<div id="signedinpopup">
    <h3> <?php
    if($_SESSION['type']=="signup")
        {echo "SIGNED UP SUCCESSFULLY!";}
        else{
            echo "LOGGED IN SUCCESSFULLY!";
        } 
    ?></h3>

</div>



</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3><span>fresh</span> and <span>organic</span> products for you</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam libero nostrum veniam facere tempore nisi.</p>
        <a href="#" class="btn">shop now</a>
    </div>

</section>

<!-- home section ends -->

<!-- features section starts  -->

<section class="features" id="features">

    <h1 class="heading"> our <span>features</span> </h1>

    <div class="box-container">

        <div class="box">
            <img src="image/feature-img-1.png" alt="">
            <h3>fresh and organic</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
            <a href="#" class="btn">read more</a>
        </div>

        <div class="box">
            <img src="image/feature-img-2.png" alt="">
            <h3>free delivery</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
            <a href="#" class="btn">read more</a>
        </div>

        <div class="box">
            <img src="image/feature-img-3.png" alt="">
            <h3>easy payments</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, earum!</p>
            <a href="#" class="btn">read more</a>
        </div>

    </div>

</section>

<!-- features section ends -->

<!-- products section starts  -->

<section class="products" id="products">

    <h1 class="heading"> our <span>products</span> </h1>

    <div class="swiper product-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="image/product1.jpg" alt="">
                <h3>turkish red tea leaves</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product2.jpg" alt="">
                <h3>turkish green tea</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product3.jpg" alt="">
                <h3>red chilli powder</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product4.jpg" alt="">
                <h3>Black pepper</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

        </div>

    </div>

    <div class="swiper product-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="image/product5.jpg" alt="">
                <h3>tumeric powder</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product6.jpg" alt="">
                <h3>coriander powder</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product7.jpg" alt="">
                <h3>cumin powder</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

            <div class="swiper-slide box">
                <img src="image/product8.jpg" alt="">
                <h3>red chilli flakes</h3>
                <div class="price"> $4.99/kg- - 10.99/kg- </div>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <a href="#" class="btn">add to cart</a>
            </div>

        </div>

    </div>


</section>

<!-- products section ends -->

<!-- categories section starts  -->

<section class="categories" id="categories">

    <h1 class="heading"> product <span>categories</span> </h1>

    <div class="box-container">

        <div class="box">
            <img src="image/cat-1.jpg" alt="">
            <h3>coffee</h3>
            <p>upto 45% off</p>
            <a href="#" class="btn">shop now</a>
        </div>

        <div class="box">
            <img src="image/cat-2.jpg" alt="">
            <h3>spices</h3>
            <p>upto 45% off</p>
            <a href="#" class="btn">shop now</a>
        </div>

        <div class="box">
            <img src="image/cat-3.jpg" alt="">
            <h3>teas</h3>
            <p>upto 45% off</p>
            <a href="#" class="btn">shop now</a>
        </div>

        <div class="box">
            <img src="image/cat-4.jpg" alt="">
            <h3>herbs</h3>
            <p>upto 45% off</p>
            <a href="#" class="btn">shop now</a>
        </div>

    </div>

</section>

<!-- categories section ends -->

<!-- review section starts  -->

<section class="review" id="review">

    <h1 class="heading"> customer's <span>review</span> </h1>

    <div class="swiper review-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="image/pic-1.png" alt="">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                <h3>john deo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-2.png" alt="">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                <h3>john deo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-3.png" alt="">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                <h3>john deo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="image/pic-4.png" alt="">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde sunt fugiat dolore ipsum id est maxime ad tempore quasi tenetur.</p>
                <h3>john deo</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- review section ends -->

<!-- blogs section starts  -->

<section class="blogs" id="blogs">

    <h1 class="heading"> our <span>blogs</span> </h1>

    <div class="box-container">

        <div class="box">
            <img src="image/blog-1.jpg" alt="">
            <div class="content">
                <div class="icons">
                    <a href="#"> <i class="fas fa-user"></i> by user </a>
                    <a href="#"> <i class="fas fa-calendar"></i> 1st may, 2021 </a>
                </div>
                <h3>fresh and organic teas,spices & herbs</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, expedita.</p>
                <a href="#" class="btn">read more</a>
            </div>
        </div>

        <div class="box">
            <img src="image/blog-2.jpg" alt="">
            <div class="content">
                <div class="icons">
                    <a href="#"> <i class="fas fa-user"></i> by user </a>
                    <a href="#"> <i class="fas fa-calendar"></i> 1st may, 2021 </a>
                </div>
                <h3>fresh and organic teas,spices & herbs</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, expedita.</p>
                <a href="#" class="btn">read more</a>
            </div>
        </div>

        <div class="box">
            <img src="image/blog-3.jpg" alt="">
            <div class="content">
                <div class="icons">
                    <a href="#"> <i class="fas fa-user"></i> by user </a>
                    <a href="#"> <i class="fas fa-calendar"></i> 1st may, 2021 </a>
                </div>
                <h3>fresh and organic teas,spices & herbs</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, expedita.</p>
                <a href="#" class="btn">read more</a>
            </div>
        </div>

    </div>

</section>

<!-- blogs section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3> Teas & Spices <i class="fas fa-shopping-basket"></i> </h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam, saepe.</p>
            <div class="share">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <a href="#" class="links"> <i class="fas fa-phone"></i> +090-078-6010 </a>
            <a href="#" class="links"> <i class="fas fa-phone"></i> +090-078-6010 </a>
            <a href="#" class="links"> <i class="fas fa-envelope"></i> teas&spices@gmail.com </a>
            <a href="#" class="links"> <i class="fas fa-map-marker-alt"></i> rawalpindi, pakistan - 46000 </a>
        </div>

        <div class="box">
            <h3>quick links</h3>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> features </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> products </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> categories </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> review </a>
            <a href="#" class="links"> <i class="fas fa-arrow-right"></i> blogs </a>
        </div>

        <div class="box">
            <h3>newsletter</h3>
            <p>subscribe for latest updates</p>
            <input type="email" placeholder="your email" class="email">
            <input type="submit" value="subscribe" class="btn">
            <img src="image/payment.png" class="payment-img" alt="">
        </div>

    </div>

    <div class="credit"> created by <span> Muhammad Umer Farooq </span> | all rights reserved </div>

</section>

<!-- footer section ends -->















<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>