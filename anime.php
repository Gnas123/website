<?php
// Path to your JSON file
$json_file = 'wishlist.json';

// // Load the JSON file data
if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $wishlists = json_decode($json_data, true);
} else {
    $wishlists = []; // Default to empty if the file doesn't exist
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
<body id="<?php echo $id?>" class="custom-body text-white">    
    <?php
        include_once("nav.php");
    ?>

    <!-- Main Content -->
    <main class="p-2" style="min-height: 100vh;">
        <div class="container-xxl mt-1">
            <section>
                <h2 class="h2 font-weight-bold mb-3">Available anime:</h2>
            </section>
<!-- list when doing searching... -->
<!-- show anime list -->
                <section>
                    <div class="d-flex flex-row row">
                        <?php
                            // $sql = "
                            //     SELECT * 
                            //     FROM anime a 
                            //     JOIN ani_cate ac ON a.anime_id = ac.anime_id 
                            //     JOIN category c ON ac.cate_id = c.cate_id 
                            //     WHERE CONCAT(a.anime_name, c.cate_name, a.price) LIKE '%$search_zone%'
                            //     LIMIT $starter, $skip
                            // ";


                            // $sql = "
                            //     SELECT * 
                            //     FROM anime a 
                            //     JOIN ani_cate ac ON a.anime_id = ac.anime_id 
                            //     JOIN category c ON ac.cate_id = c.cate_id 
                            //     WHERE a.anime_name LIKE '%$search_zone%'
                            //     OR c.cate_name LIKE '%$search_zone%'
                            //     OR a.price LIKE '%$search_zone%'
                            // ";
                            // $result = $conn->query($sql);

                            // $total_rows = $result->num_rows; 
                            // // echo $total_rows . " results found.<br>";
                            // $total_pages = ceil($total_rows/$skip);
                            // // echo $total_pages . " pages found.<br>";

                            $sql = "
                                SELECT * 
                                FROM anime a 
                                JOIN ani_cate ac ON a.anime_id = ac.anime_id 
                                JOIN category c ON ac.cate_id = c.cate_id 
                                WHERE a.anime_name LIKE '%$search_zone%'
                                OR c.cate_name LIKE '%$search_zone%'
                                OR a.price LIKE '%$search_zone%'
                                LIMIT $starter, $skip
                            ";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // echo $result->num_rows . " results found.<br>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    // echo "id: " . $row["anime_id"]. " - Title: " . $row["anime_name"]. " - Description: " . $row["description"]. "<br>";
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


<!-- dang trong qua trinh lam tiep -->
<!-- currently, display previous and next page button -->
<!-- pagination -->
        <div class="ms-3" style="position: relative;">
            <section class="d-flex justify-content-center">
            <?php
                if($total_rows > 0){
                    // echo "<h4 class='text-center'>Total: $total_rows results</h4>";
                    echo "<h4 class='text-center'>Page: $page_number of $total_pages pages</h4>";   
                } else {
                    echo "<h4 class='text-center text-danger m-3'>No results found</h4>";
                }
            ?>
            </section>
            <section>
                <div class="d-flex justify-content-center mt-4">
                    <div class="d-flex flex-wrap">
<!-- lhs -->
                    <?php
                        if($total_pages > 1){
                            $pre_page_number = ($page_number - 1 < 1) ? 1 : $page_number - 1;
                            ?>
<!-- go to first page -->
                            <a href="index.php?page_type=anime&page_number=1&search_zone=<?php echo $search_zone;?>"
                                class="btn btn-primary text-white d-flex align-items-center" style="text-decoration: none;">
                                First
                            </a>
<!-- previous page -->
                            <a href="index.php?page_type=anime&page_number=<?php echo $pre_page_number;?>&search_zone=<?php echo $search_zone;?>"
                                class="btn btn-primary text-white d-flex align-items-center ms-1 d-none d-md-inline-block" style="text-decoration: none">
                                <i class="fas fa-chevron-left mx-2"></i>
                                Previous
                            </a>
                            <?php
                        }
                    ?>
<!-- numbers of pages -->
                        <div id="pagination" class="btn-group ms-1 me-1" role="group">
                            <!-- <a href="#" class="btn btn-primary text-white">2</a> -->
                            <?php
                                for($i=1; $i<=$total_pages; $i++){
                            ?>
                                <a href="index.php?page_type=anime&page_number=<?php echo $i?>&search_zone=<?php echo $search_zone;?>"
                                    class="btn btn-primary text-white">
                                    <?php echo $i?>
                                </a>
                            <?php
                                }
                            ?>
                        </div>
<!-- rhs -->
                        <?php
                            if($total_pages > 1){
                                $next_page_number = ($page_number + 1 > $total_pages) ? $total_pages : $page_number + 1;                            
                                ?>
<!-- next page -->
                                        <a href="index.php?page_type=anime&page_number=<?php echo $next_page_number;?>&search_zone=<?php echo $search_zone;?>"
                                            class="btn btn-primary text-white d-flex align-items-center me-1 d-none d-md-inline-block" style="text-decoration: none">
                                            Previous
                                            <i class="fas fa-chevron-right mx-2"></i>
                                        </a>
<!-- go to last page -->
                                        <a href="index.php?page_type=anime&page_number=<?php echo $total_pages?>&search_zone=<?php echo $search_zone;?>"
                                            class="btn btn-primary text-white d-flex align-items-center" style="text-decoration: none;">
                                            Last
                                        </a>
                                    </div>          
                                <?php
                            }
                        ?>
            </section>
            </div>
        </div>
    </main>




<!-- footer -->
    <?php
        include_once("footer.php");
    ?>
    
    <script>
        // button color control
        let links=document.querySelectorAll('.btn-group a');
        let bodyID=parseInt(document.body.id)-1;
        links[bodyID].style.backgroundColor = '#5cc061';
    </script>

</body>
</html>



