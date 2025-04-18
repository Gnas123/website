<?php
// for login with gg
    session_start();

include("connection.php");
include("functions.php");

require __DIR__ . '/vendor/autoload.php';
    
$client = new Google\Client();
    
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

if(!isset($_GET['code'])) {
    exit("Login failed. Please try again.");
}

// getting user infor
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token['access_token']);
$oauth2 = new Google\Service\Oauth2($client);
$userInfo = $oauth2->userinfo->get();

$username = $userInfo->id; // use id as username
$email = $userInfo->email;
$name = $userInfo->name;
$givenName = $userInfo->givenName;
$familyName = $userInfo->familyName;

$password = $userInfo->id . $_ENV['GOOGLE_KEY'];

// var_dump(
//     $userInfo->id,
//     $userInfo->email,
//     $userInfo->name,
//     $userInfo->givenName,
//     $userInfo->familyName,
// );

    // regist gg accout
    
    if(!($user_db = getUser($conn, $username))){
        $hash_password = md5($password);
        // luon la user, admin can tao rieng
        $query = "INSERT INTO user (username, name, hash_pass, email, admin) VALUES ('$username', '$name', '$hash_password', '$email', 0)";                    
        $conn->query($query);
    }

    // login thanh cong
    // $user_pass = $user_db['pass'];
    // check passwork correctness
    $_SESSION['username'] = $name;
    $_SESSION['usertype'] = $user_db['admin'];  //! type of user   
    $_SESSION['islogin'] = true;                //! login thanh cong
    // Set a cookie for the user's login
    setcookie("username", $user_db['username'], time() + (86400 * 1), "/"); // Expires in 1 days

    // var_dump($_SESSION);
    echo "<script>
        alert('Login successfully');
        window.location.href = 'index.php?page_type=home';
    </script>";
    die;
?>