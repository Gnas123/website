




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
        
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
        
    </head>
    <body>


    <?php
    include("functions.php");
    include("connection.php");

    if(isset($_POST['input'])) {
        $search_zone = $_POST['input'];
        // $page_type = $_POST['page_type'];
        // $cate = $_POST['cate'];

        // $query = "
        //     SELECT * 
        //     FROM anime a 
        //     JOIN ani_cate ac ON a.anime_id = ac.anime_id 
        //     JOIN category c ON ac.cate_id = c.cate_id 
        //     WHERE CONCAT(a.anime_name, c.cate_name, a.price) LIKE '%$search_zone%' AND c.cate_name LIKE '%$cate%'
        // ";
        $query = "
            SELECT * 
            FROM anime a 
            JOIN ani_cate ac ON a.anime_id = ac.anime_id 
            JOIN category c ON ac.cate_id = c.cate_id 
            WHERE a.anime_name LIKE '%$search_zone%'
            OR c.cate_name LIKE '%$search_zone%'
            OR a.price LIKE '%$search_zone%'
        ";


        // $result = mysqli_query($conn, $query);
        $result = $conn->query($query);

        $data = [];


        if(mysqli_num_rows($result) > 0){
            ?>
                <ul class="dropdown-menu dropdown-menu-end" 
                    style="background-color: rgb(47, 63, 83); overflow-y: scroll; display: block; max-height: 200px;
                            width: max(250px, 100%);">
                    <?php
                        while($row = $result->fetch_assoc()){
                    ?>    
                        <form action="index.php" method="get">
                            <input type="hidden" name="page_type" value="anime">
                            <a class="dropdown-item" style="text-align: center;" href="index.php?page_type=anime&search_zone=<?php echo $row['anime_name']?>">
                                <?php echo $row['anime_name']; ?>
                            </a>
                        </form>
                    <?php
                        }
                    ?>
                </ul>

            <?php
        }
        else {
            $data[] = "No results found.";

            echo "<h6 class='text-danger text-center mt-3'>No results found.</h6>";
    
        }
    } 


?>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- jquery -->
<!-- navbar -->



</body>
</html>