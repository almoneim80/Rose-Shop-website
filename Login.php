<?php
session_start();

// Include database connection
require_once 'connection.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists with the provided email and password
    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists
    if ($user) {
        // Determine user role
        $role = $user['role']; // Assuming the role column exists in the users table
        // Set session and cookie for email
        $_SESSION['email'] = $email;
        // Set session for user role
        $_SESSION['role'] = $role;
        setcookie("email", $email, time() + (86400 * 30), "/"); // Cookie set for 30 days
        header("Location: index.php"); // Redirect to admin dashboard if user is admin
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
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
    <link rel="shortcut icon" href="images/f1.png" type="image/x-icon">
    <title>Rose shop - Login</title>

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
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="index.php">
                    <span>Rose shop</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""></span>
                </button>

                <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
                    <ul class="navbar-nav  ">
                        <li class="nav-item ">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="shop.php">
                                Shop
                            </a>
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
                        <?php if (!isset($_SESSION['name'])) { ?>
                            <a href="Login.php">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span> Login </span>
                            </a>
                        <?php } else { ?>
                            <span>Welcome, <?php echo $_SESSION['name']; ?></span>
                            <a href="logout.php">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                        <a href="">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                        <form class="form-inline ">
                            <button class="btn nav_search-btn" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <!-- end header section -->
    </div>
    <!-- end hero area -->

    <!-- login section -->
    <section class="contact_section layout_padding">
        <div class="container px-0">
            <div class="heading_container ">
                <h2 class="">
                    Log in
                </h2>
            </div>
        </div>
        <div class="container container-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 px-0">
                    <div class="map_container">
                        <div class="map-responsive">
                            <img src="images/f4.png" width="600" height="400" frameborder="0" style="width: 70%; height:100%"></img>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 px-0">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div>
                            <input type="email" name="email" placeholder="Email" required />
                        </div>
                        <div>
                            <input type="password" name="password" placeholder="Password" required />
                        </div>
                        <div class="d-flex">
                            <button type="submit">Log in</button>
                        </div>
                    </form>
                    <?php if (isset($error_message)) { ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                    <?php } ?>
                    <p>Don't have an account? <a href="NewAccount.php">Create one</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- end login section -->

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>