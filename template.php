<!-- template 1 -->
<div class="col-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center align-items-stretch">
                                            <button class="card p-0" style="background-color: rgb(25, 34, 53);"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#animeModal<?php echo $row['anime_id']?>">
                                                <!-- end Modal -->


                                                <img loading="lazy" src="<?php echo $row["small_href"]; ?>"  
                                                        alt="Template preview" class="card-img-top">
                                                <div class="card-body text-white">
                                                    <h5 class="card-title small font-weight-bold"><?=$row["anime_name"];?></h5>
                                                    <p class="card-text small">
                                                        <?php
                                                            // if ($row["sub"]) {
                                                            //     echo "Subtitled";
                                                            // } else {
                                                            //     echo "No sub";
                                                            // }
                                                            // // echo $row["cate_name"];
                                                            if (number_format($row["price"], 2) > 0) {
                                                                echo "$" . number_format($row["price"], 2); // Full price
                                                            } else {
                                                                echo "Free"; // Or use "$" . number_format($row["price"] * 0.8, 2) for discount
                                                            }
                                                        ?>
                                                    </p>
                                                    <?php
                                                        $anime_id = $row['anime_id'];

                                                        // Check if the anime is in the user's wishlist
                                                        $is_in_wishlist = isset($wishlists[$current_user]) && in_array($anime_id, $wishlists[$current_user]);
                                                        
                                                        // echo $current_user . " " . $anime_id . "<br>";
                                                        // echo isset($wishlists[$current_user]) ? "co user" : "ko user";
                                                        // echo $is_in_wishlist ? "In wishlist" : "Not in wishlist";
                                                        if ($is_in_wishlist ){
                                                            ?>
                                                                <i id="check_icon1<?=$row['anime_id'];?>" 
                                                                    data-user="<?=$current_user;?>"
                                                                    data-animeId="<?=$row['anime_id'];?>"
                                                                    class="remove_from_list_btn move-up-icon fa-solid fa-circle-check fa-lg position-absolute p-2"
                                                                    style="bottom: 13px; right: 6px;"></i>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <!-- <i class="fas fa-bookmark fa-lg move-up-icon p-2"></i> -->
                                                                <i id="yeuthich_icon1<?=$row['anime_id'];?>" 
                                                                    data-user="<?=$current_user;?>"
                                                                    data-animeId="<?=$row['anime_id'];?>"
                                                                    class="add_to_list_btn move-up-icon fas fa-bookmark fa-lg position-absolute p-2"
                                                                    style="bottom: 13px; right: 6px;"></i>                                                          
                                                                        <?php
                                                                    }
                                                            ?>
                                                </div>
                                                <!-- hover content -->
                                                <div class="container content d-flex flex-column">
                                                    <p><?=$row["description"];?></p>
                                                    <!-- <i class="fas fa-bookmark fa-lg move-up-icon p-2"></i> -->
                                                    <?php
                                                        // echo $is_in_wishlist ? "In wishlist" : "Not in wishlist";
                                                        if ($is_in_wishlist){
                                                            ?>
                                                                <i id="check_icon2<?=$row['anime_id'];?>" 
                                                                    data-user="<?=$current_user;?>"
                                                                    data-animeId="<?=$row['anime_id'];?>"
                                                                    class="remove_from_list_btn move-up-icon fa-solid fa-circle-check fa-lg position-absolute end-0 p-2"
                                                                    style="bottom: 10px;"></i>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <i id="yeuthich_icon2<?=$row['anime_id'];?>" 
                                                                    data-user="<?=$current_user;?>"
                                                                    data-animeId="<?=$row['anime_id'];?>"
                                                                    class="add_to_list_btn move-up-icon fas fa-bookmark fa-lg position-absolute end-0 p-2"
                                                                    style="bottom: 10px;"></i>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="animeModal<?php echo $row['anime_id']?>" tabindex="-1" aria-labelledby="animeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl text-dark">
                                                    <div class="modal-content" style="background-color: rgb(20, 35, 43);">
                                                    <!-- <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="animeModalLabel">Modal title</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div> -->
                                                    <div class="modal-body">
                                                        <iframe
                                                            style="height: min(1000px, 701px); width: min(100%, 1309px); border: none;"
                                                            src="https://www.youtube.com/embed/videoseries?list=<?php echo $row['youtube_link']?>"
                                                            title="YouTube playlist"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                    <!-- <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->

                                        </div>