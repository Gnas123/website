<?php
    // session_start();



    if (isset($_POST['addusername'])){
        // include_once("connection.php");
        // include_once("functions.php");
        if(setRegister($conn, $_POST['addusername'], $_POST['addpassword'], $_POST['addemail'])){
            echo "<script>
                alert('Register successfully!');
                window.location.href = 'index.php?page_type=home';
            </script>";
        } else {
            echo "<script>
                alert('Register fail!');
                window.location.href = 'index.php?page_type=home';
            </script>";
        }
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Anime Page</title>
</head>

<?php
    if (isset($_GET['page_number'])) {
        $id =$_GET['page_number'];
    }else{
        $id = 1;
    }
?>
<body id="<?php echo $id?>" class="custom-body text-white" style="min-height: 100vh;">    
    <?php
        include_once("nav.php");
    ?>


    <!-- carousel slide -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="true">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images4.alphacoders.com/134/thumb-1920-1340929.jpeg" 
                    class="d-block w-100" alt="sousou no friren background">
            </div>
            <div class="carousel-item">
                <img src="https://cdn.wallpapersafari.com/57/17/AJCPyt.jpg" 
                    class="d-block w-100" alt="I'vn been killing slimes for 300 years background">
            </div>    
            <div class="carousel-item">
                <img src="https://image.tmdb.org/t/p/original/O73v49LoRycd7wv3Eme7heciZv.jpg" 
                    class="d-block w-100" alt="Pseudo harem background">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
<!-- carousel slide end-->



<!-- admin and database management -->
    <?php

        // check login chua? ko thi di toi cho login
        $user_type=getUserType();
        if ($user_type == "admin") {
            // echo "Dang nhap voi quyen admin";
            ?>
                <!-- search bar -->
                <main class="p-2">
                    <div class="container-xxl mt-1 d-flex justify-content-center align-items-center">
                        <!-- ajax search + CRUD -->
                        <div class="custom-search-bar d-flex align-items-center rounded-pill w-50">
                            <span class="text-dark fa-solid fa-magnifying-glass ms-2"></span>
                            <input
                                type="text" name="search_zone_db" id="search_zone_db"
                                class="custom-tim-kiem border-0 flex-grow-1 rounded-pill"
                                placeholder="Tìm kiếm"
                            >
                        </div>
                        <button class="btn btn-primary mt-4 ms-4"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            Add user
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h1 class="modal-title fs-5" id="addUserModalLabel">Add user</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="index.php" method="post">
                                    <div class="modal-body text-dark">
                                        <div class="mb-3">
                                            <label for="addusername" class="form-label"><strong>Username</strong></label>
                                            <input type="text" class="form-control" name="addusername" id="addusername" aria-describedby="usernameHelp" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="addemail" class="form-label"><strong>Email address</strong></label>
                                            <input type="email" class="form-control" name="addemail" id="addemail" aria-describedby="emailHelp" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="addpasswork" class="form-label"><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="addpasswork" id="addpasswork" required>
                                        </div>
                                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                    </div>
                                    <div class="modal-footer text-dark">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal end -->
                    </div>


                    <div class="container mt-4 d-flex justify-content-center align-items-center">
                        <div id="search_res_db" class="w-100"
                            style="overflow-y: scroll; display: block; max-height: 300px;"></div>
                    </div>

                </main>

            <!-- search DB -->
            <script>
            $(document).ready(function() {
                $("#search_zone_db").keyup(function() {
                    var input = $(this).val(); // Get input from search box
                    
                    // AJAX request to fetch data
                    $.ajax({
                        url: "searchDB.php",
                        method: "POST",
                        data: { input: input }, // Pass input to server-side
                        success: function(data) {
                            $("#search_res_db").html(data); // Display data in the container
                        }
                    });
                });

                // Trigger AJAX to load all data when the page loads
                $.ajax({
                    url: "searchDB.php",
                    method: "POST",
                    data: { input: "" }, // Send empty input for initial load
                    success: function(data) {
                        $("#search_res_db").html(data); // Display all data
                    }
                });
            });
                
            </script>
            <?php
        } 
    ?>
















<!-- 3 lastest anime -->

<?php
        $user_type=getUserType();
        if ($user_type != "admin") {
            ?>
            <main class="p-2">
                <div class="container-xxl mt-1">
                    <section class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h2 font-weight-bold">Lastest anime:</h2>
                    </section>
        <!-- list when doing searching... -->
        <!-- show anime list -->
                    <section>
                        <div class="d-flex flex-row row">
                            <?php
                                $sql = "
                                    SELECT * 
                                    FROM anime a 
                                    JOIN ani_cate ac ON a.anime_id = ac.anime_id 
                                    JOIN category c ON ac.cate_id = c.cate_id 
                                    WHERE a.anime_name LIKE '%$search_zone%'
                                    OR c.cate_name LIKE '%$search_zone%'
                                    OR a.price LIKE '%$search_zone%'
                                    ORDER BY a.anime_id DESC
                                    LIMIT 3;
                                ";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        include("template.php");
                                    }                                        
                                } else {
                                    ?>
                                    <h1>No results found.</h1>
                                    <div class="d-flex justify-content-center" style="height: 100%;">
                                        <img loading="lazy" src="https://media.tenor.com/i9UkjLlNlt4AAAAC/anime-sorry.gif" alt="Description of the image" class="img-fluid">
                                    </div>
                                    
                                    <?php
                                }
                            ?>
                        </div>    
                    </section>    
                </div>    
            </main>
            <?php
        } 
?>
    















































<!-- footer -->
    <?php
        include_once("footer.php");
    ?>
    
    <script>
        let links=document.querySelectorAll('.btn-group button');
        let bodyID=parseInt(document.body.id)-1;
        links[bodyID].style.backgroundColor = '#5cc061';
    </script>


</body>
</html>



