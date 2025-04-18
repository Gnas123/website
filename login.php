<?php
    // $_SESSION['islogin'] = false;
    // if (!isset($_SESSION)) {
    //     session_start();
    // }
    // var_dump($_SESSION);
    // $user_data = check_login($conn);
    if(getAccess() == false){
        // Redirect to a different page
        // header('Location: index.php?page_type=access_denied');
        // exit;
    
        echo "ban dang login(tesing) sua lai phan nay de nop cho thay";
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // something was posted
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            // check existed username
            // khong ton tai username thi die
            if (!($user_db = getUser($conn, $username))) {
                // tro lai login2
                echo "<script>
                    alert('Username not exists');
                    window.location.href = 'index.php?page_type=login';
                </script>";
                die;
            } 

            if (empty($username) || empty($password)) {
                echo "<script>
                    alert('Missing required fields');
                    window.location.href = 'index.php?page_type=login';
                </script>";
                die;
            }
            
            setLogin($user_db, $password);
            echo "<script>
                    alert('Login successfully');
                    window.location.href = 'index.php?page_type=anime';
                </script>";
            die;
        }
    }



    // login with gg
    require __DIR__ . '/vendor/autoload.php';

    
    // $client = new Google_Client();
    $client = new Google\Client();

    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
    $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
    $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

    $client->addScope("email");
    $client->addScope("profile");

    $url = $client->createAuthUrl();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang nhap</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://images.alphacoders.com/838/thumb-1920-838101.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-dark bg-opacity-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="bg-white bg-opacity-50 shadow-lg rounded-3 p-4">

                    <h2 id="form-title" class="mb-4 text-3xl fw-bold text-center text-white">Login</h2>
                    
                    <!-- gui form -->
                    <form action="index.php" method="POST">
                        <!-- user name & password & email -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-white" for="username">
                                <i class="fas fa-user"></i> User name
                            </label>
                            <input class="form-control shadow-sm" id="username" name="username" type="text" 
                                placeholder="User name" required 
                                value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-white" for="password">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input class="form-control shadow-sm" id="password" name="password" type="password" 
                                placeholder="********" maxlength="8" required 
                                value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>">
                        </div>

                            <!-- remember me & forgot password -->
                            <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label text-white" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a id="forgot-password" class="text-white text-decoration-none hover-text-primary" href="#">Forgot Password?</a>
                            </div> -->

                        <!-- create button -->
                        <div class="mb-4 text-center">
                            <button class="btn btn-primary w-100 rounded-pill fw-bold" 
                                    style="background-color: #ec4899; border-color: #ec4899;" 
                                    onmouseover="this.style.backgroundColor='#db2777'" 
                                    onmouseout="this.style.backgroundColor='#ec4899'" 
                                    type="submit" name="page_type" value="login">
                                Login
                            </button>
                        </div>

                        </form>
                        
                    <div class="mb-3 text-center">
                        <span class="text-white">or</span>
                    </div>

                    <!-- register, fabook and gg -->
                    <div class="d-flex justify-content-center align-content-center gap-2 mb-4">
                        <a id="login-register-button" 
                            class="btn btn-primary rounded-pill fw-bold text-white d-flex align-items-center justify-content-center" 
                            href="index.php?page_type=login2">
                            Register
                        </a>
                        <a class="btn rounded-pill fw-bold text-white d-flex align-items-center justify-content-center" 
                            href="#"
                            style="background-color: #1a4783; border-color: #1a4783;" 
                            type="button" onmouseover="this.style.backgroundColor='#153a6b'" onmouseout="this.style.backgroundColor='#1a4783'">
                            <i class="fab fa-facebook-f m-1"></i> Facebook
                        </a>
                        <a class="btn rounded-pill fw-bold text-white d-flex align-items-center justify-content-center" 
                            href="<?php echo $url; ?>"
                            style="background-color: #db4a39; border-color: #db4a39; color: #ffffff;" 
                            type="button" onmouseover="this.style.backgroundColor='#c13524'" onmouseout="this.style.backgroundColor='#db4a39'">
                            <i class="fab fa-google m-1"></i> Google
                            <!-- <i class="fab fa-google" style="vertical-align: middle;"></i> Google -->
                        </a>
                    </div>







                    <p class="text-center text-white small">
                        © 2025 All rights reserved. Design by Sang | MSSV: 2252711
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function () {
        //     let isRegister = false;

        //     $("#login-register-button").on("click", function () {
        //         isRegister = !isRegister;

        //         // Thay đổi tiêu đề
        //         $("#form-title").text(isRegister ? "Register" : "Login");
        //         // Thay đổi văn bản nút toggle
        //         $(this).text(isRegister ? "Back" : "Register");
        //         // Thay đổi tiêu đề
        //         $("#login-create-button").text(isRegister ? "Create" : "Login");
                
        //         // $("#email-field").toggle(isRegister);
        //         // Hiển thị hoặc ẩn trường email
        //         // Thêm hoặc xóa thuộc tính required
        //         if (isRegister) {
        //             $("#email-field").removeClass("d-none");
        //             $("#email").attr("required", "required");
        //             $("#email").removeAttr("disabled");
                    
        //         } else {
        //             $("#email-field").addClass("d-none");
        //             $("#email").removeAttr("required");
        //             $("#email").attr("disabled", "disabled");
        //         }

        //     });
        // });
    </script>

</body>
</html>