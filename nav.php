<?php

?>

<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">

    <!-- left items of navbar -->
            <a class="navbar-brand" href="http://localhost/website/">
                <img alt="Logo" class="float-start img-fluid" height="40" width="40"
                    src="https://i.pinimg.com/736x/0f/d4/9c/0fd49ce9e2ac49b069e68f1e005019e4.jpg"/>                           
            </a>
            
            <!-- logo here -->
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- anime button -->
                    <!-- <form action="index.php" method="get" class="nav-item">
                        <li class="nav-item">
                        <input type="hidden" name="page_type" value="anime">

                            <button type="submit" class="navbutton text-white nav-link">Anime</button>
                            
                        </li>
                    </form> -->
                    <li class="nav-item">
                        <a class="navbutton text-white nav-link w-100" href="?page_type=anime">Anime</a>
                        <!-- <a class="navbutton text-white nav-link w-100" href="/website/anime123">Anime</a> -->
                    </li>
                    <!-- <li class="nav-item">
                        <button id="test">test</button>
                    </li> -->
        <!-- new button -->
                    <li class="nav-item">
                        <a class="navbutton text-white nav-link w-100" href="?page_type=map">Map</a>
                    </li>
        <!-- categories button -->
                    <li class="nav-item dropdown" style="text-align: center;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" style="background-color: rgb(47, 63, 83);">
                            <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                            <?php
                                $cate_button = $conn->query("SELECT * FROM category");
                                while($row = $cate_button->fetch_assoc()){
                            ?>    
                                <a style="text-align: center;" href="?page_type=anime&search_zone=<?php echo $row['cate_name']?>"><?php echo $row['cate_name']?></a>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                </ul>


        <!-- right items of navbar --> 
                <form class="d-flex align-items-center justify-content-center" role="search">
                    <input type="hidden" name="page_type" value="anime">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    <div class="dropdown">
                        <input class="form-control me-2" id="search_zone" name="search_zone" type="search" placeholder="Search" aria-label="Search">
                        <ul id="search_res" class="dropdown-menu dropdown-menu-end"
                            style=" position: absolute; background-color: rgba(255, 255, 255, 0); display: none; border: none;">
                        </ul>
                    </div>
                </form>
        <!-- muc yeu thich va login -->
                <div class="d-flex align-items-center justify-content-center mt-1">
                    <a href="index.php?page_type=anime_wishlist" class="text-white move-up-icon">
                        <i class="fas fa-bookmark fa-lg mx-3"></i>
                    </a>
                    
                    <?php
                        // login roi thi logout, chua thi login vao
                        // if (isset($_POST['logout'])){
                        //     // $_SESSION['islogin'] = false;
                        // }
                        
                        if(isset($_SESSION['islogin']) && $_SESSION['islogin']==true){
                            // login thanh cong
                            // $username = $_SESSION['username'];
                            echo $_SESSION['username'];
                            
                            $usertype = getUserType();
                            if($usertype && $usertype == "admin"){
                                echo '<i class="fa-solid fa-crown fa-lg ms-1"></i>';
                            }
                            echo '
                                <form id="logout-form" action="index.php" method="post">
                                    <button type="submit" style="color: white; border: none; background-color: transparent;"
                                        name="page_type" value="home">
                                        <i class="move-up-icon fa-solid fa-right-from-bracket fa-lg"></i>
                                    </button>
                                    <input type="hidden" name="logout" value="logout">
                                </form>
                            ';
                        } else {
                            // chua login
                            echo '
                                <form id="login-form" action="index.php" method="get">
                                    <button type="submit" style="color: white; border: none; background-color: transparent;"
                                        name="page_type" value="login">
                                        <i class="move-up-icon fas fa-user fa-lg"></i>  
                                    </button>
                                </form>
                            ';
                        }
                    ?>

                    
                    
                </div>

            </div>
        </div>
    </nav>
</header>


<!-- navbar -->
<script>
    $(document).ready(function(){
        // console.log("jQuery is ready!");

        // $("#test").click(function() {
        //     alert("Button clicked!");
        // });

        $("#search_zone").keyup(function(){
            var input = $(this).val();      // nhan input
            // alert(input);

            if (input != ""){
                $("#search_res").css("display", "block"); // neu khong co input thi xoa ket qua

                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: {input: input},
                    // data: {input: input}

                    success: function(data){
                        $("#search_res").html(data); // hien thi ket qua
                        // var results=JSON.parse(data);

                    }
                });

            } else {
                $("#search_res").css("display", "none"); // neu khong co input thi xoa ket qua
            }

        })
        
    // end jquery
    });
</script>






















