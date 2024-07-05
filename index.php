<?php
session_start();

// Include database connection
require_once 'connection.php';

// Fetch products from the database
$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/Roses.png" type="image/x-icon" />

  <title>Rose shop</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.php">
          <span> Rose shop </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php"> Shop </a>
            </li>
            <?php
              // Check if user is logged in and has Admin role
              if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
              ?>
                <li class="nav-item">
                  <a class="nav-link" href="Dashboard/Index.php">Dashboard</a>
                </li>
              <?php } ?>
            </ul>
          <div class="user_option">
            <?php if (!isset($_SESSION['email'])) { ?>
              <a href="Login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Login</span>
              </a>
            <?php } else { ?>
              <a href="logout.php">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span>Logout</span>
              </a>
            <?php } ?>
            <a href="">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </a>
            <form class="form-inline">
              <button class="btn nav_search-btn" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <!-- slider section -->

    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Welcome To Our <br />
                        Rose Shop
                      </h1>
                      <p>
                      Welcome to our Rose Store: Where Every Petal Tells a Story. Find passion and elegance in every bloom. Start your journey with us today.
                      </p>
                      <a href=""> Contact Us </a>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="img-box">
                      <img src="images/f1.png" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Welcome To Our <br />
                        Rose Shop
                      </h1>
                      <p>
                      Welcome to our Rose Store: Where Every Petal Tells a Story. Find passion and elegance in every bloom. Start your journey with us today.
                      </p>
                      <a href=""> Contact Us </a>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="img-box">
                      <img src="images/f2.png" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Welcome To Our <br />
                        Rose Shop
                      </h1>
                      <p>
                      Welcome to our Rose Store: Where Every Petal Tells a Story. Find passion and elegance in every bloom. Start your journey with us today.
                      </p>
                      <a href=""> Contact Us </a>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="img-box">
                      <img src="images/f3.png" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel_btn-box">
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
              <span class="sr-only">Previous</span>
            </a>
            <img src="images/line.png" alt="" />
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Our Roses</h2>
      </div>
      <div class="row">
        <?php foreach ($products as $product) : ?>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="box">
              <a href="">
                <div class="img-box">
                  <img src="Dashboard/uploads/<?php echo $product['Image']; ?>" alt="<?php echo $product['Name']; ?>" />
                </div>
                <div class="detail-box">
                  <h6><?php echo $product['Name']; ?></h6>
                  <h6>
                    Price
                    <span>$<?php echo $product['Price']; ?></span>
                  </h6>
                </div>
                <?php if ($product['IsNew'] == 1) : ?>
                  <div class="new">
                    <span>New</span>
                  </div>
                <?php endif; ?>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="btn-box">
        <a href="#">View All Roses</a>
      </div>
    </div>
  </section>

  <!-- end shop section -->

  <!-- info section -->

  <section class="info_section layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        <a href="">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
        <a href="">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
      </div>
    </div>
    <div class="info_container">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>ABOUT US</h6>
            <p>
              Rose Shop Rose Shop Rose Shop Rose Shop Rose Shop Rose
              ShopRose Shop Rose Shop Rose Shop Rose Shop.
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form">
              <h5>Newsletter</h5>
              <form action="#">
                <input type="email" placeholder="Enter your email" />
                <button>Subscribe</button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>NEED HELP</h6>
            <p>
            Welcome to our Rose Store: Where Every Petal Tells a Story. Find passion and elegance in every bloom. Start your journey with us today.
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>CONTACT US</h6>
            <div class="info_link-box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> KSA </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>+965 xxx xxx xxxx</span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> RoseS@gmail.com</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="index.php/">Rose Shop</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->
  </section>

  <!-- end info section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>