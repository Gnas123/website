<?php
// Path to your JSON file
$json_file = 'wishlist.json';

// Load the JSON file data
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
                            $sql = "
                                SELECT * 
                                FROM anime a 
                            ";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {

                                    $anime_id = $row['anime_id'];

                                    $is_in_wishlist = isset($wishlists[$current_user]) && in_array($anime_id, $wishlists[$current_user]);
                                    
                                    if($is_in_wishlist){
                                        include("template.php");
                                    }
                                }                                        
                            } else {
                                ?>
                                <h1>No results found.</h1>
                                <div class="d-flex justify-content-center" style="height: 100%;">
                                    <img loading="lazy" src="https://media.tenor.com/i9UkjLlNlt4AAAAC/anime-sorry.gif" alt="Description of the image" class="img-fluid">
                                </div>
                             
                                <?php
                            }
                                // if(!empty($search_zone)){
                                // }
                            
                        ?>
                    </div>    
                </section>    
        </div>    
    </main>




<!-- footer -->
    <?php
        include_once("footer.php");
    ?>
    
    <script>
        let links=document.querySelectorAll('.btn-group a');
        let bodyID=parseInt(document.body.id)-1;
        links[bodyID].style.backgroundColor = '#5cc061';
    </script>
    <script src="js/wishlist.js"></script>
</body>
</html>



