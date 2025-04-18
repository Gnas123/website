<?php
    
    include("connection.php");
    include("functions.php");

    session_start();
    
    // Check the cookie to keep user logged in
    if (isset($_COOKIE['username'])) {
        $user_db = getUser($conn, $_COOKIE['username']);

        if (!isset($_SESSION['username'])){
            $_SESSION['username'] = $user_db['username'];
        }
        if (!isset($_SESSION['usertype'])){
            $_SESSION['usertype'] = $user_db['admin'];
        }
        if (!isset($_SESSION['islogin'])){
            $_SESSION['islogin'] = true;
        }
        // var_dump($_SESSION);
    }
    
    if (isset($_POST['logout'])){        
        setcookie("username", "", time() - 0, "/"); // Deletes the cookie
        
        $_SESSION['islogin'] = false;
        $_SESSION['username'] = null;
        $_SESSION['usertype'] = null;

        session_destroy(); // Destroy the session
    }

    // $user_data = check_login($user_con);



    $starter = 0;
    $skip = 5;          // number of item per page 
    
    // // echo $total_pages . " pages found.<br>";
    // $records = $conn->query("SELECT * FROM anime");
    // $total_rows = $records->num_rows;

    // // calculate number of pages, ceil for round up
    // $total_pages = ceil($total_rows/$skip);

    // get the current page number
    $page_number = 1;
    if (isset($_GET['page_number'])) {
        $page_number=$_GET['page_number'];
        $starter=($page_number-1)*$skip;
    }

    $search_zone= (isset($_GET['search_zone'])) ? trim($_GET['search_zone']) : "";

    // $search_zone="";
    // if (isset($_GET['search_zone'])) {
    //     $search_zone=trim($_GET['search_zone']);
    //     // $search_value = trim($_GET['search_zone']);
    // } 
    
    // $cate="";
    // if(isset($_GET['cate'])){
    //     $cate = trim($_GET['cate']);
    // } 

    $page_type='home';
    if (isset($_GET['page_type'])) {
        $page_type=$_GET['page_type'];
    } else {
        if (isset($_POST['page_type'])) {
            $page_type=$_POST['page_type'];
        } 
    }

                                  
    $sql = "
        SELECT * 
        FROM anime a 
        JOIN ani_cate ac ON a.anime_id = ac.anime_id 
        JOIN category c ON ac.cate_id = c.cate_id 
        WHERE a.anime_name LIKE '%$search_zone%'
        OR c.cate_name LIKE '%$search_zone%'
        OR a.price LIKE '%$search_zone%'
    ";
    $result = $conn->query($sql);

    $total_rows = $result->num_rows; 
    // echo $total_rows . " results found.<br>";
    $total_pages = ceil($total_rows/$skip);

        
    // Current user and anime ID from the database
    $current_user = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- font awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
        <!-- jquery -->
        <link rel="stylesheet" href="./css/style.css"> 

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        
        <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->

        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
        
    </head>
    <body>
        <?php
            include("$page_type.php");
        ?>


<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- jquery -->
<script src="js/wishlist.js"></script>
<script src="js/youtube_control.js"></script>

</body>
</html>