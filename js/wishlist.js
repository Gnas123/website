$(document).ready(function () {
    $(".add_to_list_btn").click(function (event) {
        event.preventDefault(); // Prevent default behavior
        let username = $(this).data("user");
        let animeId = $(this).data("animeid");

        if(username=="") {
            alert("Please login to add to your wishlist.");
            return;
        }

        $.ajax({
            url: "modify_wishlist.php",
            type: "POST",
            data: {
                username: username,
                anime_id: animeId,
                action: "add",
            },
            success: function (response) {
                console.log(response);
                // $("#check_icon1" + animeId).removeClass("d-none");
                // $("#check_icon2" + animeId).removeClass("d-none");
                // $("#yeuthich_icon1" + animeId).addClass("d-none");
                // $("#yeuthich_icon2" + animeId).addClass("d-none");
                alert("Anime ID " + animeId + " added successfully for " + username + "!");
            },
            error: function () {
                alert("Error occurred while adding anime.");
            }
        });
    });

    $(".remove_from_list_btn").click(function (event) {
        event.preventDefault(); // Prevent default behavior
        let username = $(this).data("user");
        let animeId = $(this).data("animeid");

        if(username=="") {
            alert("Error !!!");
            return;
        }

        $.ajax({
            url: "modify_wishlist.php",
            type: "POST",
            data: {
                username: username,
                anime_id: animeId,
                action: "remove",
            },
            success: function (response) {
                console.log(response);
                // $("#yeuthich_icon1" + animeId).removeClass("d-none");
                // $("#yeuthich_icon2" + animeId).removeClass("d-none");
                // $("#check_icon1" + animeId).addClass("d-none");
                // $("#check_icon2" + animeId).addClass("d-none");
                alert("Anime ID " + animeId + " removed successfully for " + username + "!");
            },
            error: function () {
                alert("Error occurred while removing anime.");
            }
        });
    });
});